<div class="input-group mb-3 col">
    <input type="text" class="form-control" placeholder="Search" wire:model="search" wire:keydown="searchQualification()">
    <button class="btn btn-primary" type="button" wire:click="searchQualification">
        <i class="bi bi-search"></i>
    </button>
</div>
