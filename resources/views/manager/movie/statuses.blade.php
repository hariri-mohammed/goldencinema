@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-toggle-on text-primary me-2"></i>
            Movie Statuses
        </h1>
        <a href="{{ route('movie.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Movie List
        </a>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Movies Status List -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-film me-2"></i>
                All Movie Statuses
            </h6>
        </div>
        <div class="card-body bg-white">
            @if ($movies->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($movies as $movie)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-4 text-center d-flex align-items-center justify-content-center p-2">
                                        @if($movie->img)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($movie->img) }}"
                                                 class="img-fluid rounded shadow-sm"
                                                 alt="{{ $movie->name }}"
                                                 style="width: 80px; height: 120px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded shadow-sm d-flex align-items-center justify-content-center"
                                                 style="width: 80px; height: 120px;">
                                                <i class="fas fa-film text-white" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-gray-800 mb-2">{{ $movie->name }}</h5>
                                            <p class="card-text mb-2">
                                                <span class="badge bg-{{ $movie->status->name === 'Showing Now' ? 'success' : 'danger' }} px-3 py-2">
                                                    <i class="fas fa-circle me-1"></i> {{ ucfirst($movie->status->name) }}
                                                </span>
                                            </p>
                                            <div class="mt-auto">
                                                <a href="{{ route('movie.editStatus', $movie->id) }}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-exchange-alt me-1"></i> Change Status
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <div class="text-gray-500">
                        <i class="fas fa-film fa-3x mb-3"></i>
                        <p class="mb-0">No movies found for status management.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-text .badge {
        font-size: 0.85rem;
    }
    /* Custom styles for consistency with manager layout */
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
