<main id="main" class="main">
    <section class="section dashboard">
        <div class="card">
            <div class="card-body py-4">
                @if ($updateMode)
                    @include('livewire.admin.sub-profile.update')
                @else
                    @include('livewire.admin.sub-profile.create')
                @endif

                <div class="table-responsive">
                    <table class="table table-striped text-center  table-hover">
                        <thead>
                            <tr>
                                <th scope="col-3">#</th>
                                <th scope="col-6">Profile</th>
                                <th scope="col-6">Category</th>
                                <th scope="col-2">Jobs</th>
                                <th scope="col-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subProfiles['data'] as $subProfile)
                                <tr>
                                    {{-- <td scope="row">{{ $loop->iteration }}</td> --}}
                                    <td scope="row">{{ $subProfile['id'] }}</td>
                                    <td>{{ $subProfile['name'] }}</td>
                                    <td>{{ $subProfile['profile_category']['name'] }}</td>
                                    <td>{{ $subProfile['jobs_count'] }}</td>
                                    <td class="btn-group d-flex">


                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="edit({{ $subProfile['id'] }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="delete({{ $subProfile['id'] }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="10">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('livewire.common._pagination', ['data' => $subProfiles])
                </div>
            </div>
        </div>
    </section>
</main>
