<link rel="stylesheet" href="{{ asset('css/Manager_index.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/all.css') }}"> --}}
@extends('layouts.admin')

@section('content')
    <div class="welcome-section text-center w-75 w-md-50 mx-auto">
        <div>
            <img id="hi" src="{{ asset('img/hallo.svg') }}" alt="" class="custom-img mb-3">
        </div>
        <h1 class="welcom">Welcome Back Again</h1>
        <p class="text-black-50 mb-4">We Wish You a Comfortable Day And Easy Work</p>
    </div>
@endsection
