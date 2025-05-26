@if(session('login_success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                toast: true,               // bikin notifikasi toast kecil
                position: 'top-end',       // di pojok kanan atas
                icon: 'success',
                title: '{{ session('login_success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                showCloseButton: true,     // tombol close biar user bisa langsung tutup
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer) // pause timer kalau hover
                    toast.addEventListener('mouseleave', Swal.resumeTimer) // lanjut timer kalau keluar hover
                }
            });
        });
    </script>
@endif

@stack('scripts')


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Salam Pengguna -->
<h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}</h1>


            
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
                        <td class="p-2 border">{{ $pemesanan->tanggal_mulai }}</td>
                        <td class="p-2 border">{{ $pemesanan->durasi }} hari</td>
                        <td class="p-2 border">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-sm rounded
                                    @if($pemesanan->status == 'terverifikasi') bg-green-500
                                    @elseif($pemesanan->status == 'dibatalkan') bg-red-500
                                    @else bg-yellow-500
                                    @endif text-white">
                                    {{ ucfirst($pemesanan->status) }}
                                </span>
                                @if($pemesanan->status == 'dibatalkan')
                                    <a href="{{ route('pengembalian.uang', $pemesanan->id) }}" 
   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg shadow-md transition duration-200"
   title="Klik untuk melihat detail pengembalian dana Anda">
   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405M21 12.5A8.38 8.38 0 0012.5 4h-1M9 21v-6m0 0L6 17m3-2l3 2m0 0v-4" />
   </svg>
   Lihat Pengembalian Dana
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
            
            <!-- Menu Pemesanan Aktif -->
            <div>
                <a href="{{ route('user.pemesanan.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                    Lihat Pemesanan Aktif
                </a>
                
            </div>

            <!-- Tombol Kirim Feedback -->
<div class="mt-6">
    <a href="{{ route('feedback.form') }}" 
       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
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
                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
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
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
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
