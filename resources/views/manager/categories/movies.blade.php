@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-film text-primary me-2"></i>
            Movies in {{ $category->name }}
        </h1>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Categories
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Movies Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>
                All Movies in {{ $category->name }}
            </h6>
        </div>
        <div class="card-body bg-white">
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-gray-700">Movie</th>
                            <th class="text-gray-700">Language</th>
                            <th class="text-gray-700">Country</th>
                            <th class="text-gray-700">Release Date</th>
                            <th class="text-gray-700">Runtime</th>
                            <th class="text-gray-700">Rating</th>
                            <th class="text-gray-700">Status</th>
                            <th class="text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movies as $movie)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if($movie->image)
                                            <img src="{{ asset('img/movie/' . $movie->image) }}"
                                                 alt="{{ $movie->name }}"
                                                 class="rounded me-2"
                                                 style="width: 40px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 60px;">
                                                <i class="fas fa-film text-white"></i>
                                            </div>
                                        @endif
                                        <span>{{ $movie->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $movie->language }}</td>
                                <td class="align-middle">{{ $movie->country }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') }}</td>
                                <td class="align-middle">{{ $movie->runtime }} min</td>
                                <td class="align-middle">{{ $movie->rating }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-{{ $movie->status->name === 'Showing Now' ? 'success' : 'danger' }} px-3 py-2">
                                        {{ ucfirst($movie->status->name) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('movie.show', $movie->id) }}"
                                           class="btn btn-info btn-sm text-white"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-gray-500">
                                        <i class="fas fa-film fa-3x mb-3"></i>
                                        <p class="mb-0">No movies found for this category.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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