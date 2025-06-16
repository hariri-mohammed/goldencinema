<link rel="stylesheet" href="{{ asset('css/category_list.css') }}">
<link rel="stylesheet" href="{{ asset('css/all.css') }}">
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div id="nav" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="nav" class="flex justify-between h-16">
            <div class="flex"> <!-- Logo -->
                <div class="shrink-0 flex items-center"> <a> <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> </a> </div>
                <!-- Navigation Links -->
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link>
                        {{ __(' Moviews') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('categories.index')"
                        :active="request()->routeIs('categories.index')"> {{ __(' Categories') }} </x-nav-link> </div>
            </div> <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6"> <x-dropdown align="right" width="48"> <x-slot
                        name="trigger"> <button id="list-btn"
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::guard('manager')->user()->name }}</div>
                            <div class="ms-1"> <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg> </div>
                        </button> </x-slot> <x-slot name="content"> <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }} </x-dropdown-link> <!-- Authentication -->
                        <form method="POST" action="{{ route('managerlogout') }}"> @csrf <x-dropdown-link
                                :href="route('managerlogout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }} </x-dropdown-link> </form>
                    </x-slot> </x-dropdown> </div> <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden"> <button id="list-btn" @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg> </button> </div>
        </div>
    </div> <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden"> {{-- home page --}}
        <div
            class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')"> {{ __('HOME') }}
            </x-responsive-nav-link> </div>
        <div class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                {{ __('Movie') }} </x-responsive-nav-link> </div>
        <div class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                {{ __('Categories') }} </x-responsive-nav-link> </div> <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::guard('manager')->user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('manager')->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1"> <x-responsive-nav-link :href="route('profile.edit')"> {{ __('Profile') }}
                </x-responsive-nav-link> <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}"> @csrf <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }}
                    </x-responsive-nav-link> </form>
            </div>
        </div>
    </div>
</nav>
{{-- manger --}}

