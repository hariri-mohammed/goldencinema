@php
    $admin = Auth::guard('admin')->user();
@endphp

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

                <div id="list" class="hidden space-x-8 smkm:-my-px smkm:ms-10 smkm:flex">
                    <x-nav-link :href="route('admin_dashboard')" :active="request()->routeIs('admin_dashboard') ? 'active' : ''">
                        {{ __(' Home') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.managers.index')" :active="request()->routeIs('admin.managers.index') ? 'active' : ''">
                        {{ __(' Managers') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard') ? 'active' : ''">
                        {{ __(' Dashboard') }}
                    </x-nav-link>

                </div>

            </div>
            <!-- Settings Dropdown -->
            <div class="hidden smk:flex smk:items-center smk:ms-6 " style="margin-top: auto;">
                <button id="list-btn"
                    class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                    onclick="window.location.href='{{ route('admin.profile', ['id' => $admin->id]) }}'">
                    {{ $admin->username }}
                </button>

                <form method="POST" action="{{ route('admin_logout') }}" class="ml-4" style="margin-top: 15px;">
                    @csrf
                    <button id="list-btn"
                        class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                        {{ __('LogOut') }}
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center smk:hidden">
                <button id="list-btn" @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- </div> --}}
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div id="hidden":class="{ 'block': open, 'hidden': !open }" class="hidden smk:hidden ">
        <dev id="list" class="pt-2 pb-3 space-y-1 ">

            <x-responsive-nav-link :href="route('admin_dashboard')" :active="request()->routeIs('admin_dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>

        </dev>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('manager.profile', ['id' => $admin->id])">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('admin_logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('admin_logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ $admin->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $admin->email }}</div>
            </div>
        </div>

    </div>
</nav>
