<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Kartu Salam dan Statistik --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                    Selamat datang, <span class="text-green-600 dark:text-green-400">{{ Auth::user()->name }}</span>
                </h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                    <a href="{{ route('admin.pemesanan.index') }}" 
                       class="flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded shadow transition text-center">
                        Pesanan Masuk
                    </a>

                    <a href="{{ route('admin.penyerahan') }}" 
                       class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded shadow transition text-center">
                        Penyerahan Mobil
                    </a>

                    <a href="{{ route('admin.pembatalan.disetujui') }}" 
                       class="flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded shadow transition text-center">
                        Pembatalan Disetujui
                    </a>

                    <a href="{{ route('admin.feedback') }}" 
                       class="flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded shadow transition text-center">
                        Feedback User
                    </a>

                    <div class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 font-medium py-3 px-4 rounded shadow flex items-center justify-between">
                        <span>Pesanan Baru:</span>
                        <span class="bg-red-600 text-white rounded-full px-3 py-1 text-sm font-semibold ml-2">
                            {{ $jumlahPemesananBaru ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Daftar Mobil --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Daftar Mobil</h2>
                    <a href="{{ route('admin.mobil.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                        + Tambah Mobil
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                                <th class="p-3">Foto</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3">Fasilitas</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-100">
                            @forelse ($mobils as $mobil)
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3">
                                        <img src="{{ asset('storage/' . $mobil->foto) }}" 
                                            alt="Foto Mobil" 
                                            class="w-24 h-16 object-cover rounded cursor-pointer previewFoto" 
                                            data-full="{{ asset('storage/' . $mobil->foto) }}" />
                                    </td>
                                    <td class="p-3">{{ $mobil->nama }}</td>
                                    <td class="p-3">Rp{{ number_format($mobil->harga) }}</td>
                                    <td class="p-3">{{ $mobil->fasilitas }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.mobil.edit', $mobil->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form id="delete-form-{{ $mobil->id }}" action="{{ route('admin.mobil.destroy', $mobil->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="text-red-500 hover:underline delete-btn"
                                                    data-id="{{ $mobil->id }}"
                                                    data-nama="{{ $mobil->nama }}">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-gray-500 dark:text-gray-400">Belum ada data mobil.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert untuk notifikasi sukses --}}
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
    @endif

    {{-- SweetAlert untuk konfirmasi delete --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll(".delete-btn");
            deleteButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const id = this.getAttribute("data-id");
                    const nama = this.getAttribute("data-nama");
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Mobil "${nama}" akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                });
            });
        });
    </script>

    {{-- Modal Preview Foto --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modalFoto = document.getElementById('modalFoto');
            const modalImage = document.getElementById('modalImage');
            const closeModal = document.getElementById('closeModal');

            document.querySelectorAll('.previewFoto').forEach(img => {
                img.addEventListener('click', function () {
                    modalImage.src = this.getAttribute('data-full');
                    modalFoto.classList.remove('hidden');
                });
            });

            closeModal.addEventListener('click', () => {
                modalFoto.classList.add('hidden');
                modalImage.src = '';
            });

            modalFoto.addEventListener('click', (e) => {
                if (e.target === modalFoto) {
                    modalFoto.classList.add('hidden');
                    modalImage.src = '';
                }
            });
        });
    </script>

    <div id="modalFoto" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-4 max-w-lg max-h-[80vh] overflow-auto relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 font-bold text-xl">&times;</button>
            <img id="modalImage" src="" alt="Preview Foto Mobil" class="max-w-full max-h-[70vh] rounded" />
        </div>
    </div>

</x-app-layout>
