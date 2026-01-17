<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\Article;
use App\Models\Category; 
use App\Models\Source;
use Illuminate\Pagination\LengthAwarePaginator;
class HomeController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = request()->get('page', 1);

        // Ambil semua source KECUALI Kaskus
        $sources = Source::where('name', '!=', 'Kaskus')->get();

        $articlesCollection = collect();

        foreach ($sources as $source) {
            $articles = Article::with('source')
                ->where('source_id', $source->id)
                ->latest('published_at')
                ->take(10) // BATASI PER SOURCE
                ->get();

            $articlesCollection = $articlesCollection->merge($articles);
        }

        // Acak agar tidak berurutan per source
        $articlesCollection = $articlesCollection->shuffle();

        // Manual pagination
        $articles = new LengthAwarePaginator(
            $articlesCollection->forPage($page, $perPage),
            $articlesCollection->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        $articles->onEachSide(2);

        $categories = Category::all();

        return view('home', compact('articles', 'categories'));
    }
}
