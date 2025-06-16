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

    <style>
        /* ... (أنماط CSS الأخرى) ... */

        .profile-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            /* ابدأ بإخفاء النافذة */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .profile-modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            position: relative;
        }

        .close-profile-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2em;
            cursor: pointer;
            border: none;
            background: none;
        }
    </style>
</head>

<body class="font-sans antialiased pt-[90px]">

    @include('layouts.visetor_sit_nav')

    <div class="login-modal-overlay">
        <div class="login-modal-content">
            <button class="close-login-modal absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h2 class="text-xl font-bold mb-4">Login to Your Account</h2>
            <form id="loginForm" method="POST" action="{{ route('client.login') }}">
                @csrf
                <div class="mb-4">
                    <label for="cinema_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="cinema_email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-second-color focus:border-second-color"
                        placeholder="example@example.com">
                </div>

                <div class="mb-6">
                    <label for="cinema_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="cinema_password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-second-color focus:border-second-color"
                        placeholder="Enter your password">
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" required
                            class="form-checkbox h-5 w-5 text-second-color focus:ring-second-color">
                        <span class="ml-2 text-gray-700">By signing up, you agree to our terms & conditions</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-second-color text-white py-2 px-4 rounded-md hover:bg-darker-color focus:outline-none focus:ring-2 focus:ring-second-color">
                    Login
                </button>
            </form>
        </div>
    </div>


    @yield('content')

    <!-- في نهاية body قبل إغلاق التاج -->
    @if (Auth::guard('client')->check())
        @php
            $client = Auth::guard('client')->user();
        @endphp
        <div class="profile-modal-overlay" id="profileModal">
            <div class="profile-modal-content">
                <button class="close-profile-modal" onclick="closeProfileModal()">&times;</button>
                @include('client.client_profile', ['client' => $client])
            </div>
        </div>
    @endif



    <script src="{{ asset('js/cinema_nav.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileLinks = document.querySelectorAll('#profileLink, #mobileProfileLink'); // Select both IDs

            profileLinks.forEach(profileLink => {
                profileLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    openProfileModal();
                });
            });

            const closeButton = document.querySelector('.close-profile-modal');
            if (closeButton) {
                closeButton.addEventListener('click', closeProfileModal);
            }

            const profileModal = document.getElementById('profileModal');
            if (profileModal) {
                profileModal.style.display = 'none'; // Hide initially
            }
        });

        function openProfileModal() {
            const profileModal = document.getElementById('profileModal');
            if (profileModal) {
                profileModal.style.display = 'flex';
            }
        }

        function closeProfileModal() {
            const profileModal = document.getElementById('profileModal');
            if (profileModal) {
                profileModal.style.display = 'none';
            }
        };
    </script>
</body>

</html>
