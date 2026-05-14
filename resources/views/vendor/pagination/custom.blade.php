@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Пагинация">
        <ul class="pagination__list">
            {{-- Кнопка "Назад" --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__item pagination__item--disabled"><span>«</span></li>
            @else
                <li class="pagination__item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a></li>
            @endif

            {{-- Номера страниц --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination__item pagination__item--dots"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item pagination__item--active"><span>{{ $page }}</span></li>
                        @else
                            <li class="pagination__item"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Кнопка "Вперед" --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">»</a></li>
            @else
                <li class="pagination__item pagination__item--disabled"><span>»</span></li>
            @endif
        </ul>
    </nav>
@endif
