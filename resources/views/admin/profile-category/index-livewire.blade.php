@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    @livewireStyles

    @livewire('admin.profile-category.index')

@endsection
@livewireScripts
