@extends('layouts.cinema')

@section('title', 'Complete Your Booking')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="card-title text-center mb-4">Complete Your Booking & Payment</h1>
        <h2 class="card-subtitle mb-4 text-muted text-center">
            @if($movieShow->theater)
                {{ $movieShow->movie->name }} - {{ $movieShow->theater->location }}, {{ $movieShow->theater->city }} - {{ $movieShow->screen->screen_name }}
            @else
                {{ $movieShow->movie->name }} - Theater/Screen details not available
            @endif
        </h2>
        <p class="text-center">Date: {{ \Carbon\Carbon::parse($movieShow->show_time)->format('D, M d, Y') }}</p>
        <p class="text-center">Time: {{ \Carbon\Carbon::parse($movieShow->show_time)->format('h:i A') }}</p>
        <p class="text-center fw-bold fs-5">Total Price: ${{ number_format($pending->total_price, 2) }}</p>

        <div class="mt-4 mb-4">
            <h3 class="text-center mb-3">Selected Seats:</h3>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @foreach($selectedSeatsDetails as $seat)
                    @php
                        $seatPrice = ($seat->type === 'vip') ? $movieShow->price * 1.2 : $movieShow->price;
                    @endphp
                    <span class="badge bg-primary fs-6 py-2 px-3">Row {{ $seat->row }} Seat {{ $seat->number }} (${{ number_format($seatPrice, 2) }})</span>
                @endforeach
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger text-center mx-auto" style="max-width: 400px;">{{ session('error') }}</div>
        @endif

        <form action="{{ route('client.payments.store') }}" method="POST" class="mx-auto" style="max-width: 500px;">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3 row">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="card_number" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" value="{{ old('card_number') }}" required pattern="[0-9]{13,16}" title="Enter 13 to 16 digits.">
                    @error('card_number')
                        <div class="text-danger">{{ $message ?: 'Please enter a valid card number.' }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="card_holder_name" class="form-label">Card Holder Name</label>
                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" value="{{ old('card_holder_name') }}" required>
                    @error('card_holder_name')
                        <div class="text-danger">{{ $message ?: 'Please enter the card holder name.' }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="expiration_month" class="form-label">Expiration Month</label>
                    <input type="number" class="form-control" id="expiration_month" name="expiration_month" value="{{ old('expiration_month') }}" required min="1" max="12">
                    @error('expiration_month')
                        <div class="text-danger">{{ $message ?: 'Enter a valid month (1-12).' }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="expiration_year" class="form-label">Expiration Year</label>
                    <input type="number" class="form-control" id="expiration_year" name="expiration_year" value="{{ old('expiration_year') }}" required min="{{ date('Y') }}" max="{{ date('Y') + 10 }}">
                    @error('expiration_year')
                        <div class="text-danger">{{ $message ?: 'Enter a valid year.' }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="cvv" class="form-label">CVV/CVC</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" required pattern="[0-9]{3,4}" title="Enter 3 or 4 digits.">
                    @error('cvv')
                        <div class="text-danger">{{ $message ?: 'Please enter a valid CVV/CVC.' }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirm_payment" name="confirm_payment" required>
                    <label class="form-check-label" for="confirm_payment">
                        I confirm that I want to proceed with this payment of ${{ number_format($pending->total_price, 2) }}
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg" style="max-width: 300px; margin: 0 auto; display: block;">Pay Now</button>
            </div>
        </form>
    </div>
</div>
@endsection 