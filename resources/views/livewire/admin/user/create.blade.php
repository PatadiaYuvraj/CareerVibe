<div class="row">
    <span class="h3 text-black col">Add User</span>
    @include('livewire.common._search')
</div>
<form class="">
    <div class="row row-cols-1">
        @foreach ($items as $index => $user)
            <div class="form-group mb-3 col">
                <label for="name-{{ $index }}">
                    User {{ $index + 1 }}
                </label>
                <div class="row col">
                    <div class="row input-group">
                        <input type="text"
                            class="form-control border-1 border-info col @error('items.' . $index . '.name') border-danger is-invalid @enderror"
                            id="name-{{ $index }}" placeholder="Enter Name"
                            wire:model="items.{{ $index }}.name">
                        <input type="text"
                            class="form-control border-1 border-info col @error('items.' . $index . '.email') border-danger is-invalid @enderror"
                            id="email-{{ $index }}" placeholder="Enter Email"
                            wire:model="items.{{ $index }}.email">
                    </div>
                    <div class="row mb-2">
                        @error('items.' . $index . '.name')
                            <span class="col text-danger">{{ $message }}</span>
                        @enderror
                        @error('items.' . $index . '.email')
                            <span class="col text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row input-group mb-2">
                        <input type="password"
                            class="form-control border-1 border-info col @error('items.' . $index . '.password') border-danger is-invalid @enderror"
                            id="password-{{ $index }}" placeholder="Enter Password"
                            wire:model="items.{{ $index }}.password">
                        <input type="password"
                            class="form-control border-1 border-info col @error('items.' . $index . '.password_confirmation') border-danger is-invalid @enderror"
                            id="password_confirmation-{{ $index }}" placeholder="Confirm Password"
                            wire:model="items.{{ $index }}.password_confirmation">
                    </div>
                    <div class="row mb-2">
                        @error('items.' . $index . '.password')
                            <span class="col text-danger">{{ $message }}</span>
                        @enderror
                        @error('items.' . $index . '.password_confirmation')
                            <span class="col text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($index > 0)
                        <button wire:click.prevent="removeRow({{ $index }})" class="col-1 btn btn-danger">
                            <i class="bi-trash"></i>
                        </button>
                    @endif
                </div>

            </div>
        @endforeach
    </div>

    <div class="d-flex btn-group">
        @if (count($items) < $minRows || count($items) < $maxRows)
            <button type="button" wire:click="addRow" class="btn btn-primary">Add User</button>
        @endif

        @if (count($items) >= $maxRows)
            <span class="btn btn-primary disabled">
                <i class="bi-exclamation-triangle"></i> Max Rows Reached ({{ $maxRows }})
            </span>
        @endif
        <button type="button" wire:click="store" class="btn btn-success btn-block">
            <i class="bi-save"></i> Save
        </button>
    </div>
</form>
