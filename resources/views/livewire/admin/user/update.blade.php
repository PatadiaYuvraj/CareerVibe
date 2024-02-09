<div class="row">
    <span class="h3 text-black col">Update Location</span>
    @include('livewire.common._search')
</div>
<form enctype="multipart/form-data">
    <input type="hidden" wire:model.live="locationId">
    <div class="row ">
        <div class="col form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                placeholder="Enter Name" wire:model.live="name">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col form-group mb-3">
            <label for="email">Email:</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                placeholder="Enter Email" wire:model.live="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row ">
        <div class="col form-group mb-3">
            <label for="profile_image_url">Profile Image:</label>
            <input type="file" class="form-control @error('profile_image_url') is-invalid @enderror"
                id="profile_image_url" wire:model.live="profile_image_url">
            @error('profile_image_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col form-group mb-3">
            <label for="resume_pdf_url">Upload Your Resume :</label>
            <input type="file" class="form-control @error('resume_pdf_url') is-invalid @enderror" id="resume_pdf_url"
                wire:model.live="resume_pdf_url">
            @error('resume_pdf_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="d-flex btn-group">
        <button wire:click.prevent="update()" class="btn btn-success btn-block">Update</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </div>
</form>
