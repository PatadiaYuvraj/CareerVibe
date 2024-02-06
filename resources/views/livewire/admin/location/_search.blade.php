<div class="input-group mb-3 col">
    <input type="text" class="form-control border-2 border-black" placeholder="Search for location" wire:model="search"
        wire:keydown="searchLocation()">
    {{-- <button class="btn btn-primary" type="button" wire:click="searchLocation">
        <i class="bi bi-search"></i>
    </button> --}}
</div>
