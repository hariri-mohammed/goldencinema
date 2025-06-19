@extends('layouts.cinema')

@section('title', 'Booking Details')

@section('content')
<div class="container mt-5">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('client.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to My Bookings
        </a>
    </div>

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Booking Details</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>Movie Information</h3>
                    <p><strong>Movie:</strong> {{ $booking->movieShow->movie->name }}</p>
                    <p><strong>Date:</strong> {{ $booking->movieShow->show_time->format('D, M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ $booking->movieShow->show_time->format('h:i A') }}</p>
                    <p><strong>Theater:</strong> {{ $booking->movieShow->theater->location }}</p>
                    <p><strong>Screen:</strong> {{ $booking->movieShow->screen->screen_name }}</p>
                </div>
                <div class="col-md-6">
                    <h3>Booking Information</h3>
                    <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                    <p><strong>Booking Date:</strong> {{ $booking->booking_date->format('D, M d, Y h:i A') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </p>
                    
                    <p><strong>Number of Tickets:</strong> {{ $booking->number_of_tickets }}</p>
                    <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h3>Selected Seats</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Seat</th>
                                <th>Type</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->seat->row }}{{ $ticket->seat->number }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->seat->type === 'vip' ? 'warning' : 'info' }}">
                                        {{ strtoupper($ticket->seat->type) }}
                                    </span>
                                </td>
                                <td>${{ number_format($ticket->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Ticket Button -->
    <div class="text-center mt-4">
    @if($booking->tickets->count())
            <a href="{{ route('client.tickets.download', $ticket->id) }}" class="btn btn-success btn-lg mb-2">
                <i class="fas fa-download"></i> Download Ticket PDF 
            </a>
        @endif
    </div>
</div>

@endsection 