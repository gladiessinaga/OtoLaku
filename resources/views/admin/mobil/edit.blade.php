<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Edit Mobil
        </h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('admin.mobil.update', $mobil->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <input type="text" name="nama" value="{{ $mobil->nama }}" class="border p-2 w-full mb-2" required>
            <input type="number" name="harga" value="{{ $mobil->harga }}" class="border p-2 w-full mb-2" required>

            {{-- Tambahkan ini --}}
            <textarea name="deskripsi" class="border p-2 w-full mb-2" required>{{ $mobil->deskripsi }}</textarea>

            <textarea name="fasilitas" class="border p-2 w-full mb-2" required>{{ $mobil->fasilitas }}</textarea>

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
</x-app-layout>