@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt text-primary me-2"></i>
            Admin Dashboard
        </h1>
    </div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Clients Count
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clientsCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Bookings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookingsToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Monthly Bookings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookingsMonth }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Movies Count
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $moviesCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-film fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Today's Shows
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showsToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tv fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                This Week's Shows
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showsWeek }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Seats Statistics
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Total: {{ $seatsTotal }}</div>
                            <div class="h6 mb-0 font-weight-bold text-success">Booked: {{ $seatsBooked }}</div>
                            <div class="h6 mb-0 font-weight-bold text-info">Available: {{ $seatsAvailable }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chair fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Booked Movies Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <i class="fas fa-star me-2"></i>Top Booked Movies
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Movie Name</th>
                                <th>Bookings Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topMovies as $movie)
                                <tr>
                                    <td><i class="fas fa-film text-warning me-1"></i> {{ $movie->name }}</td>
                                    <td><span class="badge bg-success">{{ $movie->bookings_count ?? 0 }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
    .card.border-left-primary { border-left: .25rem solid #4e73df !important; }
    .card.border-left-success { border-left: .25rem solid #1cc88a !important; }
    .card.border-left-info { border-left: .25rem solid #36b9cc !important; }
    .card.border-left-warning { border-left: .25rem solid #f6c23e !important; }
    .card.border-left-danger { border-left: .25rem solid #e74a3b !important; }
    .card.border-left-secondary { border-left: .25rem solid #858796 !important; }
    .text-primary { color: #4e73df !important; }
    .text-success { color: #1cc88a !important; }
    .text-info { color: #36b9cc !important; }
    .text-warning { color: #f6c23e !important; }
    .text-danger { color: #e74a3b !important; }
    .text-secondary { color: #858796 !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .text-gray-300 { color: #dddfeb !important; }
    .text-xs { font-size: 0.7rem; }
    .font-weight-bold { font-weight: 700 !important; }
    .text-uppercase { text-transform: uppercase !important; }
    .no-gutters { margin-right: 0; margin-left: 0; }
    .card-body { flex: 1 1 auto; padding: 1.25rem; }
    .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
    .h-100 { height: 100% !important; }
    .shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important; }
    .bg-gradient-primary {
        background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
    }
    .badge.bg-success {
        background-color: #1cc88a !important;
        color: #fff;
        font-size: 1rem;
        padding: 0.5em 1em;
    }
</style>
@endpush
@endsection 