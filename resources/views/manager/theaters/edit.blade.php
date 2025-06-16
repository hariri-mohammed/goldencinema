<title>Edit Theater</title>

<x-manager-layout>
    <div class="content">
        <div class="container py-5">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <!-- Header Section -->
                    <div class="header-section p-4 border-bottom">
                        <h2 class="text-navy m-0">Edit Theater</h2>
                    </div>

                    <!-- Form Section -->
                    <div class="form-section p-4">
                        <form id="edit-form" action="{{ route('manager.theaters.update', $theater->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Theater Location Field -->
                                    <div class="form-group mb-4">
                                        <label class="form-label d-flex align-items-center mb-3">
                                            <i class="fas fa-map-marker-alt fa-lg text-navy me-2"></i>
                                            <span class="text-navy h5 mb-0">Theater Location</span>
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg shadow-sm @error('location') is-invalid @enderror"
                                            name="location" placeholder="Enter theater location"
                                            value="{{ old('location', $theater->location) }}" required>
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- City Field -->
                                    <div class="form-group mb-5">
                                        <label class="form-label d-flex align-items-center mb-3">
                                            <i class="fas fa-city fa-lg text-navy me-2"></i>
                                            <span class="text-navy h5 mb-0">City</span>
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg shadow-sm @error('city') is-invalid @enderror"
                                            name="city" placeholder="Enter city name"
                                            value="{{ old('city', $theater->city) }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group text-center">
                                        <button type="button" class="btn btn-primary btn-lg px-5 py-3 rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal">
                                            Update Theater
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
                <a href="{{ route('manager.theaters.index') }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Theater List
                </a>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title text-navy">Confirm Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-center mb-0 text-navy">Are you sure you want to update this theater?</p>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="edit-form" class="btn btn-primary px-4 rounded-pill">Update</button>
                </div>
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

        .form-control::placeholder {
            color: #adb5bd;
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

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
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

        /* Label Icons */
        .form-label i {
            opacity: 0.8;
        }

        /* Shadow Effects */
        .shadow-sm {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 20px;
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f9fa;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-section {
                padding: 2rem !important;
            }
        }

        /* Animation */
        .card {
            animation: slideUp 0.5s ease;
        }

        .modal.show .modal-dialog {
            animation: slideUpModal 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUpModal {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-manager-layout>
