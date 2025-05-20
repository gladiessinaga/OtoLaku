<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Pemesanan Masuk</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm font-medium text-gray-700">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Nama User</th>
                        <th class="py-3 px-4">Mobil</th>
                        <th class="py-3 px-4">Tanggal Sewa</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @foreach($pemesanan as $item)
                        @php
                            $normalizedStatus = strtolower($item->status);
                            $statusLabel = [
                                'menunggu_verifikasi' => ['Menunggu Verifikasi', 'bg-yellow-200 text-yellow-800'],
                                'terverifikasi' => ['Terverifikasi', 'bg-green-200 text-green-800'],
                                'ditolak' => ['Telah Ditolak', 'bg-red-200 text-red-800'],
                                'dibatalkan' => ['Dibatalkan', 'bg-red-300 text-red-900'],
                            ];
                            $status = $statusLabel[$normalizedStatus] ?? ['Status Tidak Diketahui', 'bg-gray-200 text-gray-800'];
                        @endphp

                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $item->id }}</td>
                            <td class="py-3 px-4">{{ $item->user->name }}</td>
                            <td class="py-3 px-4">{{ $item->mobil->nama }}</td>
                            <td class="py-3 px-4">{{ $item->tanggal_sewa }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 flex gap-3 items-center">
                                <a href="{{ route('admin.pemesanan.detail', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>

                                @if($normalizedStatus === 'menunggu_verifikasi')
                                    <form action="{{ route('admin.pemesanan.verifikasi', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            Verifikasi
                                        </button>
                                    </form>
                                    {{-- <form action="{{ route('admin.pemesanan.batalkan', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Batalkan
                                        </button>
                                    </form> --}}
                                @endif

                                <button onclick="openDeleteModal({{ $item->id }})" class="text-red-600 hover:underline cursor-pointer">
                                    Hapus
                                </button>

                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.pemesanan.destroy', $item->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden"
        aria-hidden="true"
    >
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6">Apakah kamu yakin ingin menghapus pemesanan ini?</p>
            <div class="flex justify-end gap-4">
                <button
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                    Batal
                </button>
                <button
                    id="confirm-delete-btn"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function openDeleteModal(id) {
            deleteId = id;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteId = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        document.getElementById('confirm-delete-btn').addEventListener('click', function () {
            if(deleteId) {
                document.getElementById('delete-form-' + deleteId).submit();
            }
        });
    </script>
</x-app-layout>
