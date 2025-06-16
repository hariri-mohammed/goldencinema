@extends('layouts.cinema') {{-- افتراض وجود layout أساسي --}}

@section('title', 'Book Tickets for ' . $movieShow->movie->title)

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="card-title text-center mb-4">{{ $movieShow->movie->name }}</h1>
        <h2 class="card-subtitle mb-4 text-muted text-center">
            @if($movieShow->theater)
                {{ $movieShow->theater->location }}, {{ $movieShow->theater->city }} - {{ $movieShow->screen->screen_name }}
            @else
                Theatre/Screen Name Not Available
            @endif
        </h2>
        <p class="text-center">Date: {{ \Carbon\Carbon::parse($movieShow->show_time)->format('D, M d, Y') }}</p>
        <p class="text-center">Time: {{ \Carbon\Carbon::parse($movieShow->show_time)->format('h:i A') }}</p>
        <p class="text-center">Base Ticket Price: ${{ number_format($movieShow->price, 2) }}</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="movie_show_id" value="{{ $movieShow->id }}">

            <div class="seat-selection-area mb-4">
                <h3 class="text-center mb-3">Select Your Seats</h3>
                <div class="screen-display text-center mb-4">
                    <img src="https://via.placeholder.com/600x50/F8F9FA/6C757D?text=Screen" alt="Screen" class="img-fluid rounded shadow-sm">
                </div>

                <div class="theater-layout text-center">
                    @foreach($seatsByRow as $row => $seats)
                        <div class="seat-row mb-2 d-flex justify-content-center align-items-center">
                            <span class="row-label me-2 fw-bold">{{ $row }}</span>
                            @foreach($seats as $seat)
                                @if($seat->isAisle())
                                    <div class="seat aisle" title="Aisle"></div>
                                @else
                                    <div
                                        class="seat {{ in_array($seat->id, $bookedSeatIds) ? 'booked' : '' }} {{ $seat->type }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-seat-price="{{ $movieShow->price }}"
                                        data-seat-type="{{ $seat->type }}"
                                        title="Row: {{ $seat->row }}, Number: {{ $seat->number }} {{ $seat->type === 'vip' ? '(VIP)' : '' }} {{ in_array($seat->id, $bookedSeatIds) ? '(Booked)' : '' }}"
                                    >
                                        {{ $seat->number }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="seat-legend mt-4 d-flex justify-content-center gap-3">
                    <div class="legend-item"><span class="seat available"></span> Available</div>
                    <div class="legend-item"><span class="seat booked"></span> Booked</div>
                    <div class="legend-item"><span class="seat vip"></span> VIP ({{ number_format($movieShow->price * 1.2, 2) }}$)</div>
                    <div class="legend-item"><span class="seat aisle"></span> Aisle</div>
                </div>

                <div class="selected-seats-display mt-4 text-center">
                    <h4 class="mb-3">Selected Seats: <span id="selected-seats-count">0</span></h4>
                    <div id="selected-seats-list" class="d-flex flex-wrap justify-content-center gap-2">
                        <!-- Selected seats will be appended here -->
                    </div>
                    <input type="hidden" name="selected_seats" id="selected-seats-input">
                </div>

                <div class="total-price-display text-center mt-4">
                    <h3>Total Price: $<span id="total-price">0.00</span></h3>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg" id="confirm-booking-btn" disabled>Confirm Booking</button>
            </div>
        </form>
    </div>
</div>

<style>
    .seat-selection-area {
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 8px;
    }
    .screen-display img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }
    .theater-layout {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .seat-row {
        display: flex;
        align-items: center;
    }
    .row-label {
        width: 30px; /* Adjust as needed */
        text-align: right;
    }
    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        font-size: 0.9em;
        font-weight: bold;
        transition: background-color 0.2s, border-color 0.2s;
    }
    .seat.available {
        background-color: #e9ecef;
    }
    .seat.available:hover {
        background-color: #cfe2ff;
        border-color: #0d6efd;
    }
    .seat.booked {
        background-color: #dc3545;
        color: white;
        cursor: not-allowed;
    }
    .seat.booked:hover {
        background-color: #dc3545; /* No change on hover for booked seats */
        border-color: #dc3545;
    }
    .seat.selected {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    .seat.vip {
        background-color: #ffc107;
        color: #343a40;
    }
    .seat.vip.selected {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    .seat.vip.booked {
        background-color: #dc3545; /* VIP booked is same as regular booked */
        color: white;
    }
    .seat.aisle {
        background-color: #6c757d;
        cursor: default;
        border-color: #6c757d;
        opacity: 0.5;
        width: 20px; /* Smaller for aisle */
        margin: 5px 2px; /* Adjust margin */
    }
    .seat-legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .legend-item {
        display: flex;
        align-items: center;
        font-size: 0.9em;
    }
    .legend-item .seat {
        width: 20px;
        height: 20px;
        margin: 0 5px 0 0;
        cursor: default;
    }
    #selected-seats-list span {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 2px;
        font-size: 0.9em;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seatsContainer = document.querySelector('.theater-layout');
        const selectedSeatsInput = document.getElementById('selected-seats-input');
        const selectedSeatsCount = document.getElementById('selected-seats-count');
        const selectedSeatsList = document.getElementById('selected-seats-list');
        const totalPriceDisplay = document.getElementById('total-price');
        const confirmBookingBtn = document.getElementById('confirm-booking-btn');

        let selectedSeats = new Map(); // Using Map to store seatId -> price

        seatsContainer.addEventListener('click', function(event) {
            let seatElement = event.target.closest('.seat');

            if (seatElement && !seatElement.classList.contains('booked') && !seatElement.classList.contains('aisle')) {
                const seatId = seatElement.dataset.seatId;
                const seatPrice = parseFloat(seatElement.dataset.seatPrice);
                const seatType = seatElement.dataset.seatType;
                const row = seatElement.parentNode.querySelector('.row-label').textContent;
                const number = seatElement.textContent.trim();
                const fullSeatName = `${row}${number}`;

                if (seatElement.classList.contains('selected')) {
                    // Deselect seat
                    seatElement.classList.remove('selected');
                    selectedSeats.delete(seatId);
                } else {
                    // Select seat
                    seatElement.classList.add('selected');
                    selectedSeats.set(seatId, { price: seatPrice, type: seatType, name: fullSeatName });
                }
                updateSelectedSeatsDisplay();
            }
        });

        function updateSelectedSeatsDisplay() {
            let currentTotal = 0;
            let currentSelectedIds = [];
            let currentSelectedNames = [];

            selectedSeatsList.innerHTML = ''; // Clear previous display

            selectedSeats.forEach((seat, id) => {
                let price = seat.price;
                if (seat.type === 'vip') {
                    price *= 1.2; // Apply VIP markup
                }
                currentTotal += price;
                currentSelectedIds.push(id);
                currentSelectedNames.push(seat.name + (seat.type === 'vip' ? ' (VIP)' : ''));

                const seatTag = document.createElement('span');
                seatTag.textContent = `${seat.name} (${number_format(price, 2)}$)`;
                selectedSeatsList.appendChild(seatTag);
            });

            selectedSeatsCount.textContent = selectedSeats.size;
            totalPriceDisplay.textContent = number_format(currentTotal, 2);

            // Update the hidden input field for form submission
            selectedSeatsInput.value = JSON.stringify(currentSelectedIds);

            // Enable/disable the booking button
            confirmBookingBtn.disabled = selectedSeats.size === 0;
        }

        // Helper function for number formatting
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\\B(?=(?:\\d{3})+(?!\\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    });
</script>
@endsection
