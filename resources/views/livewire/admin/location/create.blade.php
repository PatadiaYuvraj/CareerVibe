<div class="row border-1 border-black">
    <span class="h3 text-black col">Add Location</span>
    @include('livewire.common._search')
</div>

<form class="repeater">
    <div class="row">
        @foreach ($items as $index => $location)
            <div class="form-group mb-3 repeater col-12">
                <label for="city-{{ $index }}">Location {{ $index + 1 }}</label>
                <div class="row input-group">
                    <input type="text"
                        class="form-control border-1 border-info col @error('items.' . $index . '.city') is-invalid @enderror"
                        id="city-{{ $index }}" placeholder="Enter City"
                        wire:model.live="items.{{ $index }}.city">
                    <input type="text"
                        class="form-control border-1 border-info col @error('items.' . $index . '.state') is-invalid @enderror"
                        id="state-{{ $index }}" placeholder="Enter State"
                        wire:model.live="items.{{ $index }}.state">
                    <input type="text"
                        class="form-control border-1 border-info col @error('items.' . $index . '.country') is-invalid @enderror"
                        id="country-{{ $index }}" placeholder="Enter Country"
                        wire:model.live="items.{{ $index }}.country">
                    <input type="text"
                        class="form-control border-1 border-info col @error('items.' . $index . '.pincode') is-invalid @enderror"
                        id="pincode-{{ $index }}" placeholder="Enter Pin Code"
                        wire:model.live="items.{{ $index }}.pincode">
                    @if ($index > 0)
                        <button wire:click.prevent="removeRow({{ $index }})" class="col-2 btn btn-danger">
                            <i class="bi-trash"></i>
                        </button>
                    @endif
                </div>

                @error('items.' . $index . '.city')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('items.' . $index . '.state')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('items.' . $index . '.country')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('items.' . $index . '.pincode')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    </div>

    <div class="d-flex btn-group">
        @if (count($items) < $minRows || count($items) < $maxRows)
            <button wire:click.prevent="addRow" class="btn btn-primary">Add Location</button>
        @endif

        @if (count($items) >= $maxRows)
            <span class="btn btn-primary disabled">
                <i class="bi-exclamation-triangle"></i> Max Rows Reached ({{ $maxRows }})
            </span>
        @endif
        <button wire:click.prevent="store" class="btn btn-success btn-block">Save</button>
    </div>
</form>
