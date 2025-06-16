<title>Edit-category</title>
<link rel="stylesheet" href="{{ asset('css/add.css') }}">
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<x-manager-layout>
    <div class="content">
        <div class="container">
            <h2 class="text-center">Edit Categorie</h2>
            <!--Start form-->
            <form id="edit-form" action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Start category name -->
                <div class="sub-container">
                    <div class="form-group col-12">
                        <input class="Categories-name form-control" type="text" name="category_name"
                            placeholder="Category Name" value="{{ old('category_name', $category->name) }}" required />
                        <i class="fa-solid fa-icons"></i>
                    </div>
                </div>
                <!-- end category name -->

                <div class="buttons">
                    <button id="btn" class="btn btn-success me-auto ms-auto me-sm-3 ms-sm3" type="button"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Edit
                    </button>
                </div>

                <!-- show errors -->
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
            </form>
            <!--End form-->

            <div class="link text-center">
                <a href="{{ route('categories.index') }}" class="text-black-50">Return To The Home Page</a>
            </div>
        </div>
    </div>

    <!-- confirm message -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 fw-bold" id="exampleModalLabel">Edit Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-6 fw-bolder">
                    Are You Sure you Want To Edit ?
                </div>
                <div class="modal-footer">
                    <button id="close-btn" type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">No
                    </button>
                    <button id="yes-btn" type="submit" form="edit-form" class="btn btn-danger fw-medium">Yes</button>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
