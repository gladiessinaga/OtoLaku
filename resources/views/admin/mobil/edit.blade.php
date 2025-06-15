<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Edit Mobil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <form action="{{ route('admin.mobil.update', $mobil->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <input type="text" name="nama" value="{{ old('nama', $mobil->nama) }}" 
                           class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required placeholder="Nama Mobil">

                    <input type="number" name="harga" value="{{ old('harga', $mobil->harga) }}" 
                           class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required placeholder="Harga">

                    <textarea name="deskripsi" 
                              class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              required placeholder="Deskripsi">{{ old('deskripsi', $mobil->deskripsi) }}</textarea>

                    <textarea name="fasilitas" 
                              class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              required placeholder="Fasilitas">{{ old('fasilitas', $mobil->fasilitas) }}</textarea>

                    @if ($mobil->foto)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $mobil->foto) }}" 
                                 alt="Foto Mobil" 
                                 class="w-40 h-24 object-cover rounded cursor-pointer shadow"
                                 id="previewFoto">
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" for="foto">
                            Upload Foto (opsional)
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" 
                               class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                    </div>

                    <div>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-md transition">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Kembali ke Dashboard',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.dashboard') }}";
            }
        });
    </script>
    @endif

    <!-- Modal untuk Preview Foto -->
    <div id="modalFoto" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow-lg relative max-w-lg w-full">
            <button id="closeModal" aria-label="Close modal" 
                    class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-red-600 text-3xl font-bold leading-none">&times;</button>
            <img src="{{ asset('storage/' . $mobil->foto) }}" alt="Foto Mobil Besar" class="w-full h-auto rounded">
        </div>
    </div>

    <script>
        const previewFoto = document.getElementById('previewFoto');
        const modalFoto = document.getElementById('modalFoto');
        const closeModal = document.getElementById('closeModal');

        if(previewFoto){
            previewFoto.addEventListener('click', () => {
                modalFoto.classList.remove('hidden');
            });
        }

        closeModal.addEventListener('click', () => {
            modalFoto.classList.add('hidden');
        });

        // Tutup modal jika klik di luar konten
        modalFoto.addEventListener('click', (e) => {
            if (e.target === modalFoto) {
                modalFoto.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>
