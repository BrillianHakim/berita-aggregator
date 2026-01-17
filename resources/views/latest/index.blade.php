@extends('layouts.app')

@section('title', 'Artikel Terbaru - BeritaKu')

@section('content')

<h3 class="mb-4 fw-bold">Terbaru</h3>

@foreach($articles as $article)
    <div class="card mb-3 border-0 shadow-sm">
        <div class="row g-0">

            <div class="col-md-3 d-flex align-items-center justify-content-center bg-light">
                <img src="{{ asset($article->source->image ?? 'images/sources/default.png') }}"
                     class="img-fluid p-3"
                     style="max-height:90px; object-fit:contain"
                     alt="{{ $article->source->name }}">
            </div>

            <div class="col-md-9">
                <div class="card-body">

                    <div class="mb-1">
                        <span class="badge bg-primary">
                            {{ $article->category->name }}
                        </span>
                        <span class="badge bg-light text-dark border">
                            {{ $article->source->name }}
                        </span>
                    </div>

                    <a href="{{ $article->url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="text-decoration-none text-dark">
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

@endsection
