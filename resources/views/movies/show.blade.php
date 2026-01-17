@extends('layouts.cinema')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cinema_show.css') }}">
    <div class="container movie-details">
        <div class="row">
            <div class="col-md-4 movie-image">
                <img src="{{ asset('img/movie/' . $movie->image) }}" alt="{{ $movie->name }}" class="img-fluid">
            </div>
            <div class="col-md-8 movie-info">
                <h1 class="movie-title">{{ $movie->name }}</h1>
                <div class="movie-meta">
                    <span class="badge bg-secondary">
                        <i class="fas fa-globe"></i> {{ $movie->language }}
                    </span>
                    <span class="badge bg-secondary">
                        <i class="fas fa-map-marker-alt"></i> {{ $movie->country }}
                    </span>
                    <span class="badge bg-secondary">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($movie->release_date)->format('d M Y') }}
                    </span>
                    <span class="badge bg-secondary">
                        <i class="far fa-clock"></i> {{ $movie->formatted_runtime }}
                    </span>
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-star"></i> {{ $movie->rating }}
                    </span>
                </div>
                <p class="movie-summary">{{ $movie->summary }}</p>
                <div class="movie-cast">
                    <strong>Stars:</strong> {{ $movie->stars }}
                </div>
                <div class="movie-categories">
                    <strong>Categories:</strong>
                    @foreach ($movie->categories as $category)
                        <span class="badge bg-info">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Trailer Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="trailer-section">
                    <h2 class="highlight mb-4">
                        <i class="fas fa-film me-2"></i>Movie Trailer
                    </h2>

                    @if ($movie->trailer)
                        <div class="trailer-container">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $movie->trailer->url) }}"
                                    title="{{ $movie->name }} trailer" allowfullscreen class="trailer-frame"></iframe>
                            </div>
                        </div>
                    @else
                        <div class="no-trailer-container">
                            <div class="no-trailer-content">
                                <i class="fas fa-video-slash"></i>
                                <p>Trailer coming soon!</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Showtimes Section -->
        <div class="container">
            <div class="row">
                <hr class="dashed">
                <div class="showtimes">
                    <h2 class="highlight">
                        Showtimes
                    </h2>
                    @if ($groupedShows->isNotEmpty())
                        <div class="showtimes-list mt-4">
                            {{-- Create a new row for each chunk of 3 dates --}}
                            @foreach ($groupedShows->keys()->chunk(3) as $dateChunk)
                                <div class="row mb-4">
                                    {{-- Create a column for each date in the chunk --}}
                                    @foreach ($dateChunk as $date)
                                        <div class="col-md-4">
                                            <div class="showtime-date-group h-100">
                                                <h3 class="date-header mb-3">
                                                    <i class="far fa-calendar-alt me-2"></i>
                                                    {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                                </h3>
                                                
                                                @if(isset($groupedShows[$date]))
                                                    @foreach ($groupedShows[$date] as $location => $data)
                                                        <div class="showtime-group card mb-3">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-2">
                                                                    <i class="fas fa-map-marker-alt me-2"></i>
                                                                    {{ $location }} ({{ $data['theater']->city }})
                                                                </h5>
                                                                <div class="showtime-times d-flex flex-wrap gap-2">
                                                                    @foreach ($data['times'] as $time)
                                                                        <a href="{{ route('booking.create', $time['id']) }}" 
                                                                           class="badge bg-success showtime-badge px-3 py-2 rounded-pill d-flex align-items-center justify-content-center text-decoration-none">
                                                                            <i class="far fa-clock me-1"></i>
                                                                            {{ $time['start'] }}
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 mt-4">
                            <i class="fas fa-film fa-3x mb-3"></i>
                            <p>No showtimes are currently available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="related-movies mt-4 mp-4">
                    <h2>Related Movies</h2>
                    <div class="related-movies-slider">
                        @foreach ($relatedMovies as $relatedMovie)
                            <div class="movie-card">
                                <a href="{{ route('movies.show', $relatedMovie->id) }}">
                                    @if ($relatedMovie->image)
                                        <img src="{{ asset('img/movie/' . $relatedMovie->image) }}"
                                            alt="{{ $relatedMovie->name }}" class="img-fluid">
                                    @else
                                        <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image" class="img-fluid">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $relatedMovie->name }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <style>
        .trailer-section {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .trailer-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .trailer-frame {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .no-trailer-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .no-trailer-content {
            color: #6c757d;
        }

        .no-trailer-content i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            display: block;
            opacity: 0.8;
        }

        .no-trailer-content p {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 500;
        }

        .highlight {
            color: #2c3e50;
            font-weight: 600;
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .highlight:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #007bff;
            border-radius: 2px;
        }

        .date-header {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .city-header {
            color: #495057;
            font-size: 1.25rem;
            font-weight: 500;
            padding-left: 1rem;
            border-left: 3px solid #007bff;
        }

        .showtime-group {
            transition: transform 0.2s ease-in-out;
            height: 100%;
        }

        .showtime-group:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .showtime-badge {
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
        }

        .showtime-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .theater-info {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
        }

        .theater-details {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .hall-badge {
            margin: 1rem 0;
        }

        .card-body {
            display: flex;
            flex-direction: column;
        }

        .showtime-times {
            margin-top: auto;
        }

        /* Animation for the trailer section */
        .trailer-section {
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .trailer-section {
                padding: 1.5rem;
            }

            .no-trailer-container {
                padding: 2rem;
                min-height: 200px;
            }

            .no-trailer-content i {
                font-size: 2.5rem;
            }

            .no-trailer-content p {
                font-size: 1.1rem;
            }
        }
    </style>
