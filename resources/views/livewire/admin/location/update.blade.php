<div class="row">
    <span class="h3 text-black col">Update Location</span>
    @include('livewire.common._search')
</div>
<form>
    <input type="hidden" wire:model.live="locationId">
    <div class="row ">
        <div class="col form-group mb-3">
            <label for="city">City:</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                placeholder="Enter City" wire:model.live="city">
            @error('city')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col form-group mb-3">
            <label for="state">State:</label>
            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                placeholder="Enter State" wire:model.live="state">
            @error('state')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- </div>
    <div class="row "> --}}
        <div class="col form-group mb-3">
            <label for="country">Country:</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                placeholder="Enter Country" wire:model.live="country">
            @error('country')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col form-group mb-3">
            <label for="pincode">Pin Code:</label>
            <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode"
                placeholder="Enter Pin Code" wire:model.live="pincode">
            @error('pincode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="d-flex btn-group">
        <button wire:click.prevent="update()" class="btn btn-success btn-block">Update</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </div>
</form>
