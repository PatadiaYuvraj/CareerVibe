<main id="main" class="main">
    <section class="section dashboard">
        <div class="card">
            <div class="card-body py-4">
                @if ($updateMode)
                    @include('livewire.admin.user.update')
                @else
                    @include('livewire.admin.user.create')
                @endif
                <div class="table-responsive">
                    <table class="table table-striped text-center  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name </th>
                                <th>Email </th>
                                <th>Profile Image </th>
                                <th>Resume </th>
                                <th>Applied Job </th>
                                <th>Saved Job </th>
                                <th>Followers </th>
                                <th>Following </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users['data'] as $user)
                                <tr>
                                    <td scope="row">{{ $user['id'] }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($user['profile_image_url'])
                                                <a href="{{ $user['profile_image_url'] }}" class="btn btn-sm btn-primary"
                                                    target="_blank">
                                                    <i class="bi-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteProfileImage({{ $user['id'] }})">
                                                    <i class="bi-trash"></i>
                                                </button>
                                            @else
                                                <span class="text-danger">
                                                    <i class="bi-x-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($user['resume_pdf_url'])
                                                <a href="{{ url($user['resume_pdf_url']) }}"
                                                    class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="bi-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteResume({{ $user['id'] }})">
                                                    <i class="bi-trash"></i>
                                                </button>
                                            @else
                                                <span class="text-danger">
                                                    <i class="bi-x-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $user['applied_jobs_count'] }}</td>
                                    <td>{{ $user['saved_jobs_count'] }}</td>
                                    <td>{{ $user['followers_count'] }}</td>
                                    <td>{{ $user['following_count'] + $user['following_companies_count'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="edit({{ $user['id'] }})">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="delete({{ $user['id'] }})"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="bi-trash"></i>
                                                </button>

                                            </div>
                                    </td>
                                </tr>
                            @empty

                                <tr class="text-center">
                                    <td colspan="10">No Users Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('livewire.common._pagination', ['data' => $users])
                </div>
            </div>

        </div>
    </section>
</main>
