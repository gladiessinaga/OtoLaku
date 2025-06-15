<x-app-layout>
    <x-slot name="header">
        {{-- Judul halaman bisa ditambahkan jika perlu --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Judul halaman --}}
                    <h1 class="text-2xl font-bold mb-6">FAQ - Pertanyaan Umum</h1>

                    {{-- Pesan error --}}
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Detail FAQ jika ada --}}
                    @if (isset($faqDetail))
                        <div class="mb-8 p-6 bg-gray-100 text-gray-800 dark:text-gray-200 rounded shadow">
                            <h3 class="text-xl font-semibold mb-2">Pertanyaan:</h3>
                            <p class="mb-4">{{ $faqDetail->question }}</p>

                            <h3 class="text-xl font-semibold mb-2">Jawaban:</h3>
                            <p>{{ $faqDetail->answer }}</p>
                        </div>
                    @endif

                    {{-- Daftar FAQ --}}
                    <h3 class="text-xl font-bold mb-4">Daftar FAQ</h3>
                    <ul class="list-disc list-inside space-y-3">
                        @foreach ($faqs as $faq)
                            <li>
                                <a href="{{ route('faq.show', ['id' => $faq->id]) }}" 
                                   class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $faq->question }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- CTA jika tidak menemukan jawaban --}}
                    <div class="text-center mt-10">
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Tidak menemukan jawaban yang kamu cari?</p>
                        <a href="{{ route('user.lapor-masalah') }}" 
                           class="inline-block bg-red-500 text-white px-5 py-2 rounded hover:bg-red-600 transition">
                            Laporkan Masalah
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
