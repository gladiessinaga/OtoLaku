<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            FAQ - Pertanyaan Umum
        </h2>
    </x-slot>

<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-xl">
    <h2 class="text-2xl font-bold mb-4">Kirim Feedback</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('feedback.store') }}">
        @csrf
        <label class="block mb-2">Kategori</label>
        <select name="kategori" class="w-full p-2 border rounded mb-4" required>
            <option value="">Pilih kategori</option>
            <option value="Saran">Saran</option>
            <option value="Keluhan">Keluhan</option>
            <option value="Bug">Laporan Bug</option>
        </select>

        <label class="block mb-2">Pesan</label>
        <textarea name="pesan" class="w-full p-2 border rounded mb-4" rows="5" required></textarea>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Kirim Feedback
        </button>
    </form>
</div>
</x-app-layout>
