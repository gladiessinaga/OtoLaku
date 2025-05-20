<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Pemesanan Saya</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4">
        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Mobil</th>
                        <th class="px-4 py-3 text-left">Tanggal Sewa</th>
                        <th class="px-4 py-3 text-left">Durasi</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemesanan as $index => $item)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $item->mobil->nama }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_sewa }}</td>
                            <td class="px-4 py-3">{{ $item->durasi }} hari</td>
                            <td class="px-4 py-3">
                                @if($item->status === 'selesai')
                                    <span class="inline-block px-2 py-1 rounded bg-green-200 text-green-800">Selesai</span>
                                @elseif($item->status === 'dibatalkan')
                                    <span class="inline-block px-2 py-1 rounded bg-red-200 text-red-800">Dibatalkan</span>
                                @else
                                    <span class="inline-block px-2 py-1 rounded bg-gray-200 text-gray-800">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('user.pemesanan.show', $item->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-4 text-gray-500">
                                Tidak ada riwayat pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
