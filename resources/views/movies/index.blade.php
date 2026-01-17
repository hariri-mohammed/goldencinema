@extends('layouts.cinema')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cinema_index.css') }}">

    <div class="container">
        @if (!request('search'))
            <!-- Swiper Carousel -->
            <div id="mainCarousel" class="swiper movie-swiper">
                <div class="swiper-wrapper">
                    @foreach($movies as $movie)
                        <div class="swiper-slide">
                            <a href="{{ route('movies.show', $movie->id) }}">
                                <div class="position-relative">
                                    @if ($movie->image)
                                        <img src="{{ asset('img/movie/' . $movie->image) }}"
                                             class="d-block w-100" alt="{{ $movie->name }}">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                             style="width: 100%; height: 300px;">
                                            <i class="fas fa-film text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> {{ $movie->rating }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- قسم الفلاتر -->
            <div class="filter-section my-4">
                <div class="row g-4 align-items-center">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <!-- فلتر الفئات -->
                            <div class="category-select" role="button">
                                <span class="category-label">Categories:</span>
                                <span id="selectedCategoryText">All Categories</span>
                                <span class="arrow-down">&#9660;</span>
                                <ul id="categoryOptions" class="category-options">
                                    <li data-value="all" class="selected">All Categories</li>
                                    @foreach ($categories as $category)
                                        <li data-value="{{ $category->id }}">{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- أزرار الحالة -->
                            <div class="button-group gap-2">
                                <div class="chip filter-btn active" data-filter="all" role="button">
                                    <span class="chip-label">All</span>
                                </div>
                                <div class="chip filter-btn" data-filter="1" role="button">
                                    <span class="chip-label">Now Showing</span>
                                </div>
                                <div class="chip filter-btn" data-filter="2" role="button">
                                    <span class="chip-label">Coming Soon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Movies Grid -->
        <div class="row g-4 movies-grid" id="movies-grid">
            @forelse ($movies as $movie)
                <div class="movie-item" data-status="{{ $movie->status_id }}"
                    data-categories="{{ json_encode($movie->categories->pluck('id')) }}">
                    <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none text-dark">
                        <div class="movie-card w-100 h-100">
                            @if ($movie->image)
                                <img src="{{ asset('img/movie/' . $movie->image) }}"
                                    alt="{{ $movie->name }}" class="movie-img">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 300px;">
                                    <i class="fas fa-film text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2 flex-grow-1">{{ $movie->name }}</h5>
                                <div class="d-flex justify-content-between align-items-end">
                                    <span class="badge bg-primary">
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                                    </span>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> {{ $movie->rating }}
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-secondary">
                                        {{ $movie->categories->pluck('name')->join(', ') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="d-flex flex-column justify-content-center align-items-center text-center"
                    style="min-height: calc(100vh - 180px); min-width: -webkit-fill-available;">
                    @if (request('search'))
                        <h4 class="text-muted my-3">No movies found matching your search.</h4>
                    @else
                        <h4 class="text-muted my-3">لا توجد أفلام متاحة.</h4>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
    <script src="{{ asset('js/cinema_index.js') }}"></script>

    @auth('client')
        <!-- إذا كان المستخدم مسجلاً -->
    @else
        <!-- إذا لم يكن المستخدم مسجلاً -->
        <div class="flex items-center gap-4">
            <button onclick="showLoginModal()"
                class="flex items-center space-x-2 bg-transparent text-second-color hover:text-darker-color">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="font-semibold">Login</span>
            </button>
        </div>
    @endauth

    @include('movies.register_modal')
@endsection
