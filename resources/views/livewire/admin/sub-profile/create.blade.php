<div class="row">
    <span class="h3 text-black col">Add Sub Profile</span>
    @include('livewire.common._search')
</div>

<form class="repeater">
    <div class="row row-cols-1">
        @foreach ($items as $index => $item)
            <div class="form-group mb-3 repeater col">
                <label for="name-{{ $index }}">
                    Name {{ $index + 1 }}
                </label>
                <div class="row input-group">
                    <input type="text"s
                        class="form-control border-1 border-info col @error('items.' . $index . '.name') is-invalid @enderror"
                        id="name-{{ $index }}" placeholder="Enter Name"
                        wire:model="items.{{ $index }}.name">


                    <select class="form-select border-1 border-info col" id="profile_category_id-{{ $index }}"
                        wire:model="items.{{ $index }}.profile_category_id">
                        <option value="">Select Profile Category</option>
                        @foreach (App\Models\ProfileCategory::orderBy('name', 'asc')->pluck('name', 'id') as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

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
            <button wire:click.prevent="addRow" class="btn btn-primary">Add Category</button>
        @endif

        @if (count($items) >= $maxRows)
            <span class="btn btn-primary disabled">
                <i class="bi-exclamation-triangle"></i> Max Rows Reached ({{ $maxRows }})
            </span>
        @endif
        <button wire:click.prevent="store" class="btn btn-success btn-block">Save</button>
    </div>
</form>
