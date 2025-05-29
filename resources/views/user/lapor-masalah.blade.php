<x-app-layout>
    <x-slot name="header">
        {{-- Judul halaman bisa ditambahkan jika perlu --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-2xl font-bold mb-6">Lapor Masalah</h1>

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Formulir laporan --}}
                    <form action="{{ route('user.lapor-masalah.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="deskripsi" class="block font-medium mb-1">Deskripsi Masalah:</label>
                            <textarea name="deskripsi" id="deskripsi" required rows="5"
                                      class="w-full p-3 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="block font-medium mb-1">Foto (opsional):</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="w-full p-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded transition">
                            Kirim Laporan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>