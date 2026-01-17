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

        <form action="{{ route('client.bookings.store', ['movie_show' => $movieShow->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="seats" id="selected-seats-input">

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
                                @php
                                    $seatTypeClass = strtolower($seat->type);
                                    $seatStatusClass = strtolower($seat->status);
                                    $isBookable = !$seat->isAisle() && $seat->status === 'active' && !in_array($seat->id, $bookedSeatIds);
                                    $seatTooltip = 'Row: ' . $seat->row . ', Number: ' . $seat->number . ' | Type: ' . ucfirst($seat->type) . ' | Status: ' . ucfirst($seat->status);
                                    if ($seat->type === 'vip') $seatTooltip .= ' (VIP)';
                                    if (in_array($seat->id, $bookedSeatIds)) $seatTooltip .= ' (Booked)';
                                @endphp
                                @if($seat->isAisle())
                                    <div class="seat aisle" title="Aisle"></div>
                                @else
                                    <div
                                        class="seat {{ $seatTypeClass }} {{ $seatStatusClass }} {{ in_array($seat->id, $bookedSeatIds) ? 'booked' : '' }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-seat-price="{{ $movieShow->price }}"
                                        data-seat-type="{{ $seat->type }}"
                                        data-seat-status="{{ $seat->status }}"
                                        title="{{ $seatTooltip }}"
                                        @if(!$isBookable) style="pointer-events: none; opacity: 0.5;" @endif
                                    >
                                        {{ $seat->number }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="seat-legend mt-4 d-flex justify-content-center gap-3">
                    <div class="legend-item"><span class="seat standard legend-seat"></span> Standard</div>
                    <div class="legend-item"><span class="seat vip legend-seat"></span> VIP ({{ number_format($movieShow->price * 1.2, 2) }}$)</div>
                    <div class="legend-item"><span class="seat wheelchair legend-seat"></span> Wheelchair</div>
                    <div class="legend-item"><span class="seat aisle legend-seat"></span> Aisle</div>
                    <div class="legend-item"><span class="seat active legend-seat"></span> Active</div>
                    <div class="legend-item"><span class="seat maintenance legend-seat"></span> Maintenance</div>
                    <div class="legend-item"><span class="seat inactive legend-seat"></span> Inactive</div>
                    <div class="legend-item"><span class="seat booked legend-seat"></span> Booked</div>
                </div>

                <div class="selected-seats-display mt-4 text-center">
                    <h4 class="mb-3">Selected Seats: <span id="selected-seats-count">0</span></h4>
                    <div id="selected-seats-list" class="d-flex flex-wrap justify-content-center gap-2">
                        <!-- Selected seats will be appended here -->
                    </div>
                </div>

                <div class="total-price-display text-center mt-4">
                    <h3>Total Price: $<span id="total-price">0.00</span></h3>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" id="confirm-booking-btn" class="btn btn-primary btn-lg w-100" style="max-width: 300px; margin: 0 auto; display: block;" onclick="return confirm('Are you sure you want to confirm your booking?')">Confirm Booking</button>
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
    .seat.standard { background-color: #e9ecef !important; color: #343a40 !important; }
    .seat.vip { background-color: #ffc107 !important; color: #343a40 !important; }
    .seat.wheelchair { background-color: #00bcd4 !important; color: #fff !important; }
    .seat.aisle { background-color: #6c757d !important; opacity: 0.5 !important; color: #fff !important; }
    .seat.active {
        border: 2px solid #28a745;
    }
    .seat.maintenance {
        background-color: #fd7e14 !important;
        color: #fff !important;
        border: 2px dashed #fd7e14 !important;
        position: relative;
    }
    .seat.maintenance:not(.legend-seat)::after {
        content: '\26A0';
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 1em;
    }
    .seat.inactive {
        background-color: #bdbdbd !important;
        color: #fff !important;
        border: 2px solid #6c757d !important;
        opacity: 0.6 !important;
    }
    .seat.booked {
        background-color: #dc3545 !important;
        color: white !important;
        cursor: not-allowed !important;
        border: 2px solid #dc3545 !important;
    }
    .seat.selected {
        background-color: #28a745 !important;
        color: white !important;
        border-color: #28a745 !important;
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
    #selected-seats-list span.standard {
        background-color: #e9ecef;
        color: #343a40;
        border: 1px solid #ccc;
    }
    #selected-seats-list span.vip {
        background-color: #ffc107;
        color: #343a40;
        border: 1px solid #bfa004;
    }
    #selected-seats-list span.wheelchair {
        background-color: #00bcd4;
        color: #fff;
        border: 1px solid #0097a7;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seatsContainer = document.querySelector('.theater-layout');
        const selectedSeatsInput = document.getElementById('selected-seats-input');
        const selectedSeatsCount = document.getElementById('selected-seats-count');
        const selectedSeatsList = document.getElementById('selected-seats-list');
        const totalPriceDisplay = document.getElementById('total-price');
        let selectedSeats = new Map();

        seatsContainer.addEventListener('click', function(event) {
            let seatElement = event.target.closest('.seat');
            if (
                seatElement &&
                !seatElement.classList.contains('booked') &&
                !seatElement.classList.contains('aisle') &&
                !seatElement.classList.contains('maintenance') &&
                !seatElement.classList.contains('inactive')
            ) {
                const seatId = seatElement.dataset.seatId;
                const seatPrice = parseFloat(seatElement.dataset.seatPrice);
                const seatType = seatElement.dataset.seatType;
                const row = seatElement.parentNode.querySelector('.row-label').textContent;
                const number = seatElement.textContent.trim();
                const fullSeatName = `${row}${number}`;

                if (seatElement.classList.contains('selected')) {
                    seatElement.classList.remove('selected');
                    selectedSeats.delete(seatId);
                } else {
                    seatElement.classList.add('selected');
                    selectedSeats.set(seatId, { price: seatPrice, type: seatType, name: fullSeatName });
                }
                updateSelectedSeatsDisplay();
            }
        });

        function updateSelectedSeatsDisplay() {
            let currentTotal = 0;
            let currentSelectedIds = [];
            selectedSeatsList.innerHTML = '';
            selectedSeats.forEach((seat, id) => {
                let price = seat.price;
                let typeClass = seat.type.toLowerCase();
                if (seat.type === 'vip') price *= 1.2;
                currentTotal += price;
                currentSelectedIds.push(id);
                const seatTag = document.createElement('span');
                seatTag.textContent = `${seat.name} (${number_format(price, 2)}$)`;
                seatTag.className = typeClass;
                selectedSeatsList.appendChild(seatTag);
            });
            selectedSeatsCount.textContent = selectedSeats.size;
            totalPriceDisplay.textContent = number_format(currentTotal, 2);
            selectedSeatsInput.value = JSON.stringify(currentSelectedIds);
        }

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
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
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
