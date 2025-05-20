<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
    @guest
    <div class="mb-6 flex space-x-6">
        <a href="{{ route('login') }}"
           class="text-blue-600 underline hover:text-blue-800 transition duration-200">
            Login
        </a>
        <a href="{{ route('register') }}"
           class="text-green-600 underline hover:text-green-800 transition duration-200">
            Register
        </a>
    </div>
@endguest           
                    <div class="max-w-7xl mx-auto py-10 px-4">
                        <h1 class="text-2xl font-bold mb-6">Daftar Mobil</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($mobils as $mobil)
                                <div class="border rounded-lg p-4 shadow">
                                    @if ($mobil->foto)
                                        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-40 object-cover rounded">
                                    @else
                                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    <h2 class="text-xl font-semibold mt-4">{{ $mobil->nama }}</h2>
                                    <p class="text-sm text-gray-600 mt-2">{{ $mobil->deskripsi }}</p>
                                    <p class="mt-2 text-green-6dd00 font-bold">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>
                                    <p class="text-sm text-gray-500 mt-1">Fasilitas: {{ $mobil->fasilitas }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
