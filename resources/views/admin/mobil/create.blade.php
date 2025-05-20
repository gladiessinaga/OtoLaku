<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Mobil</h2>
    </x-slot>

    <div class="p-4">
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
                        window.location.href = "{{ route('admin.mobil.index') }}";
                    }
                });
            </script>
        @endif

        <form action="{{ route('admin.mobil.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Nama Mobil -->
            <div>
                <input type="text" name="nama" placeholder="Nama Mobil"
                       class="border p-2 w-full" value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div>
                <input type="number" name="harga" placeholder="Harga"
                       class="border p-2 w-full" value="{{ old('harga') }}" required>
                @error('harga')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fasilitas -->
            <div>
                <textarea name="fasilitas" placeholder="Fasilitas"
                          class="border p-2 w-full" required>{{ old('fasilitas') }}</textarea>
                @error('fasilitas')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <textarea name="deskripsi" placeholder="Deskripsi"
                          class="border p-2 w-full" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <input type="file" name="foto" accept="image/*"
                       class="border p-2 w-full" required>
                @error('foto')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
