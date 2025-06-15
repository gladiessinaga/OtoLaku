<nav x-data="{ open: false }" class="bg-grey dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 border-b border-gray-300">
        <div class="flex justify-between items-center h-24">
            <!-- Left side: Logo dan Navigation Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links (hidden on mobile) -->
                <div class="hidden space-x-10 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <!-- Admin Navigation Links -->
                            <x-nav-link 
                                :href="route('admin.dashboard')" 
                                :active="request()->routeIs('admin.dashboard')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link 
                                :href="route('admin.pembatalan.index')" 
                                :active="request()->routeIs('admin.pembatalan.index')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Permintaan Pembatalan') }}
                            </x-nav-link>
                            {{-- <x-nav-link 
                                :href="route('user.notifikasi')" 
                                :active="request()->routeIs('notifications.index')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Notifikasi') }}
                            </x-nav-link> --}}
                        @elseif(auth()->user()->role === 'user')
                            <!-- User Navigation Links -->
                            <x-nav-link 
                                :href="route('user.dashboard')" 
                                :active="request()->routeIs('user.dashboard')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link 
                                :href="route('riwayat-pemesanan')" 
                                :active="request()->routeIs('riwayat-pemesanan')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Riwayat Pemesanan') }}
                            </x-nav-link>
                            {{-- <x-nav-link 
                                :href="route('user.notifikasi')" 
                                :active="request()->routeIs('notifications.index')" 
                                class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                                {{ __('Notifikasi') }}
                            </x-nav-link> --}}
                        @endif
                    @endauth

                    <!-- Link umum untuk semua -->
                    <x-nav-link 
                        :href="route('faq')" 
                        :active="request()->routeIs('faq')" 
                        class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                        {{ __('FAQ') }}
                    </x-nav-link>
                    <x-nav-link 
                        :href="route('user.lapor-masalah')" 
                        :active="request()->routeIs('user.lapor-masalah')" 
                        class="hover:border-b-2 hover:border-blue-500 transition duration-200">
                        {{ __('Lapor Masalah') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side: Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md 
                                text-primary dark:text-primary bg-[#46556D] hover:bg-[#5a6b87]  text-white dark:hover:text-primary
                                focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" 
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                            111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link 
                                    :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            @guest
    <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
        <a href="{{ route('login') }}"
           class="px-4 py-2 border border-myprimary-500 hover:bg-[#61728c] text-myprimary rounded-md text-center hover:bg-myprimary-200 hover:text-white transition w-full sm:w-auto">
            {{ __('Login') }}
        </a>
        <a href="{{ route('register') }}"
           class="px-4 py-2 bg-myprimary text-white rounded-md text-center bg-[#46556D] hover:bg-[#7c8ba3] hover:text-gray-900 transition w-full sm:w-auto">
            {{ __('Register') }}
        </a>
    </div>
@endguest



            <!-- Hamburger Menu (visible on mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button 
                    @click="open = ! open" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 
                    hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 
                    focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 
                    transition duration-150 ease-in-out" 
                    aria-controls="mobile-menu" 
                    aria-expanded="false">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Hamburger icon -->
                        <path 
                            :class="{ 'hidden': open, 'inline-flex': !open }" 
                            class="inline-flex" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 6h16M4 12h16M4 18h16" />
                        <!-- Close icon -->
                        <path 
                            :class="{ 'hidden': !open, 'inline-flex': open }" 
                            class="hidden" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                @include('components.navigation-admin')
                    <!-- Admin Mobile Menu -->
                    <x-responsive-nav-link 
                        :href="route('admin.dashboard')" 
                        :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link 
                        :href="route('admin.pembatalan.index')" 
                        :active="request()->routeIs('admin.pembatalan.index')">
                        {{ __('Permintaan Pembatalan') }}
                    </x-responsive-nav-link>
                    {{-- <x-responsive-nav-link 
                        :href="route('user.notifikasi')" 
                        :active="request()->routeIs('notifications.index')">
                        {{ __('Notifikasi') }}
                    </x-responsive-nav-link> --}}
                @elseif(auth()->user()->role === 'user')
                    <!-- User Mobile Menu -->
                    <x-responsive-nav-link 
                        :href="route('user.dashboard')" 
                        :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link 
                        :href="route('riwayat-pemesanan')" 
                        :active="request()->routeIs('riwayat-pemesanan')">
                        {{ __('Riwayat Pemesanan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link 
                        :href="route('user.notifikasi')" 
                        :active="request()->routeIs('notifications.index')">
                        {{ __('Notifikasi') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            <!-- Link umum mobile -->
            <x-responsive-nav-link 
                :href="route('faq')" 
                :active="request()->routeIs('faq')">
                {{ __('FAQ') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('user.lapor-masalah')" 
                :active="request()->routeIs('user.lapor-masalah')">
                {{ __('Lapor Masalah') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings (mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                @auth
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">Guest</div>
                @endauth
            </div>
            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link 
                            :href="route('logout')" 
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>


{{-- footer --}}

