<title>Edit Seats - {{ $screen->screen_name }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-manager-layout>
    <div class="content">
        <div class="container py-5">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <!-- Header Section -->
                    <div class="header-section p-4 border-bottom">
                        <h2 class="text-navy m-0">Edit Seats - Screen {{ $screen->screen_name }}</h2>
                    </div>

                    <!-- Form Section -->
                    <div class="form-section p-4">
                        <form action="{{ route('manager.theaters.screens.seats.update', [$screen->theater_id, $screen->id]) }}" method="POST" id="seatsForm">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Number of Rows -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-arrows-alt-v fa-lg text-navy me-2"></i>
                                            Number of Rows
                                        </label>
                                        <input type="number" name="rows" class="form-control" required min="1" 
                                               value="{{ old('rows', $seat->rows) }}" id="rowsInput">
                                    </div>

                                    <!-- Seats per Row -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-arrows-alt-h fa-lg text-navy me-2"></i>
                                            Seats per Row
                                        </label>
                                        <input type="number" name="seats_per_row" class="form-control" required min="1" 
                                               value="{{ old('seats_per_row', $seat->seats_per_row) }}" id="seatsPerRowInput">
                                    </div>

                                    <!-- Starting Row Letter -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-font fa-lg text-navy me-2"></i>
                                            Starting Row Letter
                                        </label>
                                        <input type="text" name="row_start" class="form-control" required maxlength="1" 
                                               pattern="[A-Za-z]" value="{{ old('row_start', $seat->row_start) }}">
                                    </div>

                                    <!-- Number of Aisles -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-walking fa-lg text-navy me-2"></i>
                                            Number of Aisles
                                        </label>
                                        <input type="number" name="aisle_count" class="form-control" min="0" 
                                               value="{{ old('aisle_count', $seat->aisle_count) }}" id="aisleCountInput">
                                    </div>

                                    <!-- Aisle Configurations Container -->
                                    <div id="aisleConfigContainer" class="mb-4">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-walking fa-lg text-navy me-2"></i>
                                                    Aisle Configurations
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="aisleConfigs">
                                                    <!-- Aisle configurations will be added here dynamically -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Section -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-eye fa-lg text-navy me-2"></i>
                                            Seating Preview
                                        </label>
                                        <div class="preview-container">
                                            <div id="seatingPreview" class="seating-preview"></div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                            Update Seats
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <div class="text-center mt-4">
                <a href="{{ route('manager.theaters.screens.seats.index', [$screen->theater_id, $screen->id]) }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Seats List
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Custom Colors */
        .text-navy {
            color: #2c3e50;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
        }

        .header-section {
            background-color: #f8f9fa;
        }

        /* Form Controls */
        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 20px;
            height: auto;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.1);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #ff9f43;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff8f1f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 159, 67, 0.3);
        }

        /* Back Link Styling */
        .back-link {
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            padding: 0px 16px;
            border-radius: 20px;
        }

        .back-link:hover {
            color: #ff9f43;
            background-color: rgba(255, 159, 67, 0.1);
        }

        .preview-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #dee2e6;
        }

        .preview-row {
            display: flex;
            gap: 5px;
            align-items: center;
            margin-bottom: 10px;
        }

        .row-label {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #2c3e50;
            margin-right: 10px;
        }

        .preview-seat {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4a90e2;
            color: white;
            border-radius: 4px;
            font-size: 12px;
        }

        .preview-aisle {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e0e0e0;
            color: #666;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rowsInput = document.getElementById('rowsInput');
            const seatsPerRowInput = document.getElementById('seatsPerRowInput');
            const aisleCountInput = document.getElementById('aisleCountInput');
            const aisleConfigContainer = document.getElementById('aisleConfigContainer');
            const aisleConfigs = document.getElementById('aisleConfigs');
            const seatingPreview = document.getElementById('seatingPreview');

            // Function to create aisle configuration inputs
            function createAisleConfigs() {
                const aisleCount = parseInt(aisleCountInput.value) || 0;
                aisleConfigs.innerHTML = '';

                for (let i = 0; i < aisleCount; i++) {
                    const aisleDiv = document.createElement('div');
                    aisleDiv.className = 'mb-3';
                    aisleDiv.innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Aisle ${i + 1}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Start Position</label>
                                            <input type="number" name="aisle_start[]" class="form-control" 
                                                   min="1" max="${seatsPerRowInput.value}" required
                                                   value="${i === 0 ? 1 : Math.floor(seatsPerRowInput.value / (aisleCount + 1)) * (i + 1)}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Width (seats)</label>
                                            <input type="number" name="aisle_width[]" class="form-control" 
                                                   min="1" max="3" required value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    aisleConfigs.appendChild(aisleDiv);
                }
            }

            function updatePreview() {
                const rows = parseInt(rowsInput.value) || 0;
                const seatsPerRow = parseInt(seatsPerRowInput.value) || 0;
                const aisleCount = parseInt(aisleCountInput.value) || 0;
                const rowStart = document.querySelector('input[name="row_start"]').value.toUpperCase();

                // Clear previous preview
                seatingPreview.innerHTML = '';

                // Get aisle configurations
                const aisles = [];
                for (let i = 0; i < aisleCount; i++) {
                    const startInput = document.querySelector(`input[name="aisle_start[]"]`);
                    const widthInput = document.querySelector(`input[name="aisle_width[]"]`);
                    if (startInput && widthInput) {
                        aisles.push({
                            start: parseInt(startInput.value) || 0,
                            width: parseInt(widthInput.value) || 1
                        });
                    }
                }

                // Generate preview rows
                for (let i = 0; i < rows; i++) {
                    const rowLetter = String.fromCharCode(rowStart.charCodeAt(0) + i);
                    const rowDiv = document.createElement('div');
                    rowDiv.className = 'preview-row';

                    // Add row label
                    const rowLabel = document.createElement('div');
                    rowLabel.className = 'row-label';
                    rowLabel.textContent = rowLetter;
                    rowDiv.appendChild(rowLabel);

                    // Add seats and aisles
                    let currentPosition = 0;
                    for (let j = 0; j < seatsPerRow; j++) {
                        currentPosition++;
                        
                        // Check if this position is an aisle
                        const isAisle = aisles.some(aisle => 
                            currentPosition >= aisle.start && 
                            currentPosition < aisle.start + aisle.width
                        );

                        const element = document.createElement('div');
                        if (isAisle) {
                            element.className = 'preview-aisle';
                            element.textContent = 'A';
                        } else {
                            element.className = 'preview-seat';
                            element.textContent = j + 1;
                        }
                        rowDiv.appendChild(element);
                    }

                    seatingPreview.appendChild(rowDiv);
                }
            }

            // Update preview when inputs change
            rowsInput.addEventListener('input', updatePreview);
            seatsPerRowInput.addEventListener('input', () => {
                createAisleConfigs();
                updatePreview();
            });
            aisleCountInput.addEventListener('input', () => {
                createAisleConfigs();
                updatePreview();
            });
            document.querySelector('input[name="row_start"]').addEventListener('input', updatePreview);

            // Add event delegation for aisle configuration inputs
            aisleConfigs.addEventListener('input', function(e) {
                if (e.target.matches('input[name^="aisle_start"]')) {
                    updatePreview();
                }
            });

            // Initial setup
            createAisleConfigs();
            updatePreview();
        });
    </script>
</x-manager-layout>