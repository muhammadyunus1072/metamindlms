<div>
    @if ($paginator->hasPages())
        <ul class="pagination justify-content-center pagination-xsm m-0">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link">
                        <span aria-hidden="true"
                            class="material-icons">chevron_left</span>
                        <span>Prev</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <span aria-hidden="true"
                            class="material-icons">chevron_left</span>
                        <span>Prev</span>
                    </a>
                </li>
            @endif
            
            @foreach ($elements as $v)
                @if (is_string($v))
                    <li class="page-item disabled">
                        <a class="page-link">
                            <span>{{ $v }}</span>
                        </a>
                    </li>
                @endif

                @if (is_array($v))
                    @foreach ($v as $k=>$y)
                        @if ($k == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="{{ $y }}">
                                    <span>{{ $k }}</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $y }}">
                                    <span>{{ $k }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            
            
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <span>Next</span>
                        <span aria-hidden="true"
                            class="material-icons">chevron_right</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link">
                        <span>Next</span>
                        <span aria-hidden="true"
                            class="material-icons">chevron_right</span>
                    </a>
                </li>
            @endif

            
        </ul>
    @endif
</div>