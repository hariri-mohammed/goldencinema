@extends('layouts.manager')

@section('content')
@php
    if (!isset($screens)) {
        $screens = collect();
    }
@endphp
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus text-primary me-2"></i>
            Add New Show
        </h1>
        <a href="{{ route('manager.movie-shows.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Shows
        </a>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form (Theater Selection) -->
    <form action="{{ route('manager.movie-shows.create') }}" method="GET" id="filterForm" class="mb-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label for="theater_id" class="form-label text-gray-700">
                    <i class="fas fa-building me-2"></i>Theater
                </label>
                <select name="theater_id" id="theater_id" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" onchange="document.getElementById('filterForm').submit();" required>
                    <option value="">Select a Theater</option>
                    @foreach($theaters as $theater)
                        <option value="{{ $theater->id }}" {{ request('theater_id') == $theater->id ? 'selected' : '' }}>
                            {{ $theater->location }} - {{ $theater->city }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <!-- Create Form (POST) -->
    <form action="{{ route('manager.movie-shows.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-film me-2"></i>
                    Show Details
                </h6>
            </div>
            <div class="card-body bg-white">
                <div class="row g-4">
                    <!-- Movie Selection -->
                    <div class="col-md-6">
                        <label for="movie_id" class="form-label text-gray-700">
                            <i class="fas fa-film me-2"></i>Movie
                        </label>
                        <select name="movie_id" id="movie_id" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" required>
                            <option value="">Select a Movie</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                    {{ $movie->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Theater Selection (Disabled) -->
                    <div class="col-md-6">
                        <label for="theater_id_disabled" class="form-label text-gray-700">
                            <i class="fas fa-building me-2"></i>Theater
                        </label>
                        <select id="theater_id_disabled" class="form-select" disabled>
                            <option value="">Select a Theater</option>
                            @foreach($theaters as $theater)
                                <option value="{{ $theater->id }}" {{ request('theater_id') == $theater->id ? 'selected' : '' }}>
                                    {{ $theater->location }} - {{ $theater->city }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="theater_id" value="{{ request('theater_id') }}">
                    </div>

                    <!-- Screen Selection -->
                    <div class="col-md-6">
                        <label for="screen_id" class="form-label text-gray-700">
                            <i class="fas fa-tv me-2"></i>Screen
                        </label>
                        <select name="screen_id" id="screen_id" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" required>
                            <option value="">Select a Screen</option>
                            @foreach($screens as $screen)
                                <option value="{{ $screen->id }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
                                    {{ $screen->screen_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Show Time -->
                    <div class="col-md-6">
                        <label for="show_time" class="form-label text-gray-700">
                            <i class="fas fa-clock me-2"></i>Show Time
                        </label>
                        <input type="datetime-local" 
                               class="form-control border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" 
                               id="show_time" 
                               name="show_time" 
                               value="{{ old('show_time') }}"
                               required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status" class="form-label text-gray-700">
                            <i class="fas fa-toggle-on me-2"></i>Status
                        </label>
                        <select name="status" id="status" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <label for="price" class="form-label text-gray-700">
                            <i class="fas fa-ticket-alt me-2"></i>Price
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-gray-100 border-gray-300">$</span>
                            <input type="number" 
                                   class="form-control border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Show
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
