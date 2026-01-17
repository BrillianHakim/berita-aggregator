<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;

        $articles = Article::with(['category', 'source'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('search', compact(
            'query',
            'articles',
            'categories'
        ));
    }
}
