@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 active:text-gray-700">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 active:text-gray-700">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('pagination.showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('pagination.to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('pagination.of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('pagination.results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <!-- Go to first -->
                    <a href="{{ $paginator->url(1) }}" rel="first"
                       class="@if($paginator->onFirstPage()) disabled @endif relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 active:text-gray-500" aria-label="{{ __('pagination.first') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2068 5.29279C10.3943 5.48031 10.4996 5.73462 10.4996 5.99979C10.4996 6.26495 10.3943 6.51926 10.2068 6.70679L6.91379 9.99979L10.2068 13.2928C10.3889 13.4814 10.4897 13.734 10.4875 13.9962C10.4852 14.2584 10.38 14.5092 10.1946 14.6946C10.0092 14.88 9.75838 14.9852 9.49619 14.9875C9.23399 14.9897 8.98139 14.8889 8.79279 14.7068L4.79279 10.7068C4.60532 10.5193 4.5 10.265 4.5 9.99979C4.5 9.73462 4.60532 9.48031 4.79279 9.29279L8.79279 5.29279C8.98031 5.10532 9.23462 5 9.49979 5C9.76495 5 10.0193 5.10532 10.2068 5.29279Z"/>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2068 5.29279C15.3943 5.48031 15.4996 5.73462 15.4996 5.99979C15.4996 6.26495 15.3943 6.51926 15.2068 6.70679L11.9138 9.99979L15.2068 13.2928C15.3889 13.4814 15.4897 13.734 15.4875 13.9962C15.4852 14.2584 15.38 14.5092 15.1946 14.6946C15.0092 14.88 14.7584 14.9852 14.4962 14.9875C14.234 14.9897 13.9814 14.8889 13.7928 14.7068L9.79279 10.7068C9.60532 10.5193 9.5 10.265 9.5 9.99979C9.5 9.73462 9.60532 9.48031 9.79279 9.29279L13.7928 5.29279C13.9803 5.10532 14.2346 5 14.4998 5C14.765 5 15.0193 5.10532 15.2068 5.29279Z"/>
                        </svg>
                    </a>

                    {{-- Previous Page Link --}}
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       class="@if($paginator->onFirstPage()) disabled @endif relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 active:text-gray-500" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="z-10 bg-blue-50 border-blue-500 text-blue-700 relative inline-flex items-center px-4 py-2 border text-sm font-medium leading-5">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 hover:bg-gray-100 active:text-gray-700 focus:z-20" aria-label="{{ __('pagination.go_page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       class="@if(!$paginator->hasMorePages()) disabled @endif relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 hover:bg-gray-100 active:text-gray-500" aria-label="{{ __('pagination.next') }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- Go to last -->
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" rel="last"
                       class="@if(!$paginator->hasMorePages()) disabled @endif relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 active:bg-gray-100 hover:bg-gray-100 active:text-gray-500" aria-label="{{ __('pagination.last') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M9.79279 5.29279C9.60532 5.48031 9.5 5.73462 9.5 5.99979C9.5 6.26495 9.60532 6.51926 9.79279 6.70679L13.0858 9.99979L9.79279 13.2928C9.61063 13.4814 9.50983 13.734 9.51211 13.9962C9.51439 14.2584 9.61956 14.5092 9.80497 14.6946C9.99038 14.88 10.2412 14.9852 10.5034 14.9875C10.7656 14.9897 11.0182 14.8889 11.2068 14.7068L15.2068 10.7068C15.3943 10.5193 15.4996 10.265 15.4996 9.99979C15.4996 9.73462 15.3943 9.48031 15.2068 9.29279L11.2068 5.29279C11.0193 5.10532 10.765 5 10.4998 5C10.2346 5 9.98031 5.10532 9.79279 5.29279Z"/>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M4.79279 5.29279C4.60532 5.48031 4.5 5.73462 4.5 5.99979C4.5 6.26495 4.60532 6.51926 4.79279 6.70679L8.08579 9.99979L4.79279 13.2928C4.61063 13.4814 4.50983 13.734 4.51211 13.9962C4.51439 14.2584 4.61956 14.5092 4.80497 14.6946C4.99038 14.88 5.24119 14.9852 5.50339 14.9875C5.76558 14.9897 6.01818 14.8889 6.20679 14.7068L10.2068 10.7068C10.3943 10.5193 10.4996 10.265 10.4996 9.99979C10.4996 9.73462 10.3943 9.48031 10.2068 9.29279L6.20679 5.29279C6.01926 5.10532 5.76495 5 5.49979 5C5.23462 5 4.98031 5.10532 4.79279 5.29279Z"/>
                        </svg>
                    </a>
                </span>
            </div>
        </div>
    </nav>
@endif
