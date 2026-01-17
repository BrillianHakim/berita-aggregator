<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    // HALAMAN /kategori
    public function index()
    {
        $categories = Category::withCount('articles')->get();

        return view('category.index', compact('categories'));
    }

    // HALAMAN /kategori/{slug}
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $perPage = 10;
        $page = request()->get('page', 1);

        $collection = Article::with('source')
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->take(50)
            ->get()
            ->shuffle();

        $articles = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        $articles->onEachSide(2);

        return view('category.show', compact('category', 'articles'));
    }
}
