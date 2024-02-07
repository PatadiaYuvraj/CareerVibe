<div class="row">
    <span class="h3 text-black col">Update Profile Category</span>
    @include('livewire.common._search')
</div>
<form>
    <input type="hidden" wire:model.live="profileCategoryId">
    <div class="form-group mb-3 row">
        <label for="name">Name:</label>
        <div class="input-group">
            <input type="text"
                class="form-control border-1 border-info col @error('name') border-1 border-danger is-invalid @enderror"
                placeholder="Enter Name" wire:model.live="name">

            <select
                class="form-select border-1 border-info col @error('profile_category_id') border-1 border-danger is-invalid @enderror"id="profile_category_id"
                wire:model.live="profile_category_id">
                <option disabled value="">Select Profile Category</option>
                @foreach ($profileCategories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>



        <div class="row">
            @error('name')
                <span class="text-danger col">{{ $message }}</span>
            @enderror

            @error('profile_category_id')
                <span class="text-danger col">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="d-flex btn-group">
        <button wire:click.prevent="update()" class="btn btn-success btn-block">Update</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </div>
</form>
