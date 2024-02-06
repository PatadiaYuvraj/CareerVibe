<div class="d-flex">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item {{ $data['prev_page_url'] ? '' : 'disabled' }}">
                <button class="page-link" wire:click="prevPage">Previous</button>
            </li>
            @for ($i = 1; $i <= $data['last_page']; $i++)
                @if ($i == $data['current_page'])
                    <li class="page-item active" aria-current="page">
                        <button class="page-link">{{ $i }}</button>
                    </li>
                @else
                    <li class="page-item">
                        <button class="page-link"
                            wire:click="gotoPage({{ $i }})">{{ $i }}</button>
                    </li>
                @endif
            @endfor
            <li class="page-item {{ $data['next_page_url'] ? '' : 'disabled' }}">
                <button class="page-link" wire:click="nextPage">Next</button>
            </li>
        </ul>
    </nav>
</div>
