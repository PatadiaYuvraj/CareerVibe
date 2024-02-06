<div class="row">
    <span class="h3 text-black col">Update Qualification</span>
    @include('livewire.admin.qualification._search')
</div>
<form>
    <input type="hidden" wire:model="qualificationId">
    <div class="form-group mb-3">
        <label for="name">Name:</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
            placeholder="Enter Name" wire:model="name">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="d-flex btn-group">
        <button wire:click.prevent="update()" class="btn btn-success btn-block">Update</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </div>
</form>
