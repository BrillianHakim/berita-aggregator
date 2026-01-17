<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LatestController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/kategori/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/artikel/{id}', [ArticleController::class, 'show'])
    ->name('article.show');

Route::get('/search', [SearchController::class, 'index'])
    ->name('search');

// Artikel Terbaru
Route::get('/terbaru', [\App\Http\Controllers\LatestController::class, 'index'])
    ->name('latest');
