<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pemesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">

                    {{-- Informasi Pemesanan --}}
                    <section>
                        <h3 class="text-lg font-semibold mb-4">Informasi Pemesanan</h3>
                        <table class="w-full text-sm text-gray-700 dark:text-gray-300 border-collapse">
                            <tbody>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left w-1/3 font-medium">Nama User</th>
                                    <td class="py-2">{{ $pemesanan->user->name }}</td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left font-medium">Mobil</th>
                                    <td class="py-2">{{ $pemesanan->mobil->nama }}</td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left font-medium">Tanggal Sewa</th>
                                    <td class="py-2">{{ $pemesanan->tanggal_sewa }}</td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left font-medium">Durasi</th>
                                    <td class="py-2">{{ $pemesanan->durasi }} hari</td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left font-medium">Status</th>
                                    <td class="py-2">
                                        <span class="inline-block px-2 py-1 rounded
                                            @if ($pemesanan->status === 'menunggu_verifikasi') bg-yellow-200 text-yellow-800
                                            @elseif ($pemesanan->status === 'terverifikasi') bg-green-200 text-green-800
                                            @elseif ($pemesanan->status === 'ditolak') bg-red-200 text-red-800
                                            @else bg-gray-200 text-gray-800
                                            @endif
                                        ">
                                            {{ ucfirst($pemesanan->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left font-medium">Catatan</th>
                                    <td class="py-2">{{ $pemesanan->catatan ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    {{-- Dokumen --}}
                    <section>
                        <h3 class="text-lg font-semibold mb-4">Dokumen (KTP & SIM)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="font-medium text-sm mb-1">Dokumen KTP:</p>
                                @if($pemesanan->ktp)
                                    <a href="{{ asset('storage/' . $pemesanan->ktp) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat KTP
                                    </a>
                                @else
                                    <span class="text-gray-500">Belum ada dokumen KTP</span>
                                @endif
                            </div>

                            <div>
                                <p class="font-medium text-sm mb-1">Dokumen SIM:</p>
                                @if($pemesanan->sim)
                                    <a href="{{ asset('storage/' . $pemesanan->sim) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat SIM
                                    </a>
                                @else
                                    <span class="text-gray-500">Belum ada dokumen SIM</span>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- Tombol Aksi --}}
                    <section>
                        @if ($pemesanan->status === 'menunggu_verifikasi')
                            <form action="{{ route('admin.pemesanan.verifikasi', $pemesanan->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition shadow">
                                    ✔ Verifikasi Pesanan
                                </button>
                            </form>

                            <button
                                type="button"
                                onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition shadow ml-2"
                            >
                                ✘ Tolak Pesanan
                            </button>

                        @elseif ($pemesanan->status === 'terverifikasi')
                            <div class="text-green-700 font-semibold">
                                Pesanan sudah terverifikasi.
                            </div>

                        @elseif ($pemesanan->status === 'ditolak')
                            <div class="text-red-700 font-semibold mb-2">
                                ✘ Pesanan telah ditolak.
                            </div>

                            <form action="{{ route('admin.pemesanan.terima_kembali', $pemesanan->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition shadow">
                                    ✔ Terima Kembali Pesanan
                                </button>
                            </form>
                        @endif
                    </section>

                    {{-- Modal Konfirmasi Penolakan --}}
                    <div id="modal-tolak" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 max-w-sm w-full">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Konfirmasi Penolakan</h3>
                            <p class="mb-6 text-gray-700 dark:text-gray-300">Yakin ingin menolak pesanan ini?</p>

                            <div class="flex justify-end space-x-4">
                                <button
                                    type="button"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600"
                                    onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                                >
                                    Batal
                                </button>

                                <form action="{{ route('admin.pemesanan.tolak', $pemesanan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Tolak Pesanan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Kembali --}}
                    <section>
                        <a href="{{ route('admin.pemesanan.index') }}" class="text-blue-600 hover:underline">
                             Kembali ke daftar pesanan
                        </a>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
