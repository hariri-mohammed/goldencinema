@extends('layouts.manager')

@section('content')
    <div class="container-fluid px-4 py-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-video text-primary me-2"></i>
                Trailers
            </h1>
            <a href="{{ route('movie.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i> Back to Movie List
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

        <!-- Trailers Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-list me-2"></i>
                    All Trailers
                </h6>
            </div>
            <div class="card-body bg-white">
                @if ($movies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-gray-700">Movie Title</th>
                                    <th class="text-gray-700">Trailer Status</th>
                                    <th class="text-gray-700 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movies as $movie)
                                    <tr>
                                        <td class="align-middle">{{ $movie->name }}</td>
                                        <td class="align-middle">
                                            @if ($movie->trailer)
                                                <span class="badge bg-success px-3 py-2">Has Trailer</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">No Trailer</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="btn-group" role="group">
                                                @if ($movie->trailer)
                                                    <a href="{{ $movie->trailer->url }}"
                                                        class="btn btn-info btn-sm text-white" target="_blank"
                                                        title="Watch Trailer">
                                                        <i class="fas fa-play"></i>
                                                    </a>
                                                    <a href="{{ route('manager.trailers.edit', $movie->trailer->id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit Trailer">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#m{{ $movie->trailer->id }}"
                                                        title="Delete Trailer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('manager.trailers.create', $movie->id) }}"
                                                        class="btn btn-success btn-sm" title="Add Trailer">
                                                        <i class="fas fa-plus"></i> Add Trailer
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($movie->trailer)
                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="m{{ $movie->trailer->id }}" tabindex="-1"
                                            aria-labelledby="Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white py-3">
                                                        <h5 class="modal-title" id="Label">Delete Trailer for <strong
                                                                class="text-warning">{{ $movie->name }}</strong></h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-gray-800">
                                                        Are you sure you want to delete this trailer?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('manager.trailers.destroy', $movie->trailer->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="text-gray-500">
                            <i class="fas fa-video fa-3x mb-3"></i>
                            <p class="mb-0">No trailers found.</p>
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

            .card {
                border-radius: 0.5rem;
            }

            .card-header {
                border-radius: 0.5rem 0.5rem 0 0 !important;
            }
        </style>
    @endpush
@endsection
