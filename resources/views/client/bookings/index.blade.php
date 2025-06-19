@extends('layouts.cinema')

@section('title', 'My Bookings')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">My Bookings</h2>
        </div>
        <div class="card-body">
            @if(session('payment_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('payment_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($bookings->isEmpty())
                <div class="text-center py-5">
                    <h3 class="text-muted">No bookings found</h3>
                    <p class="text-muted">You haven't made any bookings yet.</p>
                    <a href="{{ route('movies.index') }}" class="btn btn-primary mt-3">Browse Movies</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Booking ID</th>
                                <th>Movie</th>
                                <th>Date & Time</th>
                                <th>Theater</th>
                                <th>Tickets</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->movieShow->movie->name }}</td>
                                <td>
                                    {{ $booking->movieShow->show_time->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $booking->movieShow->show_time->format('h:i A') }}</small>
                                </td>
                                <td>
                                    {{ $booking->movieShow->theater->name }}
                                    <br>
                                    <small class="text-muted">Screen: {{ $booking->movieShow->screen->screen_name }}</small>
                                </td>
                                <td>{{ $booking->number_of_tickets }}</td>
                                <td>${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('client.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                        View Details
                                    </a>
                                    @if($booking->tickets->count())
                                        <a href="{{ route('client.tickets.download', $booking->tickets->first()->id) }}" class="btn btn-sm btn-success mb-1">Download Ticket</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 