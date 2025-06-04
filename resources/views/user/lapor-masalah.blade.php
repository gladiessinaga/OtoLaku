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
                                      class="w-full p-3 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                      placeholder="Jelaskan masalah yang kamu alami secara detail..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="block font-medium mb-1">Foto (opsional):</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="w-full p-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded transition">
                                Kirim Laporan
                            </button>

                            {{-- Tombol WhatsApp --}}
                            <div>
                                <p class="text-sm mb-1 text-gray-500 dark:text-gray-300">
                                    Butuh bantuan cepat? Hubungi admin langsung lewat WhatsApp:
                                </p>
                                <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20melaporkan%20masalah%20dan%20butuh%20respon%20segera."
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.9c0 2.1.62 4.1 1.8 5.85L2 22l4.34-1.38a10.92 10.92 0 005.7 1.53h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm0 17.87c-1.78 0-3.51-.47-5.03-1.35l-.36-.2-2.57.82.86-2.5-.22-.38a8.74 8.74 0 01-1.32-4.6c0-4.81 3.91-8.72 8.72-8.72 4.81 0 8.72 3.91 8.72 8.72s-3.91 8.72-8.72 8.72zm4.78-6.55c-.26-.13-1.53-.76-1.77-.85-.24-.09-.42-.13-.6.13-.17.26-.69.85-.85 1.03-.15.17-.31.19-.58.06-.26-.13-1.1-.41-2.1-1.3-.78-.7-1.3-1.57-1.45-1.83-.15-.26-.02-.4.11-.53.12-.13.26-.31.39-.47.13-.15.17-.26.26-.43.09-.17.04-.32-.02-.45-.06-.13-.6-1.44-.82-1.98-.22-.53-.44-.46-.6-.47l-.51-.01c-.17 0-.44.06-.67.32-.22.26-.87.85-.87 2.08 0 1.23.89 2.42 1.01 2.58.13.17 1.74 2.65 4.22 3.71.59.25 1.04.4 1.39.52.58.18 1.1.16 1.51.1.46-.07 1.4-.57 1.6-1.13.2-.56.2-1.04.15-1.13-.05-.09-.24-.15-.5-.27z"/>
                                    </svg>
                                    Chat Admin Sekarang
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
