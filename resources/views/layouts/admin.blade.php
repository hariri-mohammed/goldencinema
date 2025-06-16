<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>



<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 "style="background-color: white;">
        @include('layouts.admin_nav')



        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <script>
            // إخفاء الرسالة بعد خمس ثواني
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alerts = document.querySelectorAll('.custom-alert');
                    alerts.forEach(function(alert) {
                        alert.style.display = 'none';
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            });
        </script>

        <script>
            // إخفاء الرسالة الخاصة بالحذف بعد خمس ثوانٍ
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alerts = document.querySelectorAll('.alert');
                    alerts.forEach(function(alert) {
                        alert.style.display = 'none';
                    });
                }, 4000); // 4000 milliseconds = 5 seconds
            });
        </script>

    </div>
</body>

</html>
