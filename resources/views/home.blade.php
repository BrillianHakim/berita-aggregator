@extends('layouts.app')

@section('title', 'BeritaKu – Indonesian News Aggregator')

@section('content')

<style>
    .pagination {
        justify-content: center;
    }

    .page-link {
        border-radius: 50px;
        margin: 0 4px;
        color: #0d6efd;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

{{-- ========================= --}}
{{-- HEADLINE GRID (5 BERITA) --}}
{{-- ========================= --}}
@if ($articles->count() >= 5)
    @php
        $headlineArticles = $articles->take(5)->values();
    @endphp

    <div class="row g-3 mb-4">

        {{-- KIRI : HEADLINE BESAR --}}
        <div class="col-lg-6">
            <div
                class="card h-100 border-0 text-white position-relative overflow-hidden"
                style="
                    background-image: url('{{ asset($headlineArticles[0]->source->image ?? 'images/sources/default.png') }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                "
            >
                {{-- OVERLAY GRADIENT --}}
                <div
                    class="position-absolute top-0 start-0 w-100 h-100"
                    style="
                        background: linear-gradient(
                            to bottom,
                            rgba(0, 0, 0, 0.25),
                            rgba(0, 0, 0, 0.85)
                        );
                    "
                ></div>

                {{-- CONTENT --}}
                <div class="card-body d-flex flex-column justify-content-end position-relative">
                    <h3 class="fw-bold">
                        <a
                            href="{{ $headlineArticles[0]->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-white text-decoration-none"
                        >
                            {{ $headlineArticles[0]->title }}
                        </a>
                    </h3>

                    <p class="text-white-75 mb-3">
                        {{ Str::limit($headlineArticles[0]->summary, 160) }}
                    </p>

                    <a
                        href="{{ $headlineArticles[0]->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-light btn-sm align-self-start"
                    >
                        Baca Selengkapnya ↗
                    </a>
                </div>
            </div>
        </div>

        {{-- TENGAH --}}
        <div class="col-lg-3 d-flex flex-column gap-3">
            @foreach ($headlineArticles->slice(1, 2) as $article)
                <div class="card border-0 shadow-sm h-100">
                    <img
                        src="{{ asset($article->source->image ?? 'images/sources/default.png') }}"
                        class="card-img-top p-3"
                        style="height: 100px; object-fit: contain; background: #f8f9fa;"
                        alt="{{ $article->source->name }}"
                    >

                    <div class="card-body">
                        <span class="badge bg-primary mb-1">
                            {{ $article->category->name }}
                        </span>

                        <a
                            href="{{ $article->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-decoration-none text-dark"
                        >
                            <h6 class="fw-bold mb-1">
                                {{ Str::limit($article->title, 60) }}
                            </h6>
                        </a>

                        <small class="text-muted">
                            {{ $article->published_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- KANAN --}}
        <div class="col-lg-3 d-flex flex-column gap-3">
            @foreach ($headlineArticles->slice(3, 2) as $article)
                <div class="card border-0 shadow-sm h-100">
                    <img
                        src="{{ asset($article->source->image ?? 'images/sources/default.png') }}"
                        class="card-img-top p-3"
                        style="height: 100px; object-fit: contain; background: #f8f9fa;"
                        alt="{{ $article->source->name }}"
                    >

                    <div class="card-body">
                        <span class="badge bg-primary mb-1">
                            {{ $article->category->name }}
                        </span>

                        <a
                            href="{{ $article->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-decoration-none text-dark"
                        >
                            <h6 class="fw-bold mb-1">
                                {{ Str::limit($article->title, 60) }}
                            </h6>
                        </a>

                        <small class="text-muted">
                            {{ $article->published_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endif
{{-- END HEADLINE GRID --}}

{{-- ========================= --}}
{{-- LIST BERITA (GRID MSN) --}}
{{-- ========================= --}}
<div class="row">
    <div class="col-lg-12">

        @foreach ($articles->skip(5) as $article)
            <div class="card mb-3 border-0 shadow-sm">
                <div class="row g-0">

                    <div class="col-md-3 d-flex align-items-center justify-content-center bg-light">
                        <img
                            src="{{ asset($article->source->image ?? 'images/sources/default.png') }}"
                            class="img-fluid p-3"
                            style="max-height: 90px; object-fit: contain;"
                            alt="{{ $article->source->name }}"
                        >
                    </div>

                    <div class="col-md-9">
                        <div class="card-body">

                            <span class="badge bg-primary mb-2">
                                {{ $article->source->name }}
                            </span>

                            <a
                                href="{{ $article->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-decoration-none text-dark"
                            >
                                <h5 class="fw-bold">
                                    {{ $article->title }}
                                </h5>
                            </a>

                            <p class="text-muted mb-1">
                                {{ Str::limit($article->summary, 120) }}
                            </p>

                            <small class="text-secondary">
                                {{ $article->published_at->diffForHumans() }}
                            </small>

                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        {{ $articles->links('pagination.rounded') }}

    </div>
</div>

@endsection