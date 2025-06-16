<title>Add Trailer</title>
<link rel="stylesheet" href="{{ asset('css/add.css') }}">

<x-manager-layout>
    <div class="content">
        <div class="container">
            <h2 class="text-center mb-4">Add New Trailer</h2>
            <h4 class="text-center text-muted mb-4">Movie: {{ $movie->name }}</h4>

            <form action="{{ route('manager.trailers.store') }}" method="POST">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                <div class="sub-container">
                    <div class="form-group">
                        <div class="url-input-container" style="max-width: 600px; margin: 0 auto;">
                            <label for="url" class="form-label mb-2">Trailer URL:</label>
                            <div class="input-group">
                                <input class="form-control form-control-lg" type="url" name="url" id="url"
                                    placeholder="Enter trailer URL here" required
                                    style="height: 50px; font-size: 16px;">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg" style="min-width: 200px;">
                        <i class="fas fa-plus me-2"></i> Add Trailer
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

            <div class="link text-center mt-4">
                <a href="{{ route('manager.trailers.index') }}" class="text-black-50">
                    <i class="fas fa-arrow-left me-2"></i>Return To The Trailer List
                </a>
            </div>
        </div>
    </div>

    <style>
        .url-input-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control-lg:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            border-color: #28a745;
        }

        .input-group-text {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .link a {
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link a:hover {
            color: #28a745 !important;
        }
    </style>
</x-manager-layout>
