@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary me-2"></i>
            Add New Movie
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
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body bg-white p-lg-5">
            <form action="{{ route('movie.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Movie Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Movie Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter movie name" required>
                    </div>

                    <!-- Language -->
                    <div class="col-md-6">
                        <label for="language" class="form-label">Language</label>
                        <input type="text" class="form-control" id="language" name="language" value="{{ old('language') }}" placeholder="Enter movie language" required>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" placeholder="Enter movie country" required>
                    </div>

                    <!-- Release Date -->
                    <div class="col-md-6">
                        <label for="release_date" class="form-label">Release Date</label>
                        <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date') }}" required>
                    </div>

                    <!-- Runtime -->
                    <div class="col-md-6">
                        <label for="runtime" class="form-label">Runtime (Minutes)</label>
                        <input type="number" class="form-control" id="runtime" name="runtime" value="{{ old('runtime') }}" min="0" placeholder="e.g., 120" required>
                    </div>

                    <!-- Rating -->
                    <div class="col-md-6">
                        <label for="rating" class="form-label">Rating (e.g., PG-13)</label>
                        <input type="text" class="form-control" id="rating" name="rating" value="{{ old('rating') }}" placeholder="e.g., PG-13, R, G" required>
                    </div>

                    <!-- Stars -->
                    <div class="col-md-6">
                        <label for="stars" class="form-label">Stars</label>
                        <input type="text" class="form-control" id="stars" name="stars" value="{{ old('stars') }}" placeholder="Enter names, separated by commas" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status_id" class="form-label">Status</label>
                        <select class="form-select" id="status_id" name="status_id" required>
                            <option value="" disabled selected>-- Select Status --</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
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
                                @foreach ($categories as $category)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}" 
                                                   {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
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
                        <label for="image" class="form-label">Movie Poster</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <!-- Summary -->
                    <div class="col-12">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="5" placeholder="Enter a brief summary of the movie" required>{{ old('summary') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-plus me-2"></i> Add Movie
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
