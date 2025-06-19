<title>Edit Profile Page</title>
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/add.css') }}"> --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-manager-layout>
    <div class="under-nav">
        <div class="info-container">
            <div class="main-title mb-4 text-center">
                <div class="my-icon mt-3 text-center">
                    <div class="circle">
                        <i class="fa fa-user fa-4x"></i>
                    </div>
                </div>
                <h2 class="mt-2 fw-bold text-center">Edit {{ ucfirst($manager->username) }}'s Information</h2>
                <span class="line"></span>
            </div>
            @if(session('success'))
                <div class="d-flex justify-content-center">
                    <div class="alert alert-success alert-dismissible fade show text-center px-4 py-2" role="alert" style="display: inline-block; min-width: 200px; max-width: 100%; font-size: 1.1rem;">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <form id="edit-form" action="{{ route('manager.profile.update', $manager->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="rows mb-4 mt-3">
                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa-solid fa-people-group fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">First Name</h4>
                        </div>
                        <input type="text" name="first_name" value="{{ old('first_name', $manager->first_name) }}"
                            class="form-control ms-5 ps-3" required>
                    </div>

                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa-solid fa-people-group fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">Last Name</h4>
                        </div>
                        <input type="text" name="last_name" value="{{ old('last_name', $manager->last_name) }}"
                            class="form-control ms-5 ps-3" required>
                    </div>

                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa fa-user fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">Username</h4>
                        </div>
                        <input type="text" name="username" value="{{ old('username', $manager->username) }}"
                            class="form-control ms-5 ps-3" required>
                    </div>

                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa fa-envelope fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">E-mail</h4>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $manager->email) }}"
                            class="form-control ms-5 ps-3" required>
                    </div>

                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa fa-phone fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">Phone Number</h4>
                        </div>
                        <input type="text" name="phone_number"
                            value="{{ old('phone_number', $manager->phone_number) }}" class="form-control ms-5 ps-3"
                            required>
                    </div>

                    <div class="info-field col-sm-6">
                        <div id="titel" class="title-field">
                            <div class="circle">
                                <i class="fa fa-birthday-cake fa-fw"></i>
                            </div>
                            <h4 class="m-0 ps-2">Date of Birth</h4>
                        </div>
                        <input type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', $manager->date_of_birth->format('Y-m-d')) }}"
                            class="form-control ms-5 ps-3" required>
                    </div>
                </div>


                <div class="buttons d-flex justify-content-center">
                    <a href="{{ route('manager.profile', $manager->id) }}" class="btn btn-secondary me-sm-3"
                        style="background-color: black; transition: background-color 0.3s ease;"
                        onmouseover="this.style.backgroundColor='gray';"
                        onmouseout="this.style.backgroundColor='black';">Back</a>
                    <button id="btn" class="btn btn-success ms-3" type="button" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Edit</button>
                </div>


            </form>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 fw-bold" id="exampleModalLabel">Edit Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-6 fw-bolder">
                    Are You Sure you Want To Edit ?
                </div>
                <div class="modal-footer">
                    <button id="close-btn" type="button" class="btn btn-secondary fw-medium"
                        data-bs-dismiss="modal">No
                    </button>
                    <button id="yes-btn" type="submit" form="edit-form"
                        class="btn btn-danger fw-medium">Yes</button>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
