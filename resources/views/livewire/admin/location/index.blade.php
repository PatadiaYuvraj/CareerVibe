<main id="main" class="main">
    <section class="section dashboard">
        <div class="card">


            <div class="card-body py-4">
                @if ($updateMode)
                    @include('livewire.admin.location.update')
                @else
                    @include('livewire.admin.location.create')
                @endif
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
