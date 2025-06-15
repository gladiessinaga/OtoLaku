<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $mobil->nama }}</h1>
    <img src="{{ asset('storage/' . $mobil->foto) }}" class="w-full h-64 object-cover rounded mb-4" alt="{{ $mobil->nama }}">
    <p class="text-gray-700 mb-2">{{ $mobil->deskripsi }}</p>
    <p class="text-green-600 font-semibold mb-2">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>
    <p class="text-gray-500">Fasilitas: {{ $mobil->fasilitas }}</p>
</div>
