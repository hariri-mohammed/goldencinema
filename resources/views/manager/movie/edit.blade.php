@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-primary me-2"></i>
            Edit Movie: {{ $movie->name }}
        </h1>
        <a href="{{ route('movie.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Movie List
        </a>
    </div>

    <!-- Error/Success Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body bg-white p-lg-5">
            <form action="{{ route('movie.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Movie Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Movie Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $movie->name) }}" required>
                    </div>

                    <!-- Language -->
                    <div class="col-md-6">
                        <label for="language" class="form-label">Language</label>
                        <input type="text" class="form-control" id="language" name="language" value="{{ old('language', $movie->language) }}" required>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $movie->country) }}" required>
                    </div>

                    <!-- Release Date -->
                    <div class="col-md-6">
                        <label for="release_date" class="form-label">Release Date</label>
                        <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Runtime -->
                    <div class="col-md-6">
                        <label for="runtime" class="form-label">Runtime (Minutes)</label>
                        <input type="number" class="form-control" id="runtime" name="runtime" value="{{ old('runtime', $movie->runtime) }}" min="0" required>
                    </div>

                    <!-- Rating -->
                    <div class="col-md-6">
                        <label for="rating" class="form-label">Rating (e.g., PG-13)</label>
                        <input type="text" class="form-control" id="rating" name="rating" value="{{ old('rating', $movie->rating) }}" required>
                    </div>

                    <!-- Stars -->
                    <div class="col-md-6">
                        <label for="stars" class="form-label">Stars</label>
                        <input type="text" class="form-control" id="stars" name="stars" value="{{ old('stars', $movie->stars) }}" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status_id" class="form-label">Status</label>
                        <select class="form-select" id="status_id" name="status_id" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id', $movie->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Categories -->
                    <div class="col-12">
                        <label class="form-label">Categories</label>
                        <div class="category-checkbox-group p-3 border rounded">
                            <div class="row">
                                @php
                                    $movieCategories = old('categories', $movie->categories->pluck('id')->toArray());
                                @endphp
                                @foreach ($categories as $category)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}" 
                                                   {{ is_array($movieCategories) && in_array($category->id, $movieCategories) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category_{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Movie Poster -->
                    <div class="col-12">
                        <label for="image" class="form-label">New Movie Poster (Optional)</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if ($movie->image)
                            <div class="mt-2">
                                <small class="text-muted">Current Poster:</small>
                                <img src="{{ asset('img/movie/' . $movie->image) }}" alt="{{ $movie->name }}" class="img-thumbnail mt-1" style="width: 100px; height: auto;">
                            </div>
                        @endif
                    </div>

                    <!-- Summary -->
                    <div class="col-12">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="5" required>{{ old('summary', $movie->summary) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save me-2"></i> Update Movie
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .category-checkbox-group {
        background-color: #f8f9fa;
        max-height: 200px;
        overflow-y: auto;
    }
    .form-check-label {
        font-weight: 500;
    }
</style>
@endpush
@endsection
