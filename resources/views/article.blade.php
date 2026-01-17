<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $article->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@extends('layouts.app')

<nav class="navbar navbar-expand-lg bg-white fixed-top">
    <div class="container">

        <!-- BRAND -->
        <a class="navbar-brand" href="/">
            BeritaKu
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- CATEGORY -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                @foreach($categories->take(5) as $category)
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- SEARCH -->
            <form class="d-flex" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2 search-input"
                       type="search"
                       name="q"
                       placeholder="Cari berita..."
                       value="{{ request('q') }}">
                <button class="btn btn-primary btn-search" type="submit">
                    Cari
                </button>
            </form>

        </div>
    </div>
</nav>

<div class="container">

    <h2 class="mb-3">{{ $article->title }}</h2>

    <p class="text-muted mb-4 mt-5">
        {{ $article->source->name }} •
        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
    </p>

    <p>{{ $article->summary }}</p>

    <a href="{{ $article->url }}" target="_blank"
       class="btn btn-primary mt-3">
        🔗 Baca selengkapnya di {{ $article->source->name }}
    </a>

</div>

</body>
</html>
