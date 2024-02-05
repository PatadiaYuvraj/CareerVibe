@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    @livewireStyles

    @livewire('admin.qualification.index')

@endsection
@livewireScripts
{{-- has session --}}
