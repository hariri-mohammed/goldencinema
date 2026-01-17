@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-film text-primary me-2"></i>
            Movie Shows
        </h1>
        <a href="{{ route('manager.movie-shows.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Show
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-info text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-filter me-2"></i>
                Filter Shows
            </h6>
        </div>
        <div class="card-body bg-white">
            <form action="{{ route('manager.movie-shows.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="movie" class="form-label text-gray-700">
                        <i class="fas fa-film me-2"></i>Movie
                    </label>
                    <select name="movie" id="movie" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">All Movies</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ request('movie') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="theater" class="form-label text-gray-700">
                        <i class="fas fa-building me-2"></i>Theater
                    </label>
                    <select name="theater" id="theater" class="form-select border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">All Theaters</option>
                        @foreach($theaters as $theater)
                            <option value="{{ $theater->id }}" {{ request('theater') == $theater->id ? 'selected' : '' }}>
                                {{ $theater->location }} - {{ $theater->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label text-gray-700">
                        <i class="fas fa-calendar me-2"></i>Date
                    </label>
                    <input type="date" class="form-control border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 rounded-md shadow-sm" 
                           id="date" name="date" value="{{ request('date') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-info text-white me-2">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('manager.movie-shows.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Shows Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>
                All Shows
            </h6>
        </div>
        <div class="card-body bg-white">
            <div class="table-responsive">
                <table class="table table-hover" id="showsTable" width="100%" cellspacing="0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-gray-700">Movie</th>
                            <th class="text-gray-700">Theater</th>
                            <th class="text-gray-700">Screen</th>
                            <th class="text-gray-700">Date & Time</th>
                            <th class="text-gray-700">Status</th>
                            <th class="text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shows as $show)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if($show->movie->image)
                                            <img src="{{ asset('img/movie/' . $show->movie->image) }}"
                                                 alt="{{ $show->movie->name }}"
                                                 class="rounded me-2"
                                                 style="width: 40px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 60px;">
                                                <i class="fas fa-film text-white"></i>
                                            </div>
                                        @endif
                                        <span>{{ $show->movie->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{ $show->theater->location }} - {{ $show->theater->city }}
                                    {{-- <pre>{{ var_export($show->theater, true) }}</pre> --}}
                                </td>
                                <td class="align-middle">{{ $show->screen->screen_name }}</td>
                                <td class="align-middle">
                                    <i class="fas fa-clock text-info me-2"></i>
                                    {{ $show->show_time->format('M d, Y h:i A') }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-{{ $show->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
                                        <i class="fas fa-{{ $show->status === 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ ucfirst($show->status) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('manager.movie-shows.show', $show->id) }}" 
                                           class="btn btn-info btn-sm text-white" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('manager.movie-shows.edit', $show->id) }}" 
                                           class="btn btn-primary btn-sm" 
                                           title="Edit Show">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('manager.movie-shows.destroy', $show->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this show?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Show">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">
                                        <i class="fas fa-film fa-3x mb-3"></i>
                                        <p class="mb-0">No shows found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $shows->links() }}
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
    .bg-info {
        background-color: #17a2b8 !important;
    }
    .btn-info {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
    }
    .btn-info:hover {
        background-color: #138496 !important;
        border-color: #117a8b !important;
    }
</style>
@endpush


@endsection
