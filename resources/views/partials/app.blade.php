<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cinema')</title>
    <link rel="stylesheet" href="{{ asset('css/appp.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white">
    @include('partials.navbar') <!-- تضمين النافبار -->
    <main>
        @yield('content')
    </main>
</body>

</html>
