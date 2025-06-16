<title>Edit-Movie</title>

<link rel="stylesheet" href="{{ asset('css/add.css') }}">

<x-manager-layout>
    <div class="content">
        <div class="container mt-5">

            <h2 class="text-center">Edit Movie</h2>

            <form action="{{ route('movie.update', $movie->id) }}" method="post" id="edit-form"
                enctype="multipart/form-data">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger custom-alert">
                            {{ $loop->iteration }}- {{ $error }}<br>
                        </div>
                    @endforeach
                @endif
                @if (session('success'))
                    <div class="alert alert-success custom-alert" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @csrf
                @method('PUT')
                <div class="form-group col-12 col-md-6">
                    <label for="name">Movie Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $movie->name }}"
                        required>
                    <i class="fa-solid fa-film"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="language">Language:</label>
                    <input type="text" class="form-control" id="language" name="language"
                        value="{{ $movie->language }}" required>
                    <i class="fa-solid fa-film"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="{{ $movie->country }}" required>
                    <i class="fa-solid fa-globe"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="release_date">Release Date:</label>
                    <input type="date" class="form-control" id="release_date" name="release_date"
                        value="{{ $movie->release_date }}" required>
                    <i class="fa-solid fa-calendar-days"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="runtime">Runtime (Minutes):</label>
                    <input type="number" class="form-control" id="runtime" name="runtime"
                        value="{{ $movie->runtime }}" min="0" required>
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="rating">Rating (0.0 - 10.0):</label>
                    <input type="number" step="0.1" class="form-control" id="rating" name="rating"
                        value="{{ $movie->rating }}" min="0" max="10" required>
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="img">Movie Poster:</label>
                    <input type="file" class="form-control" id="img" name="img">
                    <i class="fa-solid fa-image"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="stars">Stars:</label>
                    <input type="text" class="form-control" id="stars" name="stars"
                        value="{{ $movie->stars }}" placeholder="Enter names, separated by commas" required>
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="categories">Categories:</label>
                    <div id="category-checkboxes">
                        @foreach ($categories as $category)
                            <div>
                                <input type="checkbox" id="checkbox_{{ $category->id }}" name="categories[]"
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, $movie->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label for="checkbox_{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="summary">Summary:</label>
                    <textarea class="form-control" id="summary" name="summary" rows="5" required>{{ $movie->summary }}</textarea>
                </div>
                <div class="buttons">
                    <button id="btn" class="btn btn-success me-auto ms-auto me-sm-3 ms-sm3" type="button"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Edit
                    </button>
                </div>

            </form>

            <div class="link text-center mt-3">
                <a href="{{ route('movie.index') }}" class="text-black-50">Return To The Home Page</a>
            </div>
        </div>
    </div>
    <!-- confirm message -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 fw-bold" id="exampleModalLabel">Edit Movie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-6 fw-bolder">
                    Are You Sure you Want To Edit?
                </div>
                <div class="modal-footer">
                    <button id="close-btn" type="button" class="btn btn-secondary fw-medium"
                        data-bs-dismiss="modal">No</button>
                    <button id="yes-btn" type="submit" form="edit-form"
                        class="btn btn-danger fw-medium">Yes</button>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
