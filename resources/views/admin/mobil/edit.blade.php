<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Edit Mobil
        </h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('admin.mobil.update', $mobil->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="text" name="nama" value="{{ $mobil->nama }}" class="border p-2 w-full mb-2" required>
            <input type="number" name="harga" value="{{ $mobil->harga }}" class="border p-2 w-full mb-2" required>

            <textarea name="deskripsi" class="border p-2 w-full mb-2" required>{{ $mobil->deskripsi }}</textarea>
            <textarea name="fasilitas" class="border p-2 w-full mb-2" required>{{ $mobil->fasilitas }}</textarea>

            {{-- Tampilkan foto lama jika ada --}}
            @if ($mobil->foto)
                <div class="mb-2">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $mobil->foto) }}" 
                        alt="Foto Mobil" 
                        class="w-40 h-24 object-cover rounded cursor-pointer"
                        id="previewFoto">
                </div>
            @endif


            {{-- Upload foto baru (opsional) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Upload Foto (opsional)</label>
                <input type="file" name="foto" accept="image/*" class="border p-2 w-full">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
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
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-red-600 text-xl">&times;</button>
        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="Foto Mobil Besar" class="w-full h-auto rounded">
    </div>
</div>

<!-- Script -->
<script>
    const previewFoto = document.getElementById('previewFoto');
    const modalFoto = document.getElementById('modalFoto');
    const closeModal = document.getElementById('closeModal');

    previewFoto.addEventListener('click', () => {
        modalFoto.classList.remove('hidden');
    });

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
