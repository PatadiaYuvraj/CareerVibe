{{--  --}}
<div class="text-center">
    @foreach ($paginator as $link)
        @if ($link['url'] == null)
            <span class="page-item disabled">
                <a class="page-link" href="#">
                    @if ($link['label'] == 'Next &raquo;')
                        Next
                    @elseif ($link['label'] == '&laquo; Previous')
                        Previous
                    @else
                        {{ $link['label'] }}
                    @endif
                </a>
            </span>
        @else
            <span class="page-item  @if ($link['active']) active @endif">
                <a class="page-link " href="{{ $link['url'] }}">
                    {{-- {{ $link['label'] }} --}}
                    {{-- "Next &raquo;" --}}
                    @if ($link['label'] == 'Next &raquo;')
                        Next
                    @elseif ($link['label'] == '&laquo; Previous')
                        Previous
                    @else
                        {{ $link['label'] }}
                    @endif
                </a>
            </span>
        @endif
    @endforeach
</div>
