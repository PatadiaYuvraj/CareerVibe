<main id="main" class="main">
    <section class="section dashboard">
        <div class="card">


            <div class="card-body py-4">
                @if ($updateMode)
                    @include('livewire.admin.location.update')
                @else
                    @include('livewire.admin.location.create')
                @endif

                {{-- <div x-data="{ showModal: @entangle('showModal').live }" x-init="showModal = false">

                    <div x-show="showModal" @keydown.escape="showModal = false" role="dialog"
                        aria-labelledby="locationDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="locationDetailsModalLabel">Location Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="flex flex-col">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="font-semibold">City: {{ $city }}</h3>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-semibold">State: {{ $state }}</h3>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-semibold">Country: {{ $country }}</h3>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-semibold">Pin Code: {{ $pincode }}</h3>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="font-semibold">Jobs: {{ 'jobs_count' }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        @click="showModal = false">Close</button>
                                    <button wire:click="submitAction" class="btn btn-primary"
                                        data-dismiss="modal">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


                <div class="table-responsive">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                            <tr>
                                <th scope="col-3">#</th>
                                <th scope="col-2">City</th>
                                <th scope="col-2">State</th>
                                <th scope="col-2">Country</th>
                                <th scope="col-2">Pin Code</th>
                                <th scope="col-2">Jobs</th>
                                <th scope="col-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations['data'] as $location)
                                <tr>
                                    <td scope="row">{{ $location['id'] }}</td>
                                    <td>{{ $location['city'] }}</td>
                                    <td>
                                        @if ($location['state'] != null)
                                            {{ $location['state'] }}
                                        @else
                                            <span class="text-muted fw-light">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($location['country'] != null)
                                            {{ $location['country'] }}
                                        @else
                                            <span class="text-muted fw-light">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($location['pincode'] != null)
                                            {{ $location['pincode'] }}
                                        @else
                                            <span class="text-muted fw-light">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $location['jobs_count'] }}</td>
                                    <td class="btn-group d-flex">
                                        {{-- <button type="button" class="btn btn-sm btn-info"
                                            wire:click="show({{ $location['id'] }})">
                                            <i class="bi bi-eye"></i>
                                        </button> --}}
                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="edit({{ $location['id'] }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $location['id'] }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty

                                <tr class="text-center">
                                    <td colspan="10">No Location Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('livewire.common._pagination', ['data' => $locations])
                </div>
            </div>

        </div>
    </section>
</main>
