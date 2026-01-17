@extends('layouts.app')

@section('title', 'Pencarian: ' . $query)

@section('content')

<h4 class="mb-4 mt-2">
    Hasil pencarian untuk: <strong>"{{ $query }}"</strong>
</h4>

@forelse($articles as $article)
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">

            <div class="mb-2">
                <span class="badge bg-primary">
                    {{ $article->category->name }}
                </span>
                <span class="badge bg-secondary">
                    {{ $article->source->name }}
                </span>
            </div>

            <a href="{{ route('article.show', $article->id) }}"
               class="text-decoration-none text-dark">
                <h5 class="fw-bold">{{ $article->title }}</h5>
            </a>

            <p class="text-muted">
                {{ Str::limit($article->summary, 150) }}
            </p>

            <small class="text-secondary">
                {{ $article->published_at->diffForHumans() }}
            </small>
        </div>
    </div>
@empty
    <p>Tidak ada berita yang cocok.</p>
@endforelse

{{ $articles->links('pagination::bootstrap-5') }}

@endsection
