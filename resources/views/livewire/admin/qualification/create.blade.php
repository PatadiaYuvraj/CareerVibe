<div class="row">
    <span class="h3 text-black col">Add Qualification</span>
    @include('livewire.admin.qualification._pagination')
</div>
<form class="repeater">
    <div class="form-group mb-3 repeater">
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
