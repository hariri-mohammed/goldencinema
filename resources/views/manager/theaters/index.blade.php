@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building text-primary me-2"></i>
            Theaters
        </h1>
        <a href="{{ route('manager.theaters.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Theater
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Theaters Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>
                All Theaters
            </h6>
        </div>
        <div class="card-body bg-white">
            @if ($theaters->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" width="100%" cellspacing="0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-gray-700">#</th>
                                <th class="text-gray-700">Location</th>
                                <th class="text-gray-700">City</th>
                                <th class="text-gray-700">Screens</th>
                                <th class="text-gray-700">Upcoming Shows</th>
                                <th class="text-gray-700 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($theaters as $theater)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $theater->location }}</td>
                                    <td class="align-middle">{{ $theater->city }}</td>
                                    <td class="align-middle">{{ $theater->screens_count ?? 0 }}</td>
                                    <td class="align-middle">{{ $theater->upcoming_shows ?? 0 }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Add Screens Button -->
                                            <a href="{{ route('manager.theaters.screens.index', $theater->id) }}"
                                                class="btn btn-info btn-sm text-white" title="Manage Screens">
                                                <i class="fas fa-tv"></i>
                                            </a>
                                            <!-- Edit Button -->
                                            <a href="{{ route('manager.theaters.edit', $theater->id) }}"
                                                class="btn btn-primary btn-sm" title="Edit Theater">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#m{{ $theater->id }}" title="Delete Theater">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="m{{ $theater->id }}" tabindex="-1"
                                    aria-labelledby="Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white py-3">
                                                <h5 class="modal-title" id="Label">Delete Theater <strong class="text-warning">{{ $theater->location }}</strong></h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-gray-800">
                                                <p>Are you sure you want to delete
                                                    <strong>{{ $theater->location }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form
                                                    action="{{ route('manager.theaters.destroy', $theater->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="text-gray-500">
                        <i class="fas fa-theater-masks fa-3x mb-3"></i>
                        <p class="mb-0">No theaters available</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-group .btn {
        margin: 0 2px;
    }
    .table th {
        font-weight: 600;
    }
    .badge {
        font-size: 0.85rem;
    }
    .modal-title {
        font-weight: 600;
    }
    .modal-header .btn-close {
        filter: invert(1);
    }
    .form-label {
        font-weight: 500;
    }
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
</style>
@endpush
@endsection
