<div class="row">
    <span class="h3 text-black col">Add Qualification</span>
    @include('livewire.common._search')
</div>
<form class="repeater">
    <div class="row">
        @foreach ($items as $index => $qualification)
            <div class="form-group mb-3 repeater col-4">
                <label for="name-{{ $index }}">
                    Name {{ $index + 1 }}
                </label>
                <div class="row input-group">
                    <input type="text"
                        class="form-control border-1 border-info col @error('items.' . $index . '.name') is-invalid @enderror"
                        id="name-{{ $index }}" placeholder="Enter Qualification"
                        wire:model.live="items.{{ $index }}.name">
                    @if ($index > 0)
                        <button wire:click.prevent="removeRow({{ $index }})" class="col-2 btn btn-danger">
                            <i class="bi-trash"></i>
                        </button>
                    @endif
                </div>

                @error('items.' . $index . '.name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
        @endforeach
    </div>

    <div class="d-flex btn-group">
        @if (count($items) < $minRows || count($items) < $maxRows)
            <button wire:click.prevent="addRow" class="btn btn-primary">Add Qualification</button>
        @endif

        @if (count($items) >= $maxRows)
            <span class="btn btn-primary disabled">
                <i class="bi-exclamation-triangle"></i> Max Rows Reached ({{ $maxRows }})
            </span>
        @endif
        <button wire:click.prevent="store" class="btn btn-success btn-block">Save</button>
    </div>
</form>
