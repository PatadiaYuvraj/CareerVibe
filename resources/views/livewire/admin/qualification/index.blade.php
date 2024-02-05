<main id="main" class="main">
    <section class="section dashboard">
        <div class="card">


            <div class="card-body py-4">
                @if ($updateMode)
                    @include('livewire.admin.qualification.update')
                @else
                    @include('livewire.admin.qualification.create')
                @endif
                <div class="table-responsive">
                    <table class="table table-striped text-center  table-hover">
                        <thead>
                            <tr>
                                <th scope="col-3">#</th>
                                <th scope="col-6">Qualification</th>
                                <th scope="col-2">Jobs</th>
                                <th scope="col-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($qualifications['data'] as $qualification)
                                <tr>
                                    {{-- <td scope="row">{{ $loop->iteration }}</td> --}}
                                    <td scope="row">{{ $qualification['id'] }}</td>
                                    <td>{{ $qualification['name'] }}</td>
                                    <td>{{ $qualification['jobs_count'] }}</td>
                                    <td class="btn-group d-flex">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="edit({{ $qualification['id'] }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" {{-- confirm swal js --}}
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $qualification['id'] }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty

                                <tr class="text-center">
                                    <td colspan="10">No Qualification Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ $qualifications['prev_page_url'] ? '' : 'disabled' }}">
                                    <button class="page-link" wire:click="prevPage">Previous</button>
                                </li>
                                @for ($i = 1; $i <= $qualifications['last_page']; $i++)
                                    @if ($i == $qualifications['current_page'])
                                        <li class="page-item active" aria-current="page">
                                            <button class="page-link">{{ $i }}</button>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <button class="page-link"
                                                wire:click="gotoPage({{ $i }})">{{ $i }}</button>
                                        </li>
                                    @endif
                                @endfor
                                <li class="page-item {{ $qualifications['next_page_url'] ? '' : 'disabled' }}">
                                    <button class="page-link" wire:click="nextPage">Next</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
