<title>Admin Profile Page</title>
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@extends('layouts.admin')

@section('content')
    <div class="under-nav">
        <div class="info-container">
            <div class="main-title mb-4 text-center">
                <div class="my-icon mt-3 text-center">
                    <div class="circle">
                        <i class="fa fa-user fa-4x"></i>
                    </div>
                </div>
                <h2 class="mt-2 fw-bold text-center">{{ ucfirst($admin->username) }}'s Information</h2>
                <span class="line"></span>
            </div>

            <div class="rows mb-4 mt-3 ">
                <div class="info-field col-sm-6">
                    <div id="titel" class="title-field">
                        <div class="circle">
                            <i class="fa-solid fa-people-group fa-fw"></i>
                        </div>
                        <h4 class="m-0 ps-2">Full Name</h4>
                    </div>
                    <p class="text-black-50 ms-5 ps-3">{{ ucfirst($admin->first_name) }}
                        {{ ucfirst($admin->last_name) }}</p>
                </div>

                <div class="info-field col-sm-6">
                    <div id="titel"class="title-field">
                        <div class="circle">
                            <i class="fa fa-user fa-fw"></i>
                        </div>
                        <h4 class="m-0 ps-2">Username</h4>
                    </div>
                    <p class="text-black-50 ms-5 ps-3">{{ $admin->username }}</p>
                </div>

                <div class="info-field col-sm-6">
                    <div id="titel" class="title-field">
                        <div class="circle">
                            <i class="fa fa-envelope fa-fw"></i>
                        </div>
                        <h4 class="m-0 ps-2">E-mail</h4>
                    </div>
                    <p class="text-black-50 ms-5 ps-3">{{ $admin->email }}</p>
                </div>

                <div class="info-field col-sm-6">
                    <div id="titel" class="title-field">
                        <div class="circle">
                            <i class="fa fa-phone fa-fw"></i>
                        </div>
                        <h4 class="m-0 ps-2">Phone Number</h4>
                    </div>
                    <p class="text-black-50 ms-5 ps-3">{{ $admin->phone_number }}</p>
                </div>

                <div class="info-field col-sm-6">
                    <div id="titel" class="title-field">
                        <div class="circle">
                            <i class="fa fa-birthday-cake fa-fw"></i>
                        </div>
                        <h4 class="m-0 ps-2">Date of Birth</h4>
                    </div>
                    <p class="text-black-50 ms-5 ps-3">{{ $admin->date_of_birth->format('Y-m-d') }}</p>
                </div>
            </div>

            <div class="text-center mb-4">
                <a href="{{ route('admin.profile.edit', $admin->id) }}" class="btn btn-primary">Edit Profile</a>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger custom-alert">
                        {{ $loop->iteration }}- {{ $error }}<br>
                    </div>
                @endforeach
            @endif
            @if (session('success'))
                <div class="alert alert-success custom-alert" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
@endsection
