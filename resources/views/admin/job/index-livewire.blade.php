@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    @livewireStyles

    @livewire('admin.job.index')

@endsection
@livewireScripts
