<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Penyerahan Mobil ke Penyewa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Tabel Pemesanan Siap Diserahkan --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 space-y-6">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Mobil Siap Diserahkan
                </h1>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                                <th class="p-3">Penyewa</th>
                                <th class="p-3">Mobil</th>
                                <th class="p-3">Tanggal Sewa</th>
                                <th class="p-3">Durasi</th>
                                <th class="p-3">Alamat Pengantaran</th>
                                <th class="p-3">No Telepon</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-100">
                            @forelse ($pemesananSiapDiserahkan as $pemesanan)
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3">{{ $pemesanan->user->name }}</td>
                                    <td class="p-3">{{ $pemesanan->mobil->nama }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($pemesanan->tanggal_sewa)->translatedFormat('d M Y') }}</td>
                                    <td class="p-3">{{ $pemesanan->durasi }} hari</td>
                                    <td class="p-3">{{ $pemesanan->alamat_pengantaran ?? '-'}} </td>
                                    <td class="p-3">{{ $pemesanan->user->no_hp }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-sm rounded bg-yellow-500 text-white">
                                            Siap Diserahkan
                                        </span>
                                    </td>
                                    <td class="p-3">
    <!-- Tombol: Buka Modal -->
    <button 
        type="button"
        onclick="document.getElementById('modal-serahkan-{{ $pemesanan->id }}').classList.remove('hidden')" 
        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow"
    >
        Tandai Sudah Diserahkan
    </button>

    <!-- Modal Konfirmasi -->
    <div id="modal-serahkan-{{ $pemesanan->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Konfirmasi Penyerahan</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Apakah Anda yakin ingin menandai pemesanan ini sebagai <strong>Sudah Diserahkan</strong>?</p>
            <div class="flex justify-end space-x-4">
                <button 
                    type="button" 
                    onclick="document.getElementById('modal-serahkan-{{ $pemesanan->id }}').classList.add('hidden')" 
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600"
                >
                    Batal
                </button>
                <form action="{{ route('admin.penyerahan.serahkan', $pemesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Ya, Tandai
                    </button>
                </form>
            </div>
        </div>
    </div>
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-gray-500 dark:text-gray-400">
                                        Tidak ada pemesanan yang siap diserahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Pemesanan Belum Diverifikasi --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 space-y-6">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Mobil Belum Diverifikasi
                </h1>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                                <th class="p-3">Penyewa</th>
                                <th class="p-3">Mobil</th>
                                <th class="p-3">Tanggal Sewa</th>
                                <th class="p-3">Durasi</th>
                                <th class="p-3">Alamat Pengantaran</th>
                                <th class="p-3">No Telepon</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-100">
                            @forelse ($pemesananBelumVerifikasi as $pemesanan)
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3">{{ $pemesanan->user->name }}</td>
                                    <td class="p-3">{{ $pemesanan->mobil->nama }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                                    <td class="p-3">{{ $pemesanan->durasi }} hari</td>
                                    <td class="p-3">{{ $pemesanan->alamat_pengantaran }} </td>
                                    <td class="p-3">{{ $pemesanan->user->no_hp }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-sm rounded bg-red-500 text-white">
                                            {{ ucfirst($pemesanan->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
    <!-- Tombol Hapus: memicu modal -->
    <button
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
        onclick="document.getElementById('modal-hapus-{{ $pemesanan->id }}').classList.remove('hidden')"
    >
        Hapus
    </button>

    <!-- Modal Konfirmasi -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Konfirmasi Verifikasi</h2>
    <p class="text-gray-700 dark:text-gray-300 mb-6">Apakah Anda yakin untuk memverifikasi penyerahan ini?</p>
    <div class="flex justify-end space-x-4">
      <button id="cancelBtn" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600">Batal</button>
      <button id="confirmBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ya, Verifikasi</button>
    </div>
  </div>
</div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-hapus-{{ $pemesanan->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Hapus</h2>
            <p class="mb-6 text-gray-600">Apakah kamu yakin ingin menghapus pemesanan ini?</p>
            <div class="flex justify-end space-x-3">
                <button
                    onclick="document.getElementById('modal-hapus-{{ $pemesanan->id }}').classList.add('hidden')"
                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"
                >
                    Batal
                </button>
                <form action="{{ route('admin.pemesanan.hapus', $pemesanan->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-gray-500 dark:text-gray-400">
                                        Tidak ada pemesanan yang menunggu verifikasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Pemesanan Sudah Diserahkan --}}
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 space-y-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        Mobil Sudah Diserahkan ke Penyewa
    </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                    <th class="p-3">Penyewa</th>
                    <th class="p-3">Mobil</th>
                    <th class="p-3">No Telepon</th>
                    <th class="p-3">Tanggal Sewa</th>
                    <th class="p-3">Durasi</th>
                    <th class="p-3">Alamat Pengantaran</th>
                    <th class="p-3">Status Penyerahan</th>
                </tr>
            </thead>
            <tbody class="text-gray-800 dark:text-gray-100">
                @forelse ($pemesananSudahDiserahkan as $pemesanan)
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-3">{{ $pemesanan->user->name }}</td>
                        <td class="p-3">{{ $pemesanan->mobil->nama }}</td>
                        <td class="p-3">{{ $pemesanan->user->no_hp }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($pemesanan->tanggal_sewa)->translatedFormat('d M Y') }}</td>
                        <td class="p-3">{{ $pemesanan->durasi }} hari</td>
                        <td class="p-3">{{ $pemesanan->alamat_pengantaran ?? '-'}}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-sm rounded bg-green-600 text-white">
                                Sudah Diserahkan
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500 dark:text-gray-400">
                            Belum ada mobil yang diserahkan ke penyewa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel Mobil Menunggu Verifikasi Pengembalian --}}
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 space-y-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        Mobil Menunggu Verifikasi Pengembalian
    </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                
                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                    <th class="p-3">Penyewa</th>
                    <th class="p-3">Mobil</th>
                    <th class="p-3">No Telepon</th>
                    <th class="p-3">Tanggal Sewa</th>
                    <th class="p-3">Durasi</th>
                    <th class="p-3">Alamat Pengantaran</th>
                    <th class="p-3">Tanggal Pengembalian</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800 dark:text-gray-100">
                @forelse ($pemesananS as $pemesanan)
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-3">{{ $pemesanan->user->name }}</td>
                        <td class="p-3">{{ $pemesanan->mobil->nama }}</td>
                        <td class="p-3">{{ $pemesanan->user->no_hp }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($pemesanan->tanggal_sewa)->translatedFormat('d M Y') }}</td>
                        <td class="p-3">{{ $pemesanan->durasi }} hari</td>
                        <td class="p-3">{{ $pemesanan->alamat_pengantaran ?? '-' }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pengembalian)->translatedFormat('d M Y') }}</td>
                        <td class="p-3">
                            @if (!$pemesanan->sudah_dikembalikan)
                                <form action="{{ route('admin.pengembalian.verifikasi', $pemesanan->id) }}" method="POST" onsubmit="return confirm('Yakin mobil sudah dikembalikan oleh penyewa?');">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                                        🔁 Tandai Sudah Dikembalikan
                                    </button>
                                </form>
                            @else
                                <span class="px-2 py-1 text-sm rounded bg-green-500 text-white">
                                    Sudah Dikembalikan
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500 dark:text-gray-400">
                            Tidak ada mobil yang menunggu verifikasi pengembalian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


    {{-- SweetAlert Success --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>

       <script>
  const modal = document.getElementById('confirmModal');
  const openModalBtn = document.getElementById('openModalBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const confirmBtn = document.getElementById('confirmBtn');
  const form = document.getElementById('verifikasiForm');

  openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  cancelBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
  });

  confirmBtn.addEventListener('click', () => {
    form.submit();
  });
</script>

    @endif
</x-app-layout>