@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Edit Job</span>
                    <a href="{{ route('admin.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.job.update', $job['id']) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Job Profile</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $job['profile']['profile'] }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
