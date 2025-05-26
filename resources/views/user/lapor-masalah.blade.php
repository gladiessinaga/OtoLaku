<x-app-layout>
    <x-slot name="header">
        <h2>Lapor Masalah</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.lapor-masalah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Deskripsi Masalah:</label>
            <textarea name="deskripsi" required class="w-full p-2 border rounded"></textarea>

            <label class="mt-4">Foto (optional):</label>
            <input type="file" name="foto" accept="image/*" class="w-full">

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Laporan</button>
        </form>
    </div>
</x-app-layout>
