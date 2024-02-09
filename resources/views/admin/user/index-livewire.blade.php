@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    @livewireStyles

    @livewire('admin.user.index')

@endsection
@livewireScripts
