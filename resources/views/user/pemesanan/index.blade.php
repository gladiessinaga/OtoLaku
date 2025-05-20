<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pemesanan Saya</h2>
            <a href="{{ route('user.dashboard') }}"
            class="inline-block bg-gray-200 hover:bg-gray-300 text-sm text-gray-800 font-semibold py-1.5 px-4 rounded">
                ← Dashboard
            </a>
        </div>
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
                            <td class="px-4 py-3">{{ $item->mobil ? $item->mobil->nama : 'Mobil tidak ditemukan' }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_sewa }}</td>
                            <td class="px-4 py-3">{{ $item->durasi }} hari</td>
                            <td class="px-4 py-3">
                                @if($item->status === 'dibatalkan')
                                    <span class="inline-block px-2 py-1 rounded bg-red-200 text-red-800">Dibatalkan</span>
                                @elseif($item->permintaan_pembatalan && $item->status_pembatalan === 'pending')
                                    <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-800">Menunggu Persetujuan Pembatalan</span>
                                @elseif($item->status_pembatalan === 'ditolak')
                                    <span class="inline-block px-2 py-1 rounded bg-orange-100 text-orange-800">Pembatalan Ditolak</span>
                                @elseif($item->status === 'menunggu_verifikasi')
                                    <span class="inline-block px-2 py-1 rounded bg-yellow-200 text-yellow-800">Menunggu Verifikasi Admin</span>
                                @elseif($item->status === 'terverifikasi')
                                    <span class="inline-block px-2 py-1 rounded bg-green-200 text-green-800">Terverifikasi</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 space-y-1">
                                <a href="{{ route('user.pemesanan.show', $item->id) }}" class="text-blue-600 hover:underline block">Lihat</a>
                                @if(in_array($item->status, ['menunggu_verifikasi', 'terverifikasi']) && !$item->permintaan_pembatalan)
                                    <button onclick="openCancelModal({{ $item->id }})"
                                        class="text-yellow-600 hover:underline text-sm block mt-1">Batalkan</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-4 text-gray-500">
                                Anda belum melakukan pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Pembatalan --}}
    <div id="cancel-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Alasan Pembatalan</h3>
            <form id="cancel-form" method="POST">
                @csrf
                <select name="alasan" id="reason-select" class="w-full border p-2 rounded mb-3" required>
                    <option value="">Pilih alasan</option>
                    <option value="Saya berubah pikiran">Saya berubah pikiran</option>
                    <option value="Jadwal saya berubah">Jadwal saya berubah</option>
                    <option value="Harganya tidak sesuai harapan">Harganya tidak sesuai harapan</option>
                    <option value="Layanan tidak meyakinkan">Layanan tidak meyakinkan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <textarea name="alasan_lain" id="other-reason" class="w-full border p-2 rounded mb-3 hidden"
                    placeholder="Tulis alasan lain..."></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeCancelModal()" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openCancelModal(id) {
            document.getElementById('cancel-modal').classList.remove('hidden');
            document.getElementById('cancel-form').action = '/user/pemesanan/' + id + '/batalkan';
        }

        function closeCancelModal() {
            document.getElementById('cancel-modal').classList.add('hidden');
        }

        document.getElementById('reason-select').addEventListener('change', function () {
            const otherInput = document.getElementById('other-reason');
            otherInput.classList.toggle('hidden', this.value !== 'Lainnya');
        });
    </script>
    @endpush
</x-app-layout>
