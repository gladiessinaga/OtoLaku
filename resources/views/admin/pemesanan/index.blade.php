<x-app-layout>
    <x-slot name="header">
        {{-- Bisa dibiarkan kosong atau isi jika dibutuhkan --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-2xl font-bold mb-6">Daftar Pemesanan Masuk</h1>

                    {{-- Notifikasi sukses --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel daftar pemesanan --}}
                    <div class="overflow-x-auto bg-white dark:bg-gray-700 rounded shadow">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-200">
                            <thead class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 font-semibold">
                                <tr>
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">Nama User</th>
                                    <th class="py-3 px-4">Nomor HP</th> <!-- Kolom nomor HP ditambah -->
                                    <th class="py-3 px-4">Mobil</th>
                                    <th class="py-3 px-4">Tanggal Sewa</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemesanan as $item)
                                    @php
                                        $normalizedStatus = strtolower($item->status);
                                        $statusLabel = [
                                            'menunggu_verifikasi' => ['Menunggu Verifikasi', 'bg-yellow-200 text-yellow-800'],
                                            'terverifikasi' => ['Terverifikasi', 'bg-green-200 text-green-800'],
                                            'ditolak' => ['Telah Ditolak', 'bg-red-200 text-red-800'],
                                            'dibatalkan' => ['Dibatalkan', 'bg-red-300 text-red-900'],
                                        ];
                                        $status = $statusLabel[$normalizedStatus] ?? ['Dalam Tinjauan, Silahkan Lihat Detail Pemesanan', 'bg-gray-200 text-gray-800'];
                                    @endphp

                                    <tr class="border-t dark:border-gray-600">
                                        <td class="py-3 px-4">{{ $item->id }}</td>
                                        <td class="py-3 px-4">{{ $item->user->name }}</td>
                                        <td class="py-3 px-4">{{ $item->user->no_hp }}</td> <!-- Nomor HP user -->
                                        <td class="py-3 px-4">{{ $item->mobil->nama }}</td>
                                        <td class="py-3 px-4">{{ $item->tanggal_sewa }}</td>
                                        <td class="py-3 px-4">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $status[1] }}">
                                                {{ $status[0] }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 flex gap-3 items-center flex-wrap">
                                            <a href="{{ route('admin.pemesanan.detail', $item->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                Detail
                                            </a>

                                            @if($normalizedStatus === 'menunggu_verifikasi')
                                                <form action="{{ route('admin.pemesanan.verifikasi', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                        Verifikasi
                                                    </button>
                                                </form>
                                            @endif

                                            <button onclick="openDeleteModal({{ $item->id }})"
                                                class="text-red-600 dark:text-red-400 hover:underline cursor-pointer">
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
            </div>

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
        aria-hidden="true"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full p-6 text-gray-800 dark:text-gray-100">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6">Apakah kamu yakin ingin menghapus pemesanan ini?</p>
            <div class="flex justify-end gap-4">
                <button
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white"
                >
                    Batal
                </button>
                <button
                    id="confirm-delete-btn"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded"
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