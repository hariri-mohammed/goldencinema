<title>Add Seats - {{ $screen->screen_name }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-manager-layout>
    <div class="content">
        <div class="container py-5">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <!-- Header Section -->
                    <div class="header-section p-4 border-bottom">
                        <h2 class="text-navy m-0">Add Seats - Screen {{ $screen->screen_name }}</h2>
                    </div>

                    <!-- Form Section -->
                    <div class="form-section p-4">
                        <form action="{{ route('manager.theaters.screens.seats.store', [$screen->theater_id, $screen->id]) }}" method="POST" id="seatsForm">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Number of Rows -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-arrows-alt-v fa-lg text-navy me-2"></i>
                                            Number of Rows
                                        </label>
                                        <input type="number" name="rows" class="form-control" required min="1" 
                                               value="{{ old('rows') }}" id="rowsInput">
                                    </div>

                                    <!-- Seats per Row -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-arrows-alt-h fa-lg text-navy me-2"></i>
                                            Seats per Row
                                        </label>
                                        <input type="number" name="seats_per_row" class="form-control" required min="1" 
                                               value="{{ old('seats_per_row') }}" id="seatsPerRowInput">
                                    </div>

                                    <!-- Starting Row Letter -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-font fa-lg text-navy me-2"></i>
                                            Starting Row Letter
                                        </label>
                                        <input type="text" name="row_start" class="form-control" required maxlength="1" 
                                               pattern="[A-Za-z]" value="{{ old('row_start', 'A') }}">
                                    </div>

                                    <!-- Number of Aisles -->
                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-walking fa-lg text-navy me-2"></i>
                                            Number of Aisles
                                        </label>
                                        <input type="number" name="aisle_count" class="form-control" min="0" 
                                               value="{{ old('aisle_count', 0) }}" id="aisleCountInput">
                                    </div>

                                    <!-- Aisle Configurations Container -->
                                    <div id="aisleConfigContainer" class="mb-4">
                                        <!-- Will be populated by JavaScript -->
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
                                            Generate Seats
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
            cursor: default;
            transition: all 0.3s ease;
        }

        .preview-seat:hover {
            transform: scale(1.1);
            background: #357abd;
        }

        .preview-aisle {
            width: 30px;
            height: 30px;
            background: #f8f9fa;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
        }

        .seating-preview {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .aisle-config {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }

        .aisle-config-header {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .aisle-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .legend {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 15px;
            padding: 10px;
            background: white;
            border-radius: 4px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const aisleCountInput = document.getElementById('aisleCountInput');
        const aisleConfigContainer = document.getElementById('aisleConfigContainer');
        const seatsPerRowInput = document.getElementById('seatsPerRowInput');
        const seatingPreview = document.getElementById('seatingPreview');
        const rowsInput = document.getElementById('rowsInput');

        function validateAisleInputs() {
            const seatsPerRow = parseInt(seatsPerRowInput.value) || 0;
            const startInputs = document.getElementsByName('aisle_start[]');
            const widthInputs = document.getElementsByName('aisle_width[]');

            for (let i = 0; i < startInputs.length; i++) {
                const start = parseInt(startInputs[i].value);
                const width = parseInt(widthInputs[i].value);
                
                if (start + width > seatsPerRow) {
                    startInputs[i].value = 1;
                    widthInputs[i].value = 1;
                }
            }
        }

        function updateAisleConfigs() {
            const aisleCount = parseInt(aisleCountInput.value) || 0;
            aisleConfigContainer.innerHTML = '';

            for (let i = 1; i <= aisleCount; i++) {
                const aisleConfig = document.createElement('div');
                aisleConfig.className = 'aisle-config';
                aisleConfig.innerHTML = `
                    <div class="aisle-config-header">Aisle ${i} Configuration</div>
                    <div class="aisle-inputs">
                        <div class="form-group">
                            <label class="form-label">Start Position</label>
                            <input type="number" name="aisle_start[]" class="form-control aisle-input" 
                                   min="1" required value="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Width (seats)</label>
                            <input type="number" name="aisle_width[]" class="form-control aisle-input" 
                                   min="1" value="1" required>
                        </div>
                    </div>
                `;
                aisleConfigContainer.appendChild(aisleConfig);

                // Add event listeners to the new inputs
                const inputs = aisleConfig.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        validateAisleInputs();
                        updatePreview();
                    });
                });
            }
            updatePreview();
        }

        function updatePreview() {
            const seatsPerRow = parseInt(seatsPerRowInput.value) || 0;
            const aisles = getAisleConfigurations();
            seatingPreview.innerHTML = '';

            if (seatsPerRow > 0) {
                // Sort aisles by start position
                aisles.sort((a, b) => a.start - b.start);

                // Create preview for each row
                const rowCount = parseInt(rowsInput.value) || 1;
                for (let row = 0; row < rowCount; row++) {
                    const previewRow = document.createElement('div');
                    previewRow.className = 'preview-row';
                    
                    // Add row label
                    const rowLabel = document.createElement('div');
                    rowLabel.className = 'row-label';
                    rowLabel.textContent = String.fromCharCode(65 + row);
                    previewRow.appendChild(rowLabel);

                    let currentPosition = 1;
                    while (currentPosition <= seatsPerRow) {
                        const aisle = aisles.find(a => a.start === currentPosition);
                        if (aisle) {
                            for (let w = 0; w < aisle.width; w++) {
                                const aisleElement = document.createElement('div');
                                aisleElement.className = 'preview-aisle';
                                aisleElement.textContent = 'A';
                                previewRow.appendChild(aisleElement);
                                currentPosition++;
                            }
                        } else {
                            const seat = document.createElement('div');
                            seat.className = 'preview-seat';
                            seat.textContent = currentPosition;
                            previewRow.appendChild(seat);
                            currentPosition++;
                        }
                    }
                    seatingPreview.appendChild(previewRow);
                }

                // Add legend
                const legend = document.createElement('div');
                legend.className = 'legend';
                legend.innerHTML = `
                    <div class="legend-item">
                        <div class="preview-seat"></div>
                        <span>Seat</span>
                    </div>
                    <div class="legend-item">
                        <div class="preview-aisle">A</div>
                        <span>Aisle</span>
                    </div>
                `;
                seatingPreview.appendChild(legend);
            }
        }

        function getAisleConfigurations() {
            const aisles = [];
            const startInputs = document.getElementsByName('aisle_start[]');
            const widthInputs = document.getElementsByName('aisle_width[]');

            for (let i = 0; i < startInputs.length; i++) {
                const start = parseInt(startInputs[i].value);
                const width = parseInt(widthInputs[i].value);
                if (!isNaN(start) && !isNaN(width)) {
                    aisles.push({ start, width });
                }
            }

            return aisles;
        }

        // Event Listeners
        aisleCountInput.addEventListener('change', updateAisleConfigs);
        seatsPerRowInput.addEventListener('change', () => {
            validateAisleInputs();
            updatePreview();
        });
        rowsInput.addEventListener('change', updatePreview);

        // Initialize
        updateAisleConfigs();

        // Form Validation
        document.getElementById('seatsForm').addEventListener('submit', function(e) {
            e.preventDefault(); // منع الإرسال المباشر للنموذج
            
            const formData = new FormData(this);
            const aisles = getAisleConfigurations();
            
            console.log('Form data before submission:', {
                rows: formData.get('rows'),
                seats_per_row: formData.get('seats_per_row'),
                row_start: formData.get('row_start'),
                aisle_count: formData.get('aisle_count'),
                aisles: aisles
            });

            // إضافة بيانات الممرات
            aisles.forEach((aisle, index) => {
                formData.append(`aisle_start[${index}]`, aisle.start);
                formData.append(`aisle_width[${index}]`, aisle.width);
            });

            // إرسال النموذج
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'حدث خطأ أثناء إنشاء المقاعد');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إنشاء المقاعد');
            });
        });
    });
    </script>
</x-manager-layout>
