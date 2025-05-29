<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Pemesanan Mobil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Cek jika tidak ada pemesanan --}}
                    @if($pemesanans->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">Belum ada riwayat pemesanan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <tr>
                                        <th class="border px-4 py-2">No</th>
                                        <th class="border px-4 py-2">Mobil</th>
                                        <th class="border px-4 py-2">Tanggal Sewa</th>
                                        <th class="border px-4 py-2">Durasi</th>
                                        <th class="border px-4 py-2">Total Harga</th>
                                        <th class="border px-4 py-2">Status</th>
                                        <th class="border px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 dark:text-gray-100">
                                    @foreach($pemesanans as $index => $item)
                                        @php
                                            $biayaSupir = $item->pakai_supir ? 200000 : 0;
                                            $subtotal = $item->mobil->harga * $item->durasi;
                                            $totalHarga = $subtotal + $biayaSupir;
                                        @endphp
                                        <tr class="border-t border-gray-300 dark:border-gray-600">
                                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border px-4 py-2">{{ $item->mobil->nama ?? 'Mobil tidak ditemukan' }}</td>
                                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                                            <td class="border px-4 py-2">{{ $item->durasi }} hari</td>
                                            <td class="border px-4 py-2">
                                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                                <div class="text-xs text-gray-500">
                                                    (Mobil: Rp{{ number_format($subtotal, 0, ',', '.') }}<br>
                                                    Supir: Rp{{ number_format($biayaSupir, 0, ',', '.') }})
                                                </div>
                                            </td>
                                            <td class="border px-4 py-2">
                                                @if($item->status === 'menunggu')
                                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Menunggu</span>
                                                @elseif($item->status === 'terverifikasi')
                                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Terverifikasi</span>
                                                @elseif($item->status === 'diserahkan' && !$item->sudah_dikembalikan)
                                                    <span class="bg-indigo-200 text-indigo-800 px-2 py-1 rounded text-sm">Diserahkan</span>
                                                @elseif($item->sudah_dikembalikan)
                                                    <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-sm">Dikembalikan</span>
                                                @elseif($item->status === 'dibatalkan')
                                                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Dibatalkan</span>
                                                @elseif($item->status === 'ditolak')
                                                    <span class="bg-red-300 text-red-900 px-2 py-1 rounded text-sm">Ditolak</span>
                                                @else
                                                    <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm">Tidak Diketahui</span>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2 text-sm">
                                                @if($item->status === 'menunggu')
                                                    <form action="{{ route('user.pembatalan.konfirmasi', $item->id) }}" method="GET">
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                @elseif($item->status === 'diserahkan' && !$item->sudah_dikembalikan)
                                                    <form action="{{ route('user.pengembalian.ajukan', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan pengembalian mobil?');">
                                                        @csrf
                                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-3 py-1 rounded">
                                                            Ajukan Pengembalian
                                                        </button>
                                                    </form>
                                                @elseif($item->status === 'dibatalkan')
                                                    <a href="{{ route('pengembalian.uang', $item->id) }}" class="text-blue-600 hover:underline">
                                                        Lihat Pengembalian Uang
                                                    </a>
                                                @elseif($item->status_pengembalian === 'menunggu_verifikasi')
                                                    <span class="text-sm text-orange-500">Menunggu Verifikasi</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
