<div class="screen-container">
    <div class="screen">SCREEN</div>
    
    <div class="seats-container">
        @foreach ($seatsByRow as $row => $rowSeats)
        <div class="seat-row">
            <div class="row-indicator">{{ $row }}</div>
            
            @foreach ($rowSeats as $seat)
                <div class="seat-wrapper">
                    @if($seat->is_aisle_left)
                        <div class="aisle-indicator left">
                            <i class="fas fa-walking"></i>
                        </div>
                    @endif

                    <div class="seat {{ $seat->type }} {{ $seat->status }} {{ $seat->is_booked ? 'booked' : '' }}"
                         data-seat-id="{{ $seat->id }}"
                         data-seat-number="{{ $seat->row }}{{ $seat->number }}"
                         onclick="selectSeat(this)"
                         @if($seat->is_booked) disabled @endif>
                        <span class="seat-number">{{ $seat->number }}</span>
                        <span class="seat-price">{{ $seat->price }}</span>
                    </div>

                    @if($seat->is_aisle_right)
                        <div class="aisle-indicator right">
                            <i class="fas fa-walking"></i>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="seat-legend">
        <div class="legend-item">
            <div class="seat available"></div>
            <span>Available</span>
        </div>
        <div class="legend-item">
            <div class="seat selected"></div>
            <span>Selected</span>
        </div>
        <div class="legend-item">
            <div class="seat booked"></div>
            <span>Booked</span>
        </div>
        <div class="legend-item">
            <div class="seat vip"></div>
            <span>VIP</span>
        </div>
    </div>
</div>

<style>
.screen-container {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.screen {
    background: #e9ecef;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 30px;
    color: #495057;
    font-weight: bold;
}

.seats-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
}

.seat-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.seat-wrapper {
    display: flex;
    align-items: center;
    gap: 5px;
}

.seat {
    width: 45px;
    height: 45px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #4a90e2;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.seat.booked {
    background: #dc3545;
    cursor: not-allowed;
}

.seat.selected {
    background: #28a745;
    transform: scale(1.1);
}

.seat.vip {
    background: #ffc107;
    color: #000;
}

.seat-number {
    font-size: 12px;
    font-weight: bold;
}

.seat-price {
    font-size: 10px;
}

.aisle-indicator {
    width: 20px;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
}

.seat-legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
    padding: 15px;
    background: white;
    border-radius: 8px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>

<script>
let selectedSeats = [];

function selectSeat(seatElement) {
    if (seatElement.classList.contains('booked')) {
        return;
    }

    const seatId = seatElement.dataset.seatId;
    const seatNumber = seatElement.dataset.seatNumber;

    if (seatElement.classList.contains('selected')) {
        // Unselect seat
        seatElement.classList.remove('selected');
        selectedSeats = selectedSeats.filter(id => id !== seatId);
    } else {
        // Select seat
        seatElement.classList.add('selected');
        selectedSeats.push(seatId);
    }

    // Update selected seats display and total price
    updateSelectedSeatsInfo();
}

function updateSelectedSeatsInfo() {
    const selectedSeatsContainer = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');
    let totalPrice = 0;

    // Update selected seats display
    const seatElements = selectedSeats.map(seatId => {
        const seatElement = document.querySelector(`[data-seat-id="${seatId}"]`);
        const seatNumber = seatElement.dataset.seatNumber;
        const seatPrice = parseFloat(seatElement.querySelector('.seat-price').textContent);
        totalPrice += seatPrice;
        return `<span class="selected-seat">${seatNumber}</span>`;
    });

    selectedSeatsContainer.innerHTML = seatElements.join('');
    totalPriceElement.textContent = totalPrice.toFixed(2);
}

// Add form submission handler
document.getElementById('booking-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (selectedSeats.length === 0) {
        alert('Please select at least one seat');
        return;
    }

    // Add selected seats to form
    const seatsInput = document.createElement('input');
    seatsInput.type = 'hidden';
    seatsInput.name = 'selected_seats';
    seatsInput.value = JSON.stringify(selectedSeats);
    this.appendChild(seatsInput);

    // Submit form
    this.submit();
});
</script> 