<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Pemesanan Mobil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6">Riwayat Pemesanan Kamu</h1>

                    @if ($pemesanan->isEmpty())
                        <p class="text-gray-500">Belum ada pemesanan mobil yang dilakukan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Mobil</th>
                                        <th class="px-4 py-3 text-left">Tanggal Sewa</th>
                                        <th class="px-4 py-3 text-left">Durasi</th>
                                        <th class="px-4 py-3 text-left">Status Pemesanan</th>
                                        <th class="px-4 py-3 text-left">Status Pengembalian</th>
                                        <th class="px-4 py-3 text-left">Kondisi BBM Kembali</th>
                                        <th class="px-4 py-3 text-left">Denda BBM</th>
                                        <th class="px-4 py-3 text-left">Bayar Denda</th>
                                        <th class="px-4 py-3 text-left">Status Verifikasi Denda</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($pemesanan as $item)
                                        @php
                                            $statusColors = [
                                                'menunggu_verifikasi' => 'bg-yellow-200 text-yellow-800',
                                                'terverifikasi' => 'bg-green-200 text-green-800',
                                                'ditolak' => 'bg-red-200 text-red-800',
                                                'dibatalkan' => 'bg-gray-200 text-gray-800',
                                            ];
                                            $status = $item->status;
                                            $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <tr>
                                            <!-- Mobil -->
                                            <td class="px-4 py-3 font-medium">
                                                {{ $item->mobil->nama ?? '-' }}
                                            </td>

                                            <!-- Tanggal Sewa -->
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                            </td>

                                            <!-- Durasi -->
                                            <td class="px-4 py-3">
                                                {{ $item->durasi }} hari
                                            </td>

                                            <!-- Status Pemesanan -->
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded text-sm font-semibold {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                </span>
                                            </td>

                                            <!-- Status Pengembalian -->
                                            <td class="px-4 py-3">
                                                @if ($item->status_pengembalian === 'Sudah Dikembalikan')
                                                    <span class="text-green-500 font-semibold">Sudah Dikembalikan</span>
                                                @else
                                                    <span class="text-red-500 font-semibold">Belum Dikembalikan</span>
                                                @endif
                                            </td>

                                            <!-- Kondisi BBM -->
                                            <td class="px-4 py-3">
                                                {{ $item->kondisi_bbm_kembali ?? '-' }}
                                            </td>

                                            <!-- Denda BBM -->
                                            <td class="px-4 py-3">
                                                @if (isset($item->denda_bbm) && $item->denda_bbm > 0)
                                                    Rp {{ number_format($item->denda_bbm, 0, ',', '.') }}
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </td>

                                            <!-- Tombol Bayar Denda -->
                                            <td class="px-4 py-3">
                                                @if (isset($item->denda_bbm) && $item->denda_bbm > 0 && !$item->status_pembayaran_denda)
                                                    <a href="{{ route('user.bayar-denda-bbm', $item->id) }}" 
                                                    class="text-blue-600 hover:text-blue-800 underline text-sm font-medium">
                                                        Bayar Denda
                                                    </a>
                                                @elseif ($item->status_pembayaran_denda)
                                                    <span class="text-green-600 font-semibold text-sm">Sudah Dibayar</span>
                                                @else
                                                    <span class="text-gray-500 text-sm">-</span>
                                                @endif
                                            </td>

                                            <!-- Status Verifikasi Denda -->
                                            <td class="px-4 py-3">
                                                @switch($item->status_verifikasi_denda_bbm)
                                                    @case('diverifikasi')
                                                        <span class="text-green-500 font-semibold text-sm">Sudah Diverifikasi</span>
                                                        @break

                                                    @case('ditolak')
                                                        <span class="text-red-500 font-semibold text-sm">Ditolak</span>
                                                        @break

                                                    @case('menunggu')
                                                        <span class="text-yellow-500 font-semibold text-sm">Menunggu Verifikasi</span>
                                                        @break

                                                    @default
                                                        <span class="text-gray-400 text-sm">-</span>
                                                @endswitch
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