<link rel="stylesheet" href="{{ asset('css/category_list.css') }}">
<link rel="stylesheet" href="{{ asset('css/all.css') }}">
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div id="nav" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="nav" class="flex justify-between h-16">
            <div class="flex"> <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <div class="logo"> <img src="{{ asset('img/Logo.PNG') }}" alt=""> </div>
                </div> <!-- Navigation Links -->
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('managerdashboard')"
                        :active="request()->routeIs('managerdashboard') ? 'active' : ''"> {{ __(' Home') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link>
                        {{ __(' Moviews') }} </x-nav-link> </div>
                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"> <x-nav-link :href="route('categories.index')"
                        :active="request()->routeIs('categories.index')"> {{ __(' Categories') }} </x-nav-link> </div>
            </div> <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6"> <button id="list-btn"
                    class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md transition ease-in-out duration-150"
                    onclick="window.location.href='/profile'"> {{ Auth::guard('manager')->user()->name }} </button>
                <form style="margin-top: auto;"="POST" action="{{ route('managerlogout') }}" class="ml-4"> @csrf
                    <button id="list-btn"
                        class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                        {{ __('Log Out') }} </button>
                </form>
            </div> <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden"> <button id="list-btn" @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg> </button> </div>
        </div>
    </div> <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                {{ __('HOME') }} </x-responsive-nav-link> </div>
        <div class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                {{ __('Movie') }} </x-responsive-nav-link> </div>
        <div class="pt-2 pb-3 space-y-1"> <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                {{ __('Categories') }} </x-responsive-nav-link> </div> <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::guard('manager')->user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('manager')->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1"> <x-responsive-nav-link :href="route('profile.edit')"> {{ __('Profile') }}
                </x-responsive-nav-link> <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}"> @csrf <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }}
                    </x-responsive-nav-link> </form>
            </div>
        </div>
    </div>
</nav>
<!-- login manager -->
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('managerlogin') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <p>manager</p>
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<!-- ANTHER MANAGER LOGIN  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="{{ asset('css/Manger_login.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <title>Login</title>
</head>

<body style="font-family: 'Times New Roman', Times, serif">

    <div class="main-box flex-column flex-lg-row">
        <div class="img-box d-none d-lg-block">
            <img src="{{ asset('img/login_cofer.avif') }}" alt="">
        </div>
        <div class="form-box w-100 w-md-50">

            <form method="POST" action="{{ route('managerlogin') }}">
                @csrf
                <div class="logo text-center mt-4">
                    <img src="{{ asset('img/Logo.PNG') }}" alt="">
                </div>
                <h1 class="text-white text-center">Welcome Back</h1>
                <h5 class="text-white-50 text-center">Enter your Details</h5>
                <div class="input-box">
                    <div class="form-group">
                        <input class="email form-control" type="email" name="email" placeholder="Enter Your Email"
                            required autofocus :value="old('email')" />
                        <i id="svg" class="fa fa-envelope fa-fw"></i>
                        {{-- @if ($errors->has('email'))
                            <div class="alter alert-danger">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        @endif --}}

                    </div>
                </div>
                <div class="input-box">
                    <div class="form-group">
                        <input class="password form-control" type="password" name="password"
                            placeholder="Enter Your Password" minlength="8" maxlength="25"
                            pattern="[A-Za-z0-9!@#%^&_]+" title="( A-Z, a-z , 0-9 , ! , @ , # , % , ^ , & , _ )"
                            required />
                        <i id="svg" class="fa fa-key fa-fw"></i>
                        {{-- @if ($errors->has('password'))
                            <div class="alter alert-danger">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        @endif --}}
                    </div>
                </div>

                <div class="btn-box text-center">
                    <input id="btn" type="submit" value="Log In" />
                </div>
                @if ($errors->has('email'))
                <div class="alter alert-danger">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                @endif

                @if ($errors->has('password'))
                <div class="alter alert-danger">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                @endif
            </form>
        </div>
    </div>

</body>

</html>

<!-- creat= movie -->
<link rel="stylesheet" href="{{ asset('css/add.css') }}">


<x-manager-layout>
    <div class="content">
        <div class="container mt-5">
            <h2 class="text-center">Add New Movie</h2>

            @if ($errors->any())
            <div class="alert alert-danger custom-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success custom-alert">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('manager.movies.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="summary">Summary:</label>
                    <textarea class="form-control" id="summary" name="summary" rows="5" required></textarea>
                </div>

                <div class="buttons">
                    <input class="btn btn-success" type="submit" value="Add Now" />
                </div>
            </form>
        </div>
    </div>
</x-manager-layout>

<!-- تعديل فلم -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my_navbar.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top"></nav>

    <div class="container mt-5">
        <h2 class="text-center">Edit Movie</h2>

        @if ($errors->any())
        <div class="alert alert-danger custom-alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success custom-alert">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('manager.movies.update', $movie->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group col-12 col-md-6">
                <label for="name">Movie Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $movie->name }}" required>
                <i class="fa-solid fa-film"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="language">Language:</label>
                <input type="text" class="form-control" id="language" name="language" value="{{ $movie->language }}" required>
                <i class="fa-solid fa-film"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ $movie->country }}" required>
                <i class="fa-solid fa-globe"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="release_date">Release Date:</label>
                <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $movie->release_date }}" required>
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="runtime">Runtime (Minutes):</label>
                <input type="number" class="form-control" id="runtime" name="runtime" value="{{ $movie->runtime }}" min="0" required>
                <i class="fa-solid fa-hourglass-half"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="rating">Rating (0.0 - 10.0):</label>
                <input type="number" step="0.1" class="form-control" id="rating" name="rating" value="{{ $movie->rating }}" min="0" max="10" required>
                <i class="fa-solid fa-star"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="img">Movie Poster:</label>
                <input type="file" class="form-control" id="img" name="img">
                <i class="fa-solid fa-image"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="stars">Stars:</label>
                <input type="text" class="form-control" id="stars" name="stars" value="{{ $movie->stars }}" placeholder="Enter names, separated by commas" required>
                <i class="fa-solid fa-star"></i>
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="summary">Summary:</label>
                <textarea class="form-control" id="summary" name="summary" rows="5" required>{{ $movie->summary }}</textarea>
            </div>

            <div class="buttons">
                <input class="btn btn-success" type="submit" value="Update Now" />
            </div>
        </form>
    </div>

    <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <
        </body>

