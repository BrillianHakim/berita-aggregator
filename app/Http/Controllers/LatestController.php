<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class LatestController extends Controller
{
    public function index()
    {
        $perPage = 10;        // artikel per halaman
        $maxPages = 5;        // maksimal pagination
        $page = request()->get('page', 1);

        // 🔹 Ambil artikel terbaru tapi DIBATASI
        $collection = Article::with(['source', 'category'])
            ->whereHas('category', function ($q) {
                // optional: exclude opini
                // $q->where('slug', '!=', 'opini');
            })
            ->latest('published_at')
            ->take($perPage * $maxPages) // contoh: 10 x 5 = 50 artikel
            ->get()
            ->shuffle(); // 🔥 biar tidak kaku terbaru-terlama

        // 🔹 Pagination manual
        $articles = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        // 🔹 Batasi tampilan pagination
        $articles->onEachSide(1);

        $categories = Category::all();

        return view('latest.index', compact('articles', 'categories'));
    }
}
