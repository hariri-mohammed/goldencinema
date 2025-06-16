@extends('layouts.cinema')

@section('title', 'Booking Details')

@section('content')
<div class="container mt-5">
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

            @if($booking->status === 'pending')
            <div class="mt-4">
                <h3>Payment Information</h3>
                <p class="text-muted">Please complete the payment to confirm your booking.</p>
                <form action="{{ route('client.bookings.pay', $booking) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                </form>
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('client.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
                @if($booking->status === 'pending')
                <form action="{{ route('client.bookings.cancel', $booking) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                        Cancel Booking
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 