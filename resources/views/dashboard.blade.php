@stack('styles')

<x-app-layout>
    <x-slot name="header">
        @push('styles')
            <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
        @endpush
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2> --}}
    </x-slot>

    <div class="py-19">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="dark:bg-blue-400 overflow-hidden  sm:rounded-lg">
                <div class="p-6 text-black-200 dark:text-gray-100">
                    <div class="max-w-7xl mx-auto py-2 px-4">
                        <div class="mb-10">

                            <!-- Carousel Start -->
                            <div class="mb-10 flex justify-center">
                            <div id="carouselExampleIndicators" 
                                class="carousel slide w-full max-w-6xl h-[300px] sm:h-[400px] md:h-[500px] overflow-hidden shadow-lg" 
                                data-bs-ride="carousel">

                                <div class="carousel-inner h-full relative">
                                <!-- Slide 1: kiri bawah -->
                                <div class="carousel-item active h-full relative">
                                    <img src="{{ asset('storage/carousel1.jpg') }}" class="object-cover h-full w-full" alt="Slide 1">
                                    <div class="absolute bottom-6 left-6 max-w-xl text-white drop-shadow-lg">
                                    <h2 class="text-3xl sm:text-4xl font-bold mb-2">Sewa Mobil Jadi Lebih Mudah!</h2>
                                    <p class="text-base sm:text-lg">Nikmati kemudahan menyewa mobil hanya dalam beberapa klik melalui aplikasi kami. Cepat, aman, dan terpercaya.</p>
                                    </div>
                                </div>

                                <!-- Slide 2: kanan bawah -->
                                <div class="carousel-item h-full relative">
                                    <img src="{{ asset('storage/carousel2.jpg') }}" class="object-cover h-full w-full" alt="Slide 2">
                                    <div class="absolute bottom-6 right-6 max-w-xl text-white drop-shadow-lg text-right">
                                    <h2 class="text-3xl sm:text-4xl font-bold mb-2">Beragam Pilihan Mobil Berkualitas</h2>
                                    <p class="text-base sm:text-lg">Temukan mobil yang sesuai kebutuhanmu, dari city car hingga mobil keluarga. Semua dalam kondisi prima dan siap digunakan.</p>
                                    </div>
                                </div>
                                <!-- Slide 3: tengah bawah -->
                                <div class="carousel-item h-full relative">
                                    <img src="{{ asset('storage/carousel3.jpg') }}" class="object-cover h-full w-full" alt="Slide 3">
                                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 max-w-xl text-white drop-shadow-lg text-left">
                                    <h2 class="text-3xl sm:text-4xl font-bold mb-2">Pemesanan Instan, Pembayaran Aman</h2>
                                    <p class="text-base sm:text-lg">Pesan langsung melalui aplikasi. Pilih metode pembayaran favoritmu: transfer, e-wallet, atau COD.d</p>
                                    </div>
                                </div>
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-black bg-opacity-50 rounded-full p-2"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-black bg-opacity-50 rounded-full p-2"></span>
                                </button>

                            </div>
                            </div>
                            <!-- Carousel End -->

                        <!-- Hero Section -->
                     {{-- <div class="relative bg-cover bg-center h-[400px] rounded-lg shadow mb-10" style="background-image: url('da');">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg"></div>
                        <div class="relative z-10 flex flex-col justify-center items-start h-full p-10 text-white">
                            <h2 class="text-4xl font-bold mb-4">Sewa Mobil Mudah & Cepat</h2>
                            <p class="text-lg mb-6 max-w-xl">Atur perjalananmu dengan nyaman dan aman hanya dalam satu platform. Temukan mobil terbaik untuk kebutuhan perjalanan bisnis maupun pribadi.</p>
                            <a href="#daftar-mobil" class="bg-green-600 hover:bg-green-700 transition px-6 py-3 rounded text-white font-semibold shadow">
                                Mulai Cari Mobil
                            </a>
                        </div>
                    </div>  --}}

                    {{-- daftar mobil singkat --}}
                        <h1 class="text-2xl font-bold mb-6">Daftar Mobil</h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($mobils as $mobil)
                                <div class="card-mobil p-4">
                                    @if ($mobil->foto)
                                        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-40 object-cover rounded">
                                    @else
                                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    <h2 class="text-xl font-semibold mt-4">{{ $mobil->nama }}</h2>
                                    <p class="text-sm text-gray-600 mt-2">{{ $mobil->deskripsi }}</p>
                                    <p class="harga">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>
                                    <p class="fasilitas">Fasilitas: {{ $mobil->fasilitas }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
