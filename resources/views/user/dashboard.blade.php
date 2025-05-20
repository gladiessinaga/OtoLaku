<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Kontainer Utama -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Salam Pengguna -->
            <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}</h1>

            <!-- Menu Pemesanan Aktif -->
            <div>
                <a href="{{ route('user.pemesanan.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                    Lihat Pemesanan Aktif
                </a>
            </div>

            <!-- Daftar Mobil -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Daftar Mobil</h2>

                <div class="grid grid-cols-1 md:dagrid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($mobilTersedia as $mobil)
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
                                <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-48 object-cover rounded mb-4">
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
