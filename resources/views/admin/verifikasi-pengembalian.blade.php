<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Verifikasi Pengembalian Mobil
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

                    {{-- Daftar mobil yang perlu diverifikasi --}}
                    <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">Mobil yang Perlu Diverifikasi</h3>

                    @if($pemesanans->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">Tidak ada mobil yang perlu diverifikasi hari ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="border px-4 py-2">No</th>
                                        <th class="border px-4 py-2">Nama Penyewa</th>
                                        <th class="border px-4 py-2">Nomor HP</th>
                                        <th class="border px-4 py-2">Mobil</th>
                                        <th class="border px-4 py-2">Tanggal Sewa</th>
                                        <th class="border px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemesanans as $index => $p)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border px-4 py-2">{{ $p->user->name }}</td>
                                            <td class="border px-4 py-2">{{ $p->user->no_hp ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $p->mobil->nama }}</td>
                                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal_sewa_terakhir)->format('d M Y') }}</td>
                                            <td class="border px-4 py-2">
                                                <button onclick="document.getElementById('modal-{{ $p->id }}').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                                    Verifikasi
                                                </button>

                                                {{-- Modal --}}
                                                <div id="modal-{{ $p->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                                    <div class="bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md">
                                                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Verifikasi Pengembalian</h3>

                                                        <form action="{{ route('admin.proses_verifikasi', $p->id) }}" method="POST">
                                                            @csrf

                                                            {{-- Dropdown BBM --}}
                                                            <label for="kondisi_bbm_kembali" class="block mb-2 text-gray-700 dark:text-gray-300">Kondisi BBM saat dikembalikan:</label>
                                                            <select name="kondisi_bbm_kembali" id="kondisi_bbm_kembali" class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-gray-100" required>
                                                                <option value="">-- Pilih Kondisi --</option>
                                                                <option value="Penuh">Penuh</option>
                                                                <option value="Setengah">Setengah</option>
                                                                <option value="Hampir Habis">Hampir Habis</option>
                                                            </select>
                                                            @error('kondisi_bbm_kembali')
                                                                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                                                            @enderror

                                                            {{-- Input Denda Manual --}}
                                                            <label for="denda_bbm" class="block mb-2 text-gray-700 dark:text-gray-300">Denda BBM (jika ada):</label>
                                                            <input type="number" name="denda_bbm" id="denda_bbm" class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-gray-100" placeholder="Contoh: 50000" min="0">
                                                            @error('denda_bbm')
                                                                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                                                            @enderror

                                                            <div class="flex justify-end space-x-2">
                                                                <button type="button" onclick="document.getElementById('modal-{{ $p->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                                    Verifikasi
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                {{-- End Modal --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Hasil Verifikasi --}}
                    @if($hasilVerifikasi->isEmpty())
                        <p class="mt-8 text-gray-600 dark:text-gray-300">Belum ada hasil verifikasi pengembalian mobil.</p>
                    @else
                        <h3 class="mt-10 mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Hasil Verifikasi Pengembalian</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="border px-4 py-2">No</th>
                                        <th class="border px-4 py-2">Nama Penyewa</th>
                                        <th class="border px-4 py-2">Nomor HP</th>
                                        <th class="border px-4 py-2">Mobil</th>
                                        <th class="border px-4 py-2">Tanggal Sewa</th>
                                        <th class="border px-4 py-2">Kondisi BBM Kembali</th>
                                        <th class="border px-4 py-2">Denda BBM</th>
                                        <th class="border px-4 py-2">Tanggal Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasilVerifikasi as $index => $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border px-4 py-2">{{ $item->user->name }}</td>
                                            <td class="border px-4 py-2">{{ $item->user->no_hp ?? '-' }}</td>
                                            <td class="border px-4 py-2">{{ $item->mobil->nama }}</td>
                                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_sewa_terakhir)->format('d M Y') }}</td>
                                            <td class="border px-4 py-2">{{ $item->kondisi_bbm_kembali ?? '-' }}</td>
                                            <td class="border px-4 py-2">
                                                @if(isset($item->denda_bbm) && $item->denda_bbm > 0)
                                                    Rp {{ number_format($item->denda_bbm, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</td>
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
