@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    @livewireStyles

    @livewire('admin.sub-profile.index')

@endsection
@livewireScripts
