<div class="row">
    <span class="h3 text-black col">Add Qualification</span>
    <div class="input-group mb-3 col">
        <input type="text" class="form-control" placeholder="Search" wire:model="search"
            wire:keydown="searchQualification()">
        <button class="btn btn-primary" type="button" wire:click="searchQualification">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>
<form>
    <div class="form-group mb-3">
        <label for="name">Name:</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
            placeholder="Enter Name" wire:model="name">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="d-flex btn-group">
        <button wire:click.prevent="store()" class="btn btn-success btn-block">Save</button>
    </div>
</form>
