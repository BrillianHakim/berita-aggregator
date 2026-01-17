<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RssService
{
    public function fetchAll()
    {
        foreach (config('rss') as $feed) {

            $response = Http::timeout(15)->get($feed['url']);
            if (!$response->successful()) {
                continue;
            }

            libxml_use_internal_errors(true);

            $xml = preg_replace(
                '/&(?!amp;|lt;|gt;|quot;|apos;)/',
                '&amp;',
                $response->body()
            );

            $rss = simplexml_load_string(
                $xml,
                'SimpleXMLElement',
                LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET
            );

            libxml_clear_errors();

            // 🔹 SUPPORT BERBAGAI FORMAT RSS
            if (isset($rss->channel->item)) {
                $items = $rss->channel->item;
            } elseif (isset($rss->item)) {
                $items = $rss->item;
            } elseif (isset($rss->entry)) {
                $items = $rss->entry;
            } else {
                continue;
            }

            // 🔹 AMBIL CATEGORY
            $category = Category::where('slug', $feed['category'])->first();
            if (!$category) {
                Log::warning('CATEGORY NOT FOUND', $feed);
                continue;
            }

            // 🔹 AMBIL / BUAT SOURCE
            $source = Source::firstOrCreate(
                ['name' => $feed['name']],
                [
                    'website' => $feed['url'],
                    'image' => match ($feed['name']) {
                        'BBC Indonesia'      => 'images/sources/bbc.png',
                        'Republika'          => 'images/sources/republika.png',
                        'Kaskus'             => 'images/sources/kaskus.png',
                        'Al Jazeera'           => 'images/sources/aljazeera.png',
                        'Media Indonesia'    => 'images/sources/media-indonesia.png',
                        'BBC Sport'          => 'images/sources/bbc-sport.png',
                        'CNBC Indonesia - Ekonomi' => 'images/sources/cnbc.png',
                        default              => 'images/sources/default.png',
                    }
                ]
            );

            foreach ($items as $item) {

    // =============================
    // AMBIL LINK SECARA AMAN
    // =============================
    $link = null;

    if (isset($item->link)) {
        $link = (string) $item->link;
    }

    // Atom <link href="">
    if (!$link && isset($item->link['href'])) {
        $link = (string) $item->link['href'];
    }

    if (!$link) {
        Log::warning('SKIP ITEM TANPA LINK', [
            'source' => $feed['name'],
            'title' => (string) $item->title
        ]);
        continue; // ⛔ WAJIB
    }

    // =============================
    // SUMMARY
    // =============================
    $summary = (string)(
        $item->description
        ?? $item->children('content', true)->encoded
        ?? ''
    );

    $summary = trim(strip_tags($summary));
    if ($summary === '') {
        $summary = '(Ringkasan tidak tersedia)';
    }

    // =============================
    // IMAGE
    // =============================
    $image = $this->extractImageFromItem($item);
    if (!$image) {
        $image = $this->fetchOgImage($link);
    }

    // =============================
    // KHUSUS KASKUS → CREATE
    // =============================
    if ($feed['name'] === 'Kaskus') {

        Article::create([
            'url'          => $link . '#' . uniqid(),
            'title'        => (string) $item->title ?: 'Judul tidak tersedia',
            'summary'      => $summary,
            'image'        => $image,
            'published_at' => now(),
            'category_id'  => $category->id,
            'source_id'    => $source->id,
        ]);

        continue;
    }

    // =============================
    // MEDIA BERITA
    // =============================
    Article::updateOrCreate(
        ['url' => $link],
        [
            'title'        => (string) $item->title,
            'summary'      => $summary,
            'image'        => $image,
            'published_at' => now(),
            'category_id'  => $category->id,
            'source_id'    => $source->id,
        ]
    );
}

        }
    }

    /* ==========================
       IMAGE HELPERS
       ========================== */

    private function extractImageFromItem($item): ?string
    {
        // media:content
        if (isset($item->children('media', true)->content)) {
            return (string) $item->children('media', true)
                ->content
                ->attributes()
                ->url;
        }

        // enclosure
        if (isset($item->enclosure)) {
            return (string) $item->enclosure->attributes()->url;
        }

        // img in description
        if (isset($item->description)) {
            preg_match(
                '/<img[^>]+src=["\']([^"\']+)["\']/',
                (string) $item->description,
                $matches
            );
            return $matches[1] ?? null;
        }

        return null;
    }

    private function fetchOgImage(string $url): ?string
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (BeritaKu Bot)'
                ])
                ->get($url);

            if (!$response->successful()) {
                return null;
            }

            preg_match(
                '/<meta property=["\']og:image["\'] content=["\']([^"\']+)["\']/',
                $response->body(),
                $matches
            );

            return $matches[1] ?? null;

        } catch (\Exception $e) {
            return null;
        }
    }
}