</html>
<!-- صفحة العرض -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my_navbar.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top"></nav>

    <div class="container mt-5">
        <h2 class="text-center">Movie Details</h2>
        <div class="card">
            <img src="data:image/jpeg;base64,{{ base64_encode($movie->img) }}" class="card-img-top" alt="{{ $movie->name }}">
            <div class="card-body">
                <h3 class="card-title">{{ $movie->name }}</h3>
                <p class="card-text">Language: {{ $movie->language }}</p>
                <p class="card-text">Country: {{ $movie->country }}</p>
                <p class="card-text">Release Date: {{ $movie->release_date }}</p>
                <p class="card-text">Runtime: {{ $movie->runtime }} minutes</p>
                <p class="card-text">Rating: {{ $movie->rating }}</p>
                <p class="card-text">Stars: {{ $movie->stars }}</p>
                <p class="card-text">Summary: {{ $movie->summary }}</p>
            </div>
        </div>
        <a href="{{ route('manager.movies.index') }}" class="btn btn-primary mt-3">Back to List</a>
    </div>

    <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>

<!-- SHOWS  INDEX-->
<link rel="stylesheet" href="{{ asset('css/category_list.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-manager-layout>
    <x-slot name="header">
        <div id="list" class="flex justify-between h-16">
            <x-nav-link :href="route('movie_show.create')" :active="request()->routeIs('movie_show.create')">
                {{ __('Add Movie Show') }}
            </x-nav-link>
        </div>
    </x-slot>

    <div class="content-list">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if ($movieShows->count() > 0)
        <div class="container">
            <div class="row">
                @foreach ($movieShows as $movieShow)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="list-items">
                        <h2>{{ $movieShow->movie->name }}</h2>
                        <p>Start: {{ $movieShow->start }}</p>
                        <p>End: {{ $movieShow->end }}</p>
                        <p>Show Date: {{ $movieShow->show_date }}</p>
                        <p>Location: {{ $movieShow->location }}</p>
                        <div class="icon">
                            <a id="edit" href="{{ route('movie_show.edit', $movieShow->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button id="delete" class="my-btn me-auto ms-auto me-sm-3 ms-sm3" type="button"
                                data-bs-toggle="modal" data-bs-target="#m{{ $movieShow->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="m{{ $movieShow->id }}" tabindex="-1" aria-labelledby="Label"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3 fw-bold">Delete <strong
                                        style="color:#e6ee0d;">{{ $movieShow->movie->name }}</strong> movie
                                    show</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body fs-6 fw-bolder">
                                Are You Sure you Want To Delete ?
                            </div>
                            <div class="modal-footer">
                                <button id="close-btn" type="button" class="btn btn-secondary fw-medium"
                                    data-bs-dismiss="modal">No</button>
                                <form action="{{ route('movie_show.destroy', $movieShow->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button id="yes-btn" type="submit"
                                        class="btn btn-danger fw-medium">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="no-data">
            <p>No Movie Shows Available</p>
        </div>
        @endif
    </div>
</x-manager-layout>
<!-- my manager nav  -->

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div id="nav" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="nav" class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <div class="logo">
                        <img src="{{ asset('img/Logo.PNG') }}" alt="">
                    </div>
                </div>

                <!-- Navigation Links -->

                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard') ? 'active' : ''">
                        {{ __(' Home') }}
                    </x-nav-link>
                </div>


                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movie.index')" :active="request()->routeIs('movie.index') ? 'active' : ''">
                        {{ __(' Moviews') }}
                    </x-nav-link>
                </div>

                <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movie_show.index')" :active="request()->routeIs('movie_show.index')">
                        {{ __(' Shows') }}
                    </x-nav-link>

                    <div id="list" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                            {{ __(' Categories') }}
                        </x-nav-link>
                    </div>
                </div>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <button id="list-btn"
                        class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md transition ease-in-out duration-150"
                        onclick="window.location.href='/profile'"> {{ Auth::guard('manager')->user()->name }}
                    </button>
                    <form method="POST" action="{{ route('managerlogout') }}" class="ml-4">
                        @csrf
                        <button id="list-btn"
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button id="list-btn" @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Responsive Navigation Menu -->
        <div id="hidden" :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div id="list" class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('managerdashboard')" :active="request()->routeIs('managerdashboard')">
                    {{ __('HOME') }}
                </x-responsive-nav-link>
            </div>
            <div id="list" class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('movie.index')" :active="request()->routeIs('movie.index')">
                    {{ __('Movie') }}
                </x-responsive-nav-link>
            </div>
            <div id="list" class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                    {{ __('Categories') }}
                </x-responsive-nav-link>
            </div>
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::guard('manager')->user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::guard('manager')->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('managerlogout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('managerlogout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
</nav>