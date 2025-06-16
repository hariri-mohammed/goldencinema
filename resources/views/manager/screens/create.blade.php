<title>Add Screen</title>

<x-manager-layout>
    <div class="content">
        <div class="container py-5">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <div class="header-section p-4 border-bottom">
                        <h2 class="text-navy m-0">Add New Screen - {{ $theater->location }}</h2>
                    </div>

                    <div class="form-section p-4">
                        <form action="{{ route('manager.theaters.screens.store', $theater->id) }}" method="POST" id="screenForm">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Screen Name Field -->
                                    <div class="form-group mb-4">
                                        <label class="form-label d-flex align-items-center mb-3">
                                            <i class="fas fa-tv fa-lg text-navy me-2"></i>
                                            <span class="text-navy h5 mb-0">Screen Name</span>
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg shadow-sm @error('screen_name') is-invalid @enderror"
                                            name="screen_name" placeholder="Enter screen name"
                                            value="{{ old('screen_name') }}" required>
                                        @error('screen_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Screen Number Field -->
                                    <div class="form-group mb-4">
                                        <label class="form-label d-flex align-items-center mb-3">
                                            <i class="fas fa-hashtag fa-lg text-navy me-2"></i>
                                            <span class="text-navy h5 mb-0">Screen Number</span>
                                        </label>
                                        <input type="number"
                                            class="form-control form-control-lg shadow-sm @error('screen_number') is-invalid @enderror"
                                            name="screen_number" placeholder="Enter screen number"
                                            value="{{ old('screen_number') }}" required min="1">
                                        @error('screen_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status Field -->
                                    <div class="form-group mb-4">
                                        <label class="form-label d-flex align-items-center mb-3">
                                            <i class="fas fa-toggle-on fa-lg text-navy me-2"></i>
                                            <span class="text-navy h5 mb-0">Status</span>
                                        </label>
                                        <select class="form-select form-select-lg shadow-sm @error('status') is-invalid @enderror"
                                            name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                            Add Screen
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
                <a href="{{ route('manager.theaters.screens.index', $theater->id) }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Screens List
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
    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 12px 20px;
        height: auto;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
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
    </style>
</x-manager-layout>
