<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pembayaran Denda BBM
        </h2>
    </x-slot>

    <div class="py-12 px-6 max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Bayar Denda BBM</h3>
        <p class="mb-2">Mobil: <strong>{{ $pemesanan->mobil->nama }}</strong></p>
        <p class="mb-4">Jumlah Denda BBM: <strong class="text-red-500">Rp {{ number_format($pemesanan->denda_bbm, 0, ',', '.') }}</strong></p>

        <form method="POST" action="{{ route('user.proses-bayar-denda-bbm', $pemesanan->id) }}" enctype="multipart/form-data">
            @csrf

            {{-- PILIH METODE PEMBAYARAN --}}
            <label for="metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Pilih Metode Pembayaran</label>
            <select id="metode_pembayaran" name="metode_pembayaran" class="w-full px-3 py-2 rounded border">
                <option value="">-- Pilih Metode --</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="E-Wallet">E-Wallet</option>
                {{-- <option value="COD">Bayar di Tempat (COD)</option> --}}
            </select>
            @error('metode_pembayaran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            {{-- QR CODE PEMBAYARAN --}}
            <div id="qr-code-section" class="mt-6 hidden">
                <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Scan QR untuk Pembayaran</label>
                <img src="{{ asset('images/qr-code-placeholder.png') }}" alt="QR Code Pembayaran" class="w-48 h-48">
                <p class="text-sm mt-2 text-gray-600 dark:text-gray-400">Gunakan aplikasi bank/e-wallet kamu untuk scan QR di atas.</p>
            </div>

            {{-- UPLOAD BUKTI PEMBAYARAN --}}
            <div class="mt-6">
                <label for="bukti_bbm" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Upload Bukti Pembayaran</label>
                <input type="file" id="bukti_bbm" name="bukti_bbm" class="w-full px-3 py-2 rounded border bg-white dark:bg-gray-700 dark:text-white">
                @error('bukti_bbm')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOMBOL SUBMIT --}}
            <button type="submit"
                class="mt-6 w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                Konfirmasi Pembayaran
            </button>
        </form>

        <div class="mt-6 text-sm text-gray-600 dark:text-gray-300">
            <p>Setelah kamu mengirim bukti pembayaran, admin akan memverifikasi dan menandai denda sebagai lunas.</p>
        </div>
    </div>

    {{-- SCRIPT UNTUK TAMPILKAN QR --}}
    <script>
        const metodePembayaran = document.getElementById('metode_pembayaran');
        const qrSection = document.getElementById('qr-code-section');

        metodePembayaran.addEventListener('change', function () {
            if (this.value === 'Transfer Bank' || this.value === 'E-Wallet') {
                qrSection.classList.remove('hidden');
            } else {
                qrSection.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
