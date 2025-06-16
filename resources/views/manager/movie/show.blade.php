@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-film text-primary me-2"></i>
            Movie Details
        </h1>
        <a href="{{ route('movie.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Movie List
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body bg-white">
            <div class="row">
                <!-- Movie Information -->
                <div class="col-md-4 text-center">
                    <div class="card h-100 border-0">
                        @if($movie->img)
                            <img src="data:image/jpeg;base64,{{ base64_encode($movie->img) }}"
                                 class="img-fluid rounded shadow-sm mx-auto d-block"
                                 alt="{{ $movie->name }}"
                                 style="width: 180px; height: 270px; object-fit: cover; margin-top: 15px;">
                        @else
                            <div class="bg-secondary rounded shadow-sm mx-auto d-flex align-items-center justify-content-center"
                                 style="width: 180px; height: 270px; margin-top: 15px;">
                                <i class="fas fa-film text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-gray-800">{{ $movie->name }}</h5>
                            <p class="card-text text-muted mb-0">
                                {{ $movie->runtime }} minutes | {{ $movie->language }} | Rating: {{ $movie->rating }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Movie Details -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h6 class="border-bottom pb-2 text-primary"><i class="fas fa-info-circle me-2"></i>General Info</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-3 text-gray-700">Language:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ $movie->language }}</dd>

                                <dt class="col-sm-3 text-gray-700">Country:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ $movie->country }}</dd>

                                <dt class="col-sm-3 text-gray-700">Release Date:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ \Carbon\Carbon::parse($movie->release_date)->format('F j, Y') }}</dd>

                                <dt class="col-sm-3 text-gray-700">Runtime:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ $movie->runtime }} minutes</dd>

                                <dt class="col-sm-3 text-gray-700">Rating:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ $movie->rating }}</dd>

                                <dt class="col-sm-3 text-gray-700">Stars:</dt>
                                <dd class="col-sm-9 text-gray-800">{{ $movie->stars }}</dd>
                            </dl>
                        </div>

                        <div class="col-12 mb-4">
                            <h6 class="border-bottom pb-2 text-primary"><i class="fas fa-list-alt me-2"></i>Categories</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($movie->categories as $category)
                                    <span class="badge bg-info px-3 py-2"><i class="fas fa-tag me-1"></i>{{ $category->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary"><i class="fas fa-align-left me-2"></i>Summary</h6>
                            <p class="text-gray-800">{{ $movie->summary }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card-body .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .card-body .card-text {
        font-size: 0.9rem;
    }
    .text-red {
        color: #e74c3c; /* Defined a more specific red for emphasis */
        font-weight: 600;
    }
    .dl-horizontal dt {
        float: left;
        width: 160px;
        overflow: hidden;
        clear: left;
        text-align: right;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .dl-horizontal dd {
        margin-left: 180px;
    }
    .badge {
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
