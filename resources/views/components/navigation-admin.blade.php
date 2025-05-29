<aside class="w-64 h-screen fixed top-0 left-0 bg-[#314355] text-white z-50 shadow-lg">
    <div class="p-6 border-b border-gray-600">
        {{-- Logo tanpa link --}}
        <div class="block h-10 w-auto text-white font-bold text-xl">LOGO</div>
    </div>

    <nav class="mt-6">
        <ul class="space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <li>
                        <x-nav-link 
                            :href="route('admin.dashboard')" 
                            :active="request()->routeIs('admin.dashboard')" 
                            class="flex items-center px-4 py-3 rounded-md hover:border-b-2 hover:border-blue-500 transition duration-200"
                        >
                            <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                            </svg>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </li>

                    <li>
                        <x-nav-link 
                            :href="route('admin.pembatalan.index')" 
                            :active="request()->routeIs('admin.pembatalan.index')" 
                            class="flex items-center px-4 py-3 rounded-md hover:border-b-2 hover:border-blue-500 transition duration-200"
                        >
                            <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13M9 5v2m0 4h13" />
                            </svg>
                            {{ __('Permintaan Pembatalan') }}
                        </x-nav-link>
                    </li>

                    <li>
                        <x-nav-link 
                            :href="route('user.notifikasi')" 
                            :active="request()->routeIs('notifications.index')" 
                            class="flex items-center px-4 py-3 rounded-md hover:border-b-2 hover:border-blue-500 transition duration-200"
                        >
                            <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V5a2 2 0 10-4 0v.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m8 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            {{ __('Notifikasi') }}
                        </x-nav-link>
                    </li>
                @endif
            @endauth
        </ul>
    </nav>

    @auth
        <div class="absolute bottom-0 w-full px-6 py-4 border-t border-gray-600">
            <div class="text-white mb-2">{{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="flex items-center text-sm hover:underline"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </a>
            </form>
        </div>
    @endauth
</aside>
