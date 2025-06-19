<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Golden Cinema</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/visetor_sit_nav.css') }}">
</head>

<body class="font-sans antialiased pt-[90px]">

    @include('layouts.visetor_sit_nav')

    @yield('content')

    <script src="{{ asset('js/cinema_nav.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileLinks = document.querySelectorAll('#profileLink, #mobileProfileLink');
            profileLinks.forEach(profileLink => {
                profileLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    showProfileModal();
                });
            });
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
