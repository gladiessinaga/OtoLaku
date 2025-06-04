<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Verifikasi Denda BBM
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-200">Daftar Denda BBM</h3>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full table-auto border">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                    <th class="p-2">Penyewa</th>
                    <th class="p-2">Mobil</th>
                    <th class="p-2">Jumlah Denda</th>
                    <th class="p-2">Bukti Transfer</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $pemesanan)
                    <tr class="border-t">
                        <td class="p-2">{{ $pemesanan->user->name }}</td>
                        <td class="p-2">{{ $pemesanan->mobil->nama }}</td>
                        <td class="p-2 text-red-500">Rp {{ number_format($pemesanan->denda_bbm, 0, ',', '.') }}</td>
                        <td class="p-2">
                            @if($pemesanan->bukti_bbm)
                                <a href="{{ asset('storage/' . $pemesanan->bukti_bbm) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
                            @else
                                <span class="text-gray-500">Belum ada</span>
                            @endif
                        </td>
                        <td class="p-2 capitalize">{{ $pemesanan->status_verifikasi_denda_bbm }}</td>
                        <td class="p-2">
                            @if($pemesanan->status_verifikasi_denda_bbm !== 'diverifikasi')
                                <form method="POST" action="{{ route('admin.verifikasi-denda-bbm', $pemesanan->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Verifikasi
                                    </button>
                                </form>
                            @else
                                <span class="text-green-600">Sudah Diverifikasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data denda BBM.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
