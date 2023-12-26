@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link d-flex align-items-center" aria-hidden="true">
					<svg class="mr-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M7.17738 1.18123C7.51212 1.51596 7.51212 2.05868 7.17738 2.39341L2.64061 6.93018L7.17738 11.4669C7.51212 11.8017 7.51212 12.3444 7.17738 12.6791C6.84265 13.0139 6.29993 13.0139 5.9652 12.6791L0.82234 7.53627C0.487605 7.20153 0.487605 6.65882 0.82234 6.32408L5.9652 1.18123C6.29993 0.846492 6.84265 0.846492 7.17738 1.18123Z" fill="#98A9BC"></path>
					</svg>
					Prev
					</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link d-flex align-items-center" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
					<svg class="mr-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M7.17738 1.18123C7.51212 1.51596 7.51212 2.05868 7.17738 2.39341L2.64061 6.93018L7.17738 11.4669C7.51212 11.8017 7.51212 12.3444 7.17738 12.6791C6.84265 13.0139 6.29993 13.0139 5.9652 12.6791L0.82234 7.53627C0.487605 7.20153 0.487605 6.65882 0.82234 6.32408L5.9652 1.18123C6.29993 0.846492 6.84265 0.846492 7.17738 1.18123Z" fill="#98A9BC"></path>
					</svg>
					Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link d-flex align-items-center" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
					Next
						<svg class="ml-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.82234 1.19783C1.15708 0.863094 1.69979 0.863094 2.03452 1.19783L7.17738 6.34069C7.51212 6.67542 7.51212 7.21813 7.17738 7.55287L2.03452 12.6957C1.69979 13.0305 1.15708 13.0305 0.82234 12.6957C0.487605 12.361 0.487605 11.8183 0.82234 11.4835L5.35911 6.94678L0.82234 2.41001C0.487605 2.07528 0.487605 1.53256 0.82234 1.19783Z" fill="#98A9BC"></path>
						  </svg>
					</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link d-flex align-items-center" aria-hidden="true">
					Next
						<svg class="ml-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.82234 1.19783C1.15708 0.863094 1.69979 0.863094 2.03452 1.19783L7.17738 6.34069C7.51212 6.67542 7.51212 7.21813 7.17738 7.55287L2.03452 12.6957C1.69979 13.0305 1.15708 13.0305 0.82234 12.6957C0.487605 12.361 0.487605 11.8183 0.82234 11.4835L5.35911 6.94678L0.82234 2.41001C0.487605 2.07528 0.487605 1.53256 0.82234 1.19783Z" fill="#98A9BC"></path>
						  </svg>
					</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
