<title>Manager list</title>
<link rel="stylesheet" href="{{ asset('css/category_list.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('layouts.admin')

@section('title', 'Manager List')

@section('content')

    <div id="nav3" class="">
        <div id="list"class="flex h-16 ">
            <x-nav-link :href="route('admin.managers.create')" :active="request()->routeIs('admin.managers.create')">
                {{ __('ADD Manager') }}
            </x-nav-link>
        </div>
        <div id="list"class="flex  h-16">
            <x-nav-link :href="route('admin.managers.index')" :active="request()->routeIs('admin.managers.index')">
                {{ __('Manager list') }}
            </x-nav-link>
        </div>
    </div>

    <div class="content-list">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($managers->count() > 0)
            <div class="container">
                <div class="row">
                    @foreach ($managers as $manager)
                        <div class="col-12 col-md-12 col-lg-6 mb-4">
                            <div id="manager_list" class="list-items">
                                <h2>{{ $manager->first_name }} {{ $manager->last_name }}</h2>
                                <div class="icon">
                                    <a id="show" href="{{ route('admin.managers.show', $manager->id) }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a id="edit" href="{{ route('admin.managers.edit', $manager->id) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button id="delete" class="my-btn me-auto ms-auto me-sm-3 ms-sm3" type="button"
                                        data-bs-toggle="modal" data-bs-target="#m{{ $manager->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Message -->
                        <div class="modal fade" id="m{{ $manager->id }}" tabindex="-1" aria-labelledby="Label"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3 fw-bold">Delete <strong
                                                style="color:#e6ee0d;">{{ $manager->first_name }}
                                                {{ $manager->last_name }}</strong></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body fs-6 fw-bolder">
                                        Are You Sure you Want To Delete?
                                    </div>
                                    <div class="modal-footer">
                                        <button id="close-btn" type="button" class="btn btn-secondary fw-medium"
                                            data-bs-dismiss="modal">No</button>
                                        <form action="{{ route('admin.managers.destroy', $manager->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button id="yes-btn" type="submit"
                                                class="btn btn-danger fw-medium">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="no-data">
                <p>No Managers Yet</p>
            </div>
        @endif
    </div>
@endsection
