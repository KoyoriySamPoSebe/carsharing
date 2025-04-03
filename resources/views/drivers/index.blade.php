@extends('adminlte::page')

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div>

    @section('content')
        @livewire('drivers-table')

        <div class="container">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @csrf
        </div>
    @endsection
</div>
