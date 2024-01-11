@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add User</span>
                    <a href="{{ route('admin.user.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            {{-- Edit User form --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
