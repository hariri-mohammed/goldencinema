<title>ADD-category</title>

<link rel="stylesheet" href="{{ asset('css/add.css') }}">


<x-manager-layout>

    <div class="content">
        <div class="container">

            <h2 class="text-center">Add New Categories</h2>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="sub-container">
                    <div class="form-group col-12">
                        <input class="Categories-name form-control" type="text" name="category_name"
                            placeholder="Category Name" value="{{ old('category_name') }}" required>
                        <i class="fa-solid fa-icons"></i>
                    </div>
                </div>
                <div class="buttons">
                    <input class="btn btn-success me-auto ms-auto me-sm-3 ms-sm3" id="btn" type="submit"
                        value="Add Now">
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
            </form>
            <div class="link text-center">
                <a href="{{ route('categories.index') }}" class="text-black-50">Return To The Home Page</a>
            </div>
        </div>
    </div>
</x-manager-layout>
