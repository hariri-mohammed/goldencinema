<title>Manager list</title>
<link rel="stylesheet" href="{{ asset('css/category_list.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('layouts.admin')

@section('title', 'Manager List')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Managers</h2>
        <a href="{{ route('admin.managers.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> ADD Manager
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($managers->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managers as $manager)
                        <tr>
                            <td>{{ $manager->first_name }} {{ $manager->last_name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>{{ $manager->phone_number }}</td>
                            <td>
                                <a href="{{ route('admin.managers.show', $manager->id) }}" class="btn btn-sm btn-info me-1" title="Show">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.managers.edit', $manager->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#m{{ $manager->id }}" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <!-- Confirm Delete Modal -->
                                <div class="modal fade" id="m{{ $manager->id }}" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-3 fw-bold">Delete <strong style="color:#e6ee0d;">{{ $manager->first_name }} {{ $manager->last_name }}</strong></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body fs-6 fw-bolder">
                                                Are you sure you want to delete?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">No</button>
                                                <form action="{{ route('admin.managers.destroy', $manager->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger fw-medium">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No Managers Yet</div>
    @endif
</div>
@endsection
