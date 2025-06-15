<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            Verifikasi Denda BBM
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Daftar Denda BBM</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 uppercase text-sm">
                                <th class="p-3">Penyewa</th>
                                <th class="p-3">Mobil</th>
                                <th class="p-3">Tanggal Sewa</th>
                                <th class="p-3">Durasi</th>
                                <th class="p-3">Jumlah Denda</th>
                                <th class="p-3">Bukti Transfer</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-100">
                            @forelse($pemesanans as $pemesanan)
                                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3">{{ $pemesanan->user->name }}</td>
                                    <td class="p-3">{{ $pemesanan->mobil->nama }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($pemesanan->tanggal_sewa_terakhir)->format('d M Y') }}</td>
                                    <td class="p-3">{{ $pemesanan->durasi }}</td>
                                    <td class="p-3 text-red-500">Rp {{ number_format($pemesanan->denda_bbm, 0, ',', '.') }}</td>
                                    <td class="p-3">
                                        @if($pemesanan->bukti_bbm)
                                            <a href="{{ asset('storage/' . $pemesanan->bukti_bbm) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="p-3 capitalize">{{ $pemesanan->status_verifikasi_denda_bbm }}</td>
                                    <td class="p-3">
                                        @if($pemesanan->status_verifikasi_denda_bbm !== 'diverifikasi')
                                            <!-- Tombol trigger modal -->
                                            <button 
                                                onclick="document.getElementById('modal-verifikasi-{{ $pemesanan->id }}').classList.remove('hidden')" 
                                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition duration-200"
                                            >
                                                Verifikasi
                                            </button>

        <!-- Modal Konfirmasi -->
        <div id="modal-verifikasi-{{ $pemesanan->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Verifikasi</h2>
                <p class="text-gray-700 mb-6">Apakah Anda yakin ingin memverifikasi pembayaran denda BBM untuk <strong>{{ $pemesanan->user->name }}</strong>?</p>
                <div class="flex justify-end gap-3">
                    <button 
                        onclick="document.getElementById('modal-verifikasi-{{ $pemesanan->id }}').classList.add('hidden')" 
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400"
                    >
                        Batal
                    </button>
                    <form method="POST" action="{{ route('admin.verifikasi-denda-bbm', $pemesanan->id) }}">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Ya, Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <span class="text-green-600">Sudah Diverifikasi</span>
    @endif
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">Tidak ada data denda BBM.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi SweetAlert2 jika sukses --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-start',
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
        </script>
    @endif
</x-app-layout>
