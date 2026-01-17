@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link rounded-circle">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link rounded-circle"
                   href="{{ $paginator->previousPageUrl() }}"
                   rel="prev">&lsaquo;</a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)

            {{-- "Three Dots" --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link rounded-circle">{{ $element }}</span>
                </li>
            @endif

            {{-- Page Numbers --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link rounded-circle">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-circle"
                               href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link rounded-circle"
                   href="{{ $paginator->nextPageUrl() }}"
                   rel="next">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link rounded-circle">&rsaquo;</span>
            </li>
        @endif

    </ul>
</nav>
@endif