@if ($paginator->hasPages())
    <nav role="navigation" aria-label="পেজিনেশন নেভিগেশন">
        <ul class="pagination pagination-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">আগের</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">আগের</a>
                </li>
            @endif

            {{-- Current Page Number --}}
            <li class="page-item active">
                <span class="page-link">{{ $paginator->firstItem() }} থেকে {{ $paginator->lastItem() }} দেখানো হচ্ছে</span>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">পরের</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">পরের</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
