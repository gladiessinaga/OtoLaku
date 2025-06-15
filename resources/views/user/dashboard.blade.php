@stack('scripts')
<x-app-layout>
    <x-slot name="header">
        @push('styles')
            <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
        @endpush
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-start', // pojok kiri atas
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    @endif
</script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                                        {{-- <!-- Salam Pengguna -->
                            <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}</h1> --}}

                            <!-- Carousel Start -->
                            <div class="mb-10 flex justify-center">
                            <div id="carouselExampleIndicators" 
                                class="carousel slide w-full max-full h-[300px] sm:h-[400px] md:h-[500px] overflow-hidden shadow-lg" 
                                data-bs-ride="carousel">

                                <div class="carousel-inner h-full relative">
                                <!-- Slide 1: kiri bawah -->
                                <div class="carousel-item active h-full relative">
                                    <img src="{{ asset('storage/carousel1.jpg') }}" class="object-cover h-full w-full" alt="Slide 1">
                                    <div class="absolute bottom-6 right-6 max-w-xl text-white drop-shadow-lg">
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
                                    <p class="text-base sm:text-lg">Pesan langsung melalui aplikasi. Pilih metode pembayaran favoritmu: transfer, e-wallet, atau COD.</p>
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
                    {{-- <div class="relative bg-cover bg-center h-[400px] rounded-lg shadow mb-10" style="background-image: url('/img/hero-car-rental.jpg');">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg"></div>
                        <div class="relative z-10 flex flex-col justify-center items-start h-full p-10 text-white">
                            <h2 class="text-4xl font-bold mb-4">Sewa Mobil Mudah & Cepat</h2>
                            <p class="text-lg mb-6 max-w-xl">Atur perjalananmu dengan nyaman dan aman hanya dalam satu platform. Temukan mobil terbaik untuk kebutuhan perjalanan bisnis maupun pribadi.</p>
                            <a href="#daftar-mobil" class="bg-green-600 hover:bg-green-700 transition px-6 py-3 rounded text-white font-semibold shadow">
                                Mulai Cari Mobil
                            </a>
                        </div>
                    </div> --}}

            
            {{-- @if ($unreadNotifications && $unreadNotifications->count() > 0)
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow mt-4 mb-6" role="alert">
                        <p class="font-bold mb-2">Notifikasi Baru:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($unreadNotifications as $notification)
                                <li>
                                    {{-- Contoh menampilkan message dari data notifikasi --}}
                                    {{-- {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
            @endif  --}}
            
            <!-- Status Pemesanan Terbaru -->
            @if ($pemesananTerbaru)
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow" role="alert">
                    <p class="font-bold mb-1">Status Pemesanan Terakhir:</p>
                    <p>Mobil: <strong>{{ $pemesananTerbaru->mobil->nama }}</strong></p>
                    <p>Status: 
                        <span class="px-2 py-1 text-sm rounded
                            @if($pemesananTerbaru->status == 'terverifikasi') bg-green-500
                            @elseif($pemesananTerbaru->status == 'dibatalkan') bg-red-500
                            @elseif(isset($pembatalan) && $pembatalan->status == 'disetujui') bg-gray-300
                            @elseif(isset($pemesanan) && $pemesanan->status == 'menunggu_verifikasi') bg-blue-500
                            @else bg-yellow-500
                            @endif text-white">
                            {{ ucfirst($pemesananTerbaru->status) }}
                        </span>
                    </p>
                    <p>Penyerahan: {{ $pemesananTerbaru->status_penyerahan ?? 'Belum diserahkan' }}</p>
                </div>
            @endif

            <!-- Riwayat Status Pemesanan Lengkap -->
<div>
    <h2 class="text-2xl font-bold mt-6 mb-4">Status Pemesanan Anda</h2>
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">Mobil</th>
                    <th class="p-2 border">Tanggal Sewa</th>
                    <th class="p-2 border">Durasi</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Penyerahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesananUser as $pemesanan)
                    <tr class="border-b">
                        <td class="p-2 border">{{ $pemesanan->mobil->nama }}</td>
                        <td class="p-2 border">{{ $pemesanan->tanggal_sewa }}</td>
                        <td class="p-2 border">{{ $pemesanan->durasi }} hari</td>
                        <td class="p-2 border">
                            <div class="flex items-center gap-6">
                                <span class="px-2 py-1 text-sm rounded
                                    @if($pemesanan->status == 'terverifikasi') bg-green-500
                                    @elseif($pemesanan->status == 'dibatalkan') bg-red-500
                                    @elseif(isset($pemesanan) && $pemesanan->status == 'menunggu_verifikasi') bg-blue-500
                                    @else bg-yellow-500
                                    @endif text-white">
                                    {{ ucfirst($pemesanan->status) }}
                                </span>
                                @if($pemesanan->status == 'dibatalkan')
                                    <a href="{{ route('pengembalian.uang', $pemesanan->id) }}" 
                                    class="inline-flex items-center px-2 py-1 bg-blue-500 hover:bg-green-600 text-white text-sm font-medium text-sm rounded shadow-md transition duration-200"
                                    title="Klik untuk melihat detail pengembalian dana Anda"> Lihat Pengembalian Dana
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="p-2 border">
                            {{ $pemesanan->status_penyerahan ?? 'Belum diserahkan' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3 text-gray-500">Belum ada pemesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
            
            <!-- Section Aksi Cepat untuk User -->
<div class="mt-4 mb-6 flex flex-col sm:flex-row items-center sm:justify-between gap-4 bg-gray-100 p-4 rounded-lg shadow-md">

    <!-- Tombol Lihat Pemesanan -->
    <a href="{{ route('user.pemesanan.index') }}"
       class="w-full sm:w-auto bg-[#46556D] hover:bg-[#5a6b87] text-white font-semibold py-2 px-6 rounded-lg text-center transition shadow">
        Lihat Pemesanan
    </a>

    <a href="{{ route('user.riwayat') }}"
       class="w-full sm:w-auto bg-[#46556D] hover:bg-[#5a6b87] text-white font-semibold py-2 px-6 rounded-lg text-center transition shadow">
        Riwayat Pembatalan
    </a>

    <!-- Tombol Kirim Feedback -->
    <a href="{{ route('feedback.form') }}"
       class="w-full sm:w-auto bg-[#46556D] hover:bg-[#5a6b87] text-white font-semibold py-2 px-6 rounded-lg text-center transition shadow">
        Kirim Feedback
    </a>

</div>
            <!-- Daftar Mobil -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Daftar Mobil</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($mobilTersedia as $mobil)
                        <div class="border rounded-lg p-4 shadow">
                            @if ($mobil->foto)
                                <div x-data="{ open: false }" class="relative">
    <!-- Thumbnail gambar -->
    <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" 
         class="w-full h-40 object-cover rounded cursor-pointer"
         @click="open = true">

    <!-- Modal overlay -->
    <div
        x-show="open"
        x-transition
        style="display: none"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80"
        @click.self="open = false"
    >
        <!-- Modal content -->
        <div class="relative">
            <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" 
                 class="max-w-4xl max-h-screen rounded shadow-lg">
            <button @click="open = false" 
                    class="absolute top-2 right-2 text-white text-3xl font-bold">&times;</button>
        </div>
    </div>
</div>

                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                    Tidak ada foto
                                </div>
                            @endif

                            <h2 class="text-xl font-semibold mt-4">{{ $mobil->nama }}</h2>
                            <p class="text-sm text-gray-600 mt-2">{{ $mobil->deskripsi }}</p>
                            <p class="mt-2 text-green-600 font-bold">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>
                            <p class="text-sm text-gray-500 mt-1">Fasilitas: {{ $mobil->fasilitas }}</p>

                            <!-- Tombol Detail -->
                            <button 
                                class="mt-4 bg-[#46556D] hover:bg-[#5a6b87] text-white font-semibold py-2 px-4 rounded"
                                onclick="openModal({{ $mobil->id }})">
                                Detail
                            </button>
                        </div>

                        <!-- Modal Detail Mobil -->
                        <div id="modal-deskripsi-{{ $mobil->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white w-full max-w-lg p-6 rounded shadow relative">
                                
                                <!-- Tombol Tutup -->
                                <button onclick="closeModal({{ $mobil->id }})" 
                                    class="absolute top-4 right-4 p-2 hover:bg-gray-200 rounded-full transition duration-150" aria-label="Close Modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Isi Modal -->
                                <h2 class="text-xl font-bold mb-2">{{ $mobil->nama }}</h2>
                                @if ($mobil->foto)
                                <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-48 object-cover rounded mb-4">
                                @endif
                                <p class="text-sm text-gray-700 mb-4">{{ $mobil->deskripsi_lengkap }}</p>
                                <p class="text-sm text-gray-600">Fasilitas: {{ $mobil->fasilitas }}</p>
                                <p class="text-green-600 font-semibold mt-2">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-between mt-6">
                                    <button onclick="closeModal({{ $mobil->id }})" class="text-gray-500 hover:underline">Kembali</button>
                                    <a href="{{ route('pemesanan.form', $mobil->id) }}" 
                                        class="bg-[#46556D] hover:bg-[#3b465a] text-white px-4 py-2 rounded">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

    <!-- Script Modal -->
    <script>
        function openModal(id) {
            const modal = document.getElementById(`modal-deskripsi-${id}`);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(`modal-deskripsi-${id}`);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
        
    </script>
</x-app-layout>
