<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            FAQ - Pertanyaan Umum
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-6">

        {{-- Pesan error atau session jika ada --}}
        @if (session('error'))
            <div class="mb-4 text-red-600">
                {{ session('error') }}
            </div>
        @endif

        {{-- Detail FAQ jika ada --}}
        @if (isset($faqDetail))
            <div class="mb-8 p-6 bg-gray-100 rounded shadow">
                <h3 class="text-xl font-semibold mb-2">Pertanyaan:</h3>
                <p class="mb-4">{{ $faqDetail->question }}</p>

                <h3 class="text-xl font-semibold mb-2">Jawaban:</h3>
                <p>{{ $faqDetail->answer }}</p>
            </div>
        @endif

        {{-- Daftar FAQ --}}
        <h3 class="text-3xl font-bold mb-6">Daftar FAQ</h3>
        <ul class="list-disc list-inside space-y-3">
            @foreach ($faqs as $faq)
                <li>
                    <a href="{{ route('faq.show', ['id' => $faq->id]) }}" 
                       class="text-blue-600 hover:underline">
                        {{ $faq->question }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="text-center mt-10">
            <p class="text-sm text-gray-600 mb-2">Tidak menemukan jawaban yang kamu cari?</p>
            <a href="{{ route('user.lapor-masalah') }}" 
               class="inline-block bg-red-500 text-white px-5 py-2 rounded hover:bg-red-600 transition">
                Laporkan Masalah
            </a>
        </div>

    </div>
</x-app-layout>
