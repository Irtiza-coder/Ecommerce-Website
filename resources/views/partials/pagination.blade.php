@if ($paginator->hasPages())
    <nav class="shop_pagination_nav" aria-label="Shop Pagination">
        @if ($paginator->onFirstPage())
            <span class="shop_page_arrow disabled" aria-disabled="true" aria-label="Previous">&larr;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="shop_page_arrow" rel="prev" aria-label="Previous">&larr;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="shop_page_dots">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="shop_page_btn active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="shop_page_btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="shop_page_arrow" rel="next" aria-label="Next">&rarr;</a>
        @else
            <span class="shop_page_arrow disabled" aria-disabled="true" aria-label="Next">&rarr;</span>
        @endif
    </nav>
@endif