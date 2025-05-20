<div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pesan {{ $mobil->nama }}</h1>
    <p class="text-gray-700 mb-2">Harga: Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>
    <p class="text-gray-600">Fasilitas: {{ $mobil->fasilitas }}</p>
    <!-- Nanti bisa isi form input tanggal peminjaman di sini -->
    <button class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
        Lanjut ke Form Pemesanan
    </button>
</div>
