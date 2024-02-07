<div class="input-group mb-3 col">
    {{-- <input type="text" class="form-control border-1 border-dark-subtle" placeholder="Search" wire:model.live="search"
        wire:keydown="searching()"> --}}
    <input type="text" class="form-control border-1 border-dark-subtle" placeholder="Search" wire:model.live="search">
    <button class="btn btn-primary" type="button" wire:click.prevent="searching()">
        <i class="bi bi-search"></i>
    </button>
</div>
