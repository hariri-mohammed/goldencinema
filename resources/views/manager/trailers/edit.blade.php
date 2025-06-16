<title>Edit Trailer</title>
<link rel="stylesheet" href="{{ asset('css/add.css') }}">

<x-manager-layout>
    <div class="content" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #2c3e50; font-weight: 600;">Edit Trailer</h2>
            <h4 class="text-center text-muted mb-4" style="color: #7f8c8d;">Movie: {{ $trailer->movie->name }}</h4>

            <form id="edit-form" action="{{ route('manager.trailers.update', $trailer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="sub-container">
                    <div class="form-group">
                        <div class="url-input-container" style="max-width: 700px; margin: 0 auto;">
                            <label for="url" class="form-label mb-2"
                                style="font-weight: 500; color: #2c3e50;">Trailer URL:</label>
                            <div class="input-group">
                                <input class="form-control form-control-lg" type="url" name="url" id="url"
                                    value="{{ old('url', $trailer->url) }}"
                                    placeholder="Enter trailer URL here (e.g., https://youtube.com/...)" required
                                    style="height: 55px; font-size: 16px; border-radius: 8px 0 0 8px;">
                                <span class="input-group-text" style="border-radius: 0 8px 8px 0; width: 50px;">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons text-center mt-5">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                        data-bs-target="#confirmModal"
                        style="min-width: 250px; height: 50px; font-weight: 500; border-radius: 25px;">
                        <i class="fas fa-save me-2"></i> Update Trailer
                    </button>
                </div>

                @if ($errors->any())
                    <div class="mt-4">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger custom-alert">
                                {{ $loop->iteration }}- {{ $error }}<br>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success custom-alert mt-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </form>

            <div class="link text-center mt-5">
                <a href="{{ route('manager.trailers.index') }}" class="text-black-50" style="font-weight: 500;">
                    <i class="fas fa-arrow-left me-2"></i>Return To The Trailer List
                </a>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fs-4 fw-bold" id="confirmModalLabel" style="color: #2c3e50;">
                        Confirm Update
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="fs-5 text-center mb-0" style="color: #2c3e50;">
                        Are you sure you want to update this trailer?
                    </p>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal"
                        style="border-radius: 20px; font-weight: 500;">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" form="edit-form" class="btn btn-primary px-4 py-2"
                        style="border-radius: 20px; font-weight: 500;">
                        <i class="fas fa-check me-2"></i>Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .content {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .url-input-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .url-input-container:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .form-control-lg {
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
            transform: scale(1.01);
        }

        .input-group-text {
            background-color: #0d6efd;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .input-group:hover .input-group-text {
            background-color: #0b5ed7;
        }

        .btn-primary {
            border: none;
            padding: 12px 35px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .link a {
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 20px;
        }

        .link a:hover {
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .custom-alert {
            border-radius: 8px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content {
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f9fa;
        }

        .modal-body {
            background-color: white;
        }
    </style>
</x-manager-layout>
