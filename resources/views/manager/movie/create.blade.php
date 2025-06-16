<title>ADD Movie</title>

<link rel="stylesheet" href="{{ asset('css/add.css') }}">


<x-manager-layout>
    <div class="content">
        <div class="container mt-5">
            <h2 class="text-center">Add New Movie</h2>

            <form action="{{ route('movie.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12 col-md-6">
                    <label for="name">Movie Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter movie name" required>
                    <i class="fa-solid fa-film"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="language">Language:</label>
                    <input type="text" class="form-control" id="language" name="language"
                        placeholder="Enter movie language" required>
                    <i class="fa-solid fa-film"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country"
                        placeholder="Enter movie country" required>
                    <i class="fa-solid fa-globe"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="release_date">Release Date:</label>
                    <input type="date" class="form-control" id="release_date" name="release_date" required>
                    <i class="fa-solid fa-calendar-days"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="runtime">Runtime (Minutes):</label>
                    <input type="number" class="form-control" id="runtime" name="runtime" min="0" required>
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="rating">Rating (0.0 - 10.0):</label>
                    <input type="number" step="0.1" class="form-control" id="rating" name="rating"
                        min="0" max="10" required>
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="img">Movie Poster:</label>
                    <input type="file" class="form-control" id="img" name="img" required>
                    <i class="fa-solid fa-image"></i>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="stars">Stars:</label>
                    <input type="text" class="form-control" id="stars" name="stars"
                        placeholder="Enter names, separated by commas" required>
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="form-group col-12 col-md-6"> <label for="categories">Categories:</label>
                    <div id="category-checkboxes">
                        @foreach ($categories as $category)
                            <div> <input type="checkbox" id="checkbox_{{ $category->id }}" name="categories[]"
                                    value="{{ $category->id }}"> <label
                                    for="checkbox_{{ $category->id }}">{{ $category->name }}</label> </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="summary">Summary:</label>
                    <textarea class="form-control" id="summary" name="summary" rows="5" required></textarea>
                </div>

                <div class="buttons">
                    <input class="btn btn-success" type="submit" value="Add Now" />
                </div>
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

                <div class="link text-center">
                    <a href="{{ route('movie.index') }}" class="text-black-50">Return To The Home Page</a>
                </div>

            </form>
        </div>

    </div>
</x-manager-layout>
