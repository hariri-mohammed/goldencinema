<nav class="bg-main-color border-b border-gray-100 fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- الجانب الأيسر -->
            <div class="flex items-center gap-4">
                <!-- زر القائمة -->
                <button id="mobileMenuButton" class="p-2 nav-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- بحث -->
                <div class="relative">
                    <button id="searchButton" class="p-2 nav-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <div id="searchBox" class="fixed top-[74px] left-1/2 transform -translate-x-1/2 w-[52rem] z-50"
                        style="display: none;">
                        <form action="{{ route('movies.index') }}" method="GET" class="flex items-center w-full h-full bg-white rounded-lg shadow-lg border border-gray-300">
                            <input type="text"
                                name="search"
                                class="flex-1 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-second-color border-none"
                                placeholder="Search...">
                            <button type="submit" class="px-4 py-3 bg-second-color text-white hover:bg-darker-color border-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- زر المسارح -->
                <div class="relative">
                    <button id="theatersButton" class="p-2 nav-icon flex items-center justify-center space-x-2 text-second-color hover:text-darker-color">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="font-semibold">Theaters</span>
                    </button>

                    <div id="theatersBox" class="fixed top-[74px] left-1/2 transform -translate-x-1/2 w-[52rem] z-50 bg-white rounded-lg shadow-lg border border-gray-300 p-4 max-h-80 overflow-y-auto"
                        style="display: none;">
                        <ul class="divide-y divide-gray-200">
                            @foreach($theaters as $theater)
                                <li class="py-2 px-4 hover:bg-gray-100 rounded-lg">
                                    <h3 class="font-semibold text-lg">{{ $theater->location }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $theater->city }}</p>
                                </li>
                            @endforeach
                            @if($theaters->isEmpty())
                                <li class="py-2 px-4 text-center text-gray-500">No theaters available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- الشعار -->
            <div class="flex-1 flex justify-center">
                <a href="{{ route('movies.index') }}"
                    class="logo transform hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('img/Logo.PNG') }}" alt="Logo" class="h-14">
                </a>
            </div>

            <!-- القائمة اليمنى -->
            <div class="flex items-center gap-4">
                @auth('client')
                    <!-- إذا كان المستخدم مسجلاً -->
                    <div class="flex items-center gap-4">
                        <!-- أيقونة الملف الشخصي -->
                        <a href="#" id="profileLink" class="nav-icon hover:text-darker-color">
                            <svg class="w-8 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>

                        <!-- زر تسجيل الخروج -->
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-2 text-second-color hover:text-darker-color">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 003 3h7a3 3 0 003-3V7a3 3 0 00-3-3h-7a3 3 0 00-3 3v1" />
                                </svg>
                                <span class="font-semibold">Logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- إذا لم يكن المستخدم مسجلاً -->
                    <div class="flex items-center gap-4">
                        <button onclick="showLoginModal()"
                            class="flex items-center space-x-2 bg-transparent text-second-color hover:text-darker-color">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-semibold">Login</span>
                        </button>
                        <button onclick="showRegisterModal()"
                            class="flex items-center space-x-2 bg-transparent text-second-color hover:text-darker-color">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="font-semibold">Register</span>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- القائمة الجوال -->
    <div class="mobile-menu">
        <div class="flex flex-col h-full p-4">
            <div class="flex justify-end">
                <button id="closeMobileMenu" class="p-2 text-gray-700 hover:text-second-color">
                    ✕
                </button>
            </div>

            <!-- محتوى القائمة -->
            <div class="mb-4">
                @auth('client')
                    <!-- إذا كان المستخدم مسجلاً -->
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-8 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-bold text-gray-800">Hi {{ Auth::guard('client')->user()->username }}</span>
                    </div>
                    <dev class="client">
                        <a href="#" id="mobileProfileLink"
                            class="w-full text-left p-2 text-gray-600 hover:bg-gray-100 rounded">
                            Show Profile
                        </a>
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <a type="submit" class="w-full text-left p-2 text-gray-600 hover:bg-gray-100 rounded">
                                Logout
                            </a>
                        </form>
                    </dev>
                @else
                    <!-- إذا لم يكن المستخدم مسجلاً -->
                    <div class="mb-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d=" M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-bold text-gray-800">Hi User</span>
                        </div>
                        <button onclick="showLoginModal()"
                            class="w-full text-left p-2 text-gray-600 hover:bg-gray-100 rounded">
                            {{ __('Log In') }}
                        </button>
                        <button onclick="showRegisterModal()"
                            class="w-full text-left p-2 text-gray-600 hover:bg-gray-100 rounded">
                            {{ __('Register') }}
                        </button>
                    </div>
                @endauth
            </div>

            <div class="border-t border-gray-200 my-2"></div>

            <div class="flex-1 flex flex-col space-y-2">
                <a href="{{ route('movies.index') }}"
                    class="p-2 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded">
                    Search Movie
                </a>
                <a href="{{ route('movies.index') }}"
                    class="p-2 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded">
                    Movies
                </a>
                @auth('client')
                    <a href="{{ route('client.bookings.index') }}"
                        class="p-2 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded">
                        My Bookings
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@include('movies.register_modal')

<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-2xl font-bold text-gray-900">Login</h3>
            <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Error Message -->
        @if ($errors->has('email') || $errors->has('password'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-center">
                <span>Incorrect email or password. Please try again.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('client.login.store') }}" class="space-y-6" id="loginForm">
            @csrf
            <div>
                <label for="login_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="login_email" required autocomplete="username"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-2 focus:ring-second-color focus:outline-none py-2 px-3">
            </div>

            <div>
                <label for="login_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="login_password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-2 focus:ring-second-color focus:outline-none py-2 px-3">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-second-color hover:bg-darker-color focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-second-color transition-colors duration-200">
                Sign in
            </button>
        </form>
        <div class="mt-4 text-center text-sm text-gray-700">
            <span>Don't have an account?</span>
            <a href="#" onclick="switchToRegister(); return false;" class="text-second-color hover:underline font-semibold">Create one here</a>
        </div>
    </div>
</div>

<script>
function showLoginModal() {
    document.getElementById('loginModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function switchToRegister() {
    closeLoginModal();
    showRegisterModal();
}

// Close modal when clicking outside
document.getElementById('loginModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLoginModal();
    }
});

// إبقاء المودال مفتوح إذا كان هناك أخطاء في تسجيل الدخول
@if ($errors->has('email') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', function() {
        showLoginModal();
    });
@endif

// Handle booking links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href*="/movie-shows/"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = url;
                } else if (response.status === 401) {
                    showLoginModal();
                } else {
                    // If response is not OK, and not a 401, check if it's JSON or not.
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        response.json().then(errorData => {
                            alert(errorData.message || `An error occurred (Status: ${response.status}). Please try again.`);
                        }).catch(() => {
                            alert(`An unexpected error occurred (Status: ${response.status}). Please try again.`);
                        });
                    } else {
                        // If it's not JSON, alert a generic error or simply reload.
                        alert(`An unexpected server error occurred (Status: ${response.status}). Please try again.`);
                        // Optionally, you might want to reload the page for unhandled errors:
                        // window.location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Fetch Error for booking link:', error);
                alert('An unexpected network error occurred. Please try again.');
            });
        });
    });
});
</script>

@include('client.profile_modal')

</body>

</html>
