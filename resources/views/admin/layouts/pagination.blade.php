@php
    $paginator = $paginator ?? $menus;
@endphp

<nav aria-label="Page navigation" class="pagination-style-3 text-end" style="float: right">
    <ul class="pagination mb-0 flex-wrap">
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" {{ $paginator->onFirstPage() ? 'aria-disabled="true"' : '' }}>
                Prev
            </a>
        </li>

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0);">{{ $page }}</a>
                        </li>
                    @elseif ($page === '...')
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link text-primary" href="{{ $paginator->nextPageUrl() }}" {{ $paginator->hasMorePages() ? '' : 'aria-disabled="true"' }}>
                Next
            </a>
        </li>
    </ul>
</nav>
