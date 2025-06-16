@extends('layouts.manager')

@section('content')
    <div class="container-fluid px-4 py-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-film text-primary me-2"></i>
                Show Details
            </h1>
            <div>
                <a href="{{ route('manager.movie-shows.edit', $show->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('manager.movie-shows.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body bg-white">
                <div class="row">
                    <!-- Movie Information -->
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if ($show->movie->img)
                                <img src="data:image/jpeg;base64,{{ base64_encode($show->movie->img) }}"
                                    class="card-img-top mx-auto d-block" alt="{{ $show->movie->name }}"
                                    style="margin-top: 15px; width: 120px; height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mx-auto"
                                    style="margin-top: 15px; width: 120px; height: 180px;">
                                    <i class="fas fa-film text-white" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $show->movie->name }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        {{ $show->movie->runtime }} minutes |
                                        {{ $show->movie->language }} |
                                        Rating: {{ $show->movie->rating }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Show Details -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Timing Information -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Show Time</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Date</dt>
                                    <dd class="col-sm-8">{{ $show->show_time->format('F j, Y') }}</dd>

                                    <dt class="col-sm-4">Time</dt>
                                    <dd class="col-sm-8">{{ $show->show_time->format('h:i A') }}</dd>

                                    <dt class="col-sm-4">Duration</dt>
                                    <dd class="col-sm-8">{{ $show->movie->runtime }} minutes</dd>
                                </dl>
                            </div>

                            <!-- Location Information -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Location</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Theater</dt>
                                    <dd class="col-sm-8">{{ $show->theater->location }} - {{ $show->theater->city }}</dd>

                                    <dt class="col-sm-4">Screen</dt>
                                    <dd class="col-sm-8">{{ $show->screen->screen_name }}</dd>
                                </dl>
                            </div>

                            <!-- Status and Price -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Status</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Status</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge bg-{{ $show->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($show->status) }}
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4">Price</dt>
                                    <dd class="col-sm-8">${{ number_format($show->price, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
