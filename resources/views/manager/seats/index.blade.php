@extends('layouts.manager')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-lg shadow-sm">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chair text-primary me-2"></i>
            Seats - Screen {{ $screen->screen_name }}
        </h1>
        <a href="{{ route('manager.theaters.screens.seats.create', [$screen->theater_id, $screen->id]) }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Seats
        </a>
        <a href="{{ route('manager.theaters.screens.seats.edit', [$screen->theater_id, $screen->id]) }}" class="btn btn-info ms-2">
            <i class="fas fa-edit me-2"></i> Edit Seating Layout
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Seats Layout -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-chair me-2"></i>
                Screen Layout
            </h6>
        </div>
        <div class="card-body bg-white">
            @if ($seats->count() > 0)
                <div class="screen-layout mb-4">
                    <div class="screen-indicator">
                        <div class="screen-text">SCREEN</div>
                    </div>

                    <div class="seats-container">
                        @php
                            $currentRow = '';
                            $seatsByRow = $seats->groupBy('row');
                        @endphp

                        @foreach ($seatsByRow as $row => $rowSeats)
                            <div class="seat-row">
                                <div class="row-indicator">{{ $row }}</div>
                                
                                @foreach ($rowSeats->sortBy('number') as $seat)
                                    @if ($seat->type === 'aisle')
                                        <div class="aisle-space">
                                            <i class="fas fa-walking"></i>
                                        </div>
                                    @else
                                        <div class="seat {{ $seat->type }} {{ $seat->status }}" 
                                             data-seat-id="{{ $seat->id }}"
                                             onclick="openSeatMenu(this)"
                                             data-type="{{ $seat->type }}"
                                             data-status="{{ $seat->status }}">
                                            <span class="seat-number">{{ $seat->number }}</span>
                                            <div class="seat-menu">
                                                <div class="menu-header">Seat {{ $seat->row }}{{ $seat->number }}</div>
                                                <div class="menu-content">
                                                    <!-- Type Selection -->
                                                    <div class="menu-section">
                                                        <label>Type:</label>
                                                        <select class="seat-type" onchange="updateSeat({{ $seat->id }}, this, 'type')">
                                                            <option value="standard" {{ $seat->type == 'standard' ? 'selected' : '' }}>Standard</option>
                                                            <option value="vip" {{ $seat->type == 'vip' ? 'selected' : '' }}>VIP</option>
                                                            <option value="wheelchair" {{ $seat->type == 'wheelchair' ? 'selected' : '' }}>Wheelchair</option>
                                                        </select>
                                                    </div>
                                                    <!-- Status Selection -->
                                                    <div class="menu-section">
                                                        <label>Status:</label>
                                                        <select class="seat-status" onchange="updateSeat({{ $seat->id }}, this, 'status')">
                                                            <option value="active" {{ $seat->status == 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="maintenance" {{ $seat->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                            <option value="inactive" {{ $seat->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Seat Legend -->
                <div class="seat-legend">
                    <div class="legend-title">Seat Types:</div>
                    <div class="legend-item">
                        <div class="seat-sample standard"></div>
                        <span>Standard</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat-sample vip"></div>
                        <span>VIP</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat-sample wheelchair"></div>
                        <span>Wheelchair</span>
                    </div>
                    
                    <div class="legend-title ml-4">Seat Status:</div>
                    <div class="legend-item">
                        <div class="seat-sample active"></div>
                        <span>Active</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat-sample maintenance"></div>
                        <span>Maintenance</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat-sample inactive"></div>
                        <span>Inactive</span>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="text-gray-500">
                        <i class="fas fa-chair fa-3x mb-3"></i>
                        <p class="mb-0">No seats available for this screen</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Link -->
    <div class="text-center mt-4">
        <a href="{{ route('manager.theaters.screens.index', [$screen->theater_id]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Screens List
        </a>
    </div>
</div>

@push('styles')
<style>
    /* Screen Layout */
    .screen-layout {
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 15px;
    }

    .screen-indicator {
        background: #e9ecef;
        height: 40px;
        margin-bottom: 2rem;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .screen-text {
        color: #6c757d;
        font-weight: 600;
        letter-spacing: 2px;
    }

    /* Seats Container */
    .seats-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 20px;
    }

    .seat-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .row-indicator {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        background: #f8f9fa;
        border-radius: 5px;
    }

    .seat {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #4a90e2;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .aisle-space {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px dashed #ccc;
        border-radius: 8px;
        color: #666;
    }

    .aisle-space i {
        font-size: 20px;
    }

    .seat-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        z-index: 1000;
        min-width: 200px;
        padding: 1rem;
        border: 1px solid #e0e0e0;
    }

    .menu-header {
        font-weight: bold;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        color: #000000;
    }

    .menu-section {
        margin: 0.8rem 0;
    }

    .menu-section label {
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        color: #000000;
        font-weight: 500;
    }

    .menu-section select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        color: #000000;
        background-color: #ffffff;
        font-size: 14px;
        cursor: pointer;
    }

    .menu-section select option {
        color: #000000;
        background-color: #ffffff;
        padding: 8px;
    }

    /* Seat Types */
    .seat.standard { background: #4a90e2; color: white; }
    .seat.vip { background: #f1c40f; color: #2c3e50; }
    .seat.wheelchair { background: #2ecc71; color: white; }

    /* Seat Status */
    .seat.active { opacity: 1; }
    .seat.maintenance { 
        background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(0,0,0,0.1) 5px, rgba(0,0,0,0.1) 10px);
    }
    .seat.inactive { opacity: 0.5; }

    .seat:hover {
        transform: scale(1.1);
        z-index: 10;
    }

    .seat.show-menu .seat-menu {
        display: block;
        animation: menuFadeIn 0.2s ease;
    }

    @keyframes menuFadeIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    /* Legend Styling */
    .seat-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .legend-title {
        font-weight: bold;
        margin-right: 1rem;
        display: flex;
        align-items: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .seat-sample {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    /* Card Styling */
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seats = document.querySelectorAll('.seat');
        const editModal = new bootstrap.Modal(document.getElementById('editSeatModal'));
        const editForm = document.getElementById('editSeatForm');

        seats.forEach(seat => {
            seat.addEventListener('click', function() {
                const seatId = this.dataset.seatId;
                const theaterId = '{{ $screen->theater_id }}';
                const screenId = '{{ $screen->id }}';

                // Set form action URL
                editForm.action = `/manager/theaters/${theaterId}/screens/${screenId}/seats/${seatId}`;

                // Set current values
                const typeSelect = editForm.querySelector('select[name="type"]');
                const statusSelect = editForm.querySelector('select[name="status"]');

                typeSelect.value = this.classList.contains('vip') ? 'vip' :
                    this.classList.contains('wheelchair') ? 'wheelchair' : 'standard';

                statusSelect.value = this.classList.contains('inactive') ? 'inactive' :
                    this.classList.contains('maintenance') ? 'maintenance' : 'active';

                // Show modal
                editModal.show();
            });
        });
    });

    function openSeatMenu(seatElement) {
        // Close any open menus
        document.querySelectorAll('.seat').forEach(seat => {
            seat.classList.remove('show-menu');
        });
        
        // Toggle menu for clicked seat
        seatElement.classList.add('show-menu');
        
        // Close menu when clicking outside
        document.addEventListener('click', function closeMenu(e) {
            if (!seatElement.contains(e.target)) {
                seatElement.classList.remove('show-menu');
                document.removeEventListener('click', closeMenu);
            }
        });
    }

    function updateSeat(seatId, selectElement, updateType) {
        const value = selectElement.value;
        const theaterId = '{{ $screen->theater_id }}';
        const screenId = '{{ $screen->id }}';
        
        // Send AJAX request to update seat
        fetch(`/manager/theaters/${theaterId}/screens/${screenId}/seats/${seatId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                [updateType]: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update seat appearance
                const seatElement = selectElement.closest('.seat');
                if (updateType === 'type') {
                    seatElement.className = `seat ${value} ${seatElement.dataset.status}`;
                } else {
                    seatElement.className = `seat ${seatElement.dataset.type} ${value}`;
                }
                seatElement.dataset[updateType] = value;
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success';
                alert.textContent = 'Seat updated successfully';
                document.querySelector('.content-list').insertBefore(alert, document.querySelector('.card'));
                setTimeout(() => alert.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger';
            alert.textContent = 'Failed to update seat';
            document.querySelector('.content-list').insertBefore(alert, document.querySelector('.card'));
            setTimeout(() => alert.remove(), 3000);
        });
    }
</script>
@endpush
@endsection
