<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::with('source')->findOrFail($id);
        $categories = Category::all();

        return view('article', compact('article', 'categories'));
    }
}
