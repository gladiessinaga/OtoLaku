<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konfirmasi Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Pemesanan #{{ $pemesanan->id }}</h3>

                    {{-- RINCIAN PEMESANAN --}}
                    <div class="mb-6 space-y-1">
                        <p><strong>Mobil:</strong> {{ $pemesanan->mobil->nama }}</p>
                        <p><strong>Merk:</strong> {{ $pemesanan->mobil->merk }}</p>
                        <p><strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }}</p>
                        <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
                        <p><strong>Harga per Hari:</strong> Rp {{ number_format($pemesanan->mobil->harga, 0, ',', '.') }}</p>
                        <p><strong>Subtotal:</strong> Rp <span id="subtotal">{{ number_format($pemesanan->mobil->harga * $pemesanan->durasi, 0, ',', '.') }}</span></p>

                        {{-- Supir --}}
                        <p>
                            <strong>Pakai Supir:</strong> 
                            {{ $pemesanan->opsi_sopir ? 'Ya (+ Rp 200.000)' : 'Tidak' }}
                        </p>

                        @php
                            $biayaSupir = $pemesanan->opsi_sopir ? 200000 : 0;
                            $subtotal = $pemesanan->mobil->harga * $pemesanan->durasi;
                            $totalHarga = $subtotal + $biayaSupir;
                        @endphp

                        <p class="font-bold text-lg mt-4">
                            <strong>Total Pembayaran:</strong> Rp <span id="total">{{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    {{-- FORM PEMBAYARAN --}}
                    <form action="{{ route('konfirmasi', $pemesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <input type="hidden" name="total_harga" id="total_harga_input" value="{{ $totalHarga }}">

                        <div class="mb-4">
                            <label for="metode" class="block font-medium">Metode Pembayaran:</label>
                            <select name="metode" id="metode" class="w-full border px-3 py-2 rounded" required onchange="handleMetodeChange(this.value)">
                                <option value="" disabled selected>Pilih Metode</option>
                                <option value="cod">COD (Bayar di tempat)</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="transfer">Transfer Bank</option>
                            </select>
                        </div>

                        <div id="instruksi-cod" class="hidden bg-gray-100 p-4 rounded mb-4">
                            <p><strong>Instruksi COD:</strong> Silakan siapkan uang tunai dan lakukan pembayaran saat pengambilan mobil.</p>
                        </div>

                        <div id="instruksi-ewallet" class="hidden bg-gray-100 p-4 rounded mb-4">
                            <p><strong>Instruksi E-Wallet:</strong></p>
                            <ul class="list-disc pl-6">
                                <li>Transfer ke nomor: <strong>0812-3456-7890 (OVO / DANA / GoPay)</strong></li>
                                <li>Scan QR Code di bawah ini:</li>
                            </ul>
                            <img src="{{ asset('storage/qr_code.png') }}" alt="QR E-Wallet" class="w-40 mt-2">
                            <label class="block mt-3">Upload Bukti Transfer E-Wallet:</label>
                            <input type="file" name="bukti_ewallet" class="w-full border rounded px-3 py-2 mt-1">
                        </div>

                        <div id="instruksi-transfer" class="hidden bg-gray-100 p-4 rounded mb-4">
                            <p><strong>Instruksi Transfer Bank:</strong></p>
                            <ul class="list-disc pl-6">
                                <li>Transfer ke Virtual Account: <strong>1234567890123456 (BCA)</strong></li>
                                <li>Atas Nama: <strong>RentalMobil Official</strong></li>
                            </ul>
                            <label class="block mt-3">Upload Bukti Transfer Bank:</label>
                            <input type="file" name="bukti_transfer" class="w-full border rounded px-3 py-2 mt-1">
                        </div>

                        {{-- Tombol Kembali --}}
                        <div class="flex space-x-4">
                        <a href="#" id="btn-kembali" space-x-8
                        class="bg-gray-300 text-gray-700 px-2 py-2 rounded hover:bg-gray-400">
                        Kembali
                        </a>

                        <button type="button" id="btn-konfirmasi" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                    </div>
            </div>
        </div>
    </div>

        <!-- Modal Syarat & Ketentuan Pembatalan -->
<div id="modal-syarat" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Syarat & Ketentuan Pembatalan</h3>
        <div class="text-sm text-gray-700 space-y-3 mb-6 max-h-60 overflow-y-auto">
            <p>1. Pembatalan hanya dapat dilakukan sebelum tanggal sewa dimulai.</p>
            <p>2. Pembatalan pada hari H (tanggal sewa) tidak dapat dilakukan dan tidak ada pengembalian dana.</p>
            <p>3. Pengembalian dana tidak dilakukan secara penuh. Pengguna hanya menerima 80% dari total pembayaran sebagai pengembalian.</p>
            <p>4. Proses pengembalian membutuhkan waktu maksimal 3 hari kerja.</p>
            <p>5. Dengan melanjutkan, Anda menyetujui syarat dan ketentuan di atas.</p>
        </div>
        <div class="flex justify-end space-x-4">
            <button id="batal-syarat" type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
            <button id="submit-konfirmasi" type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                Setuju & Konfirmasi Pembayaran
            </button>
        </div>
    </div>
</div>

        </form>
    </div>


    <!-- Modal -->
<div id="modal-konfirmasi" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
        <p class="mb-6">Apakah Anda yakin ingin kembali ke form pemesanan? Data yang belum disimpan bisa hilang.</p>
        <div class="flex justify-end space-x-4">
            <button id="modal-batal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Tidak</button>
            <a href="{{ route('pemesanan.form', ['mobil' => $pemesanan->mobil->id]) }}" 
               class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                Ya
            </a>
        </div>
    </div>
</div>


    <script>
        function handleMetodeChange(value) {
            document.getElementById('instruksi-cod').style.display = 'none';
            document.getElementById('instruksi-ewallet').style.display = 'none';
            document.getElementById('instruksi-transfer').style.display = 'none';

            if (value === 'cod') {
                document.getElementById('instruksi-cod').style.display = 'block';
            } else if (value === 'ewallet') {
                document.getElementById('instruksi-ewallet').style.display = 'block';
            } else if (value === 'transfer') {
                document.getElementById('instruksi-transfer').style.display = 'block';
            }
        }

        // Ambil elemen tombol dan modal
    const btnKembali = document.getElementById('btn-kembali');
    const modal = document.getElementById('modal-konfirmasi');
    const modalBatal = document.getElementById('modal-batal');

    // Klik tombol kembali: tampilkan modal
    btnKembali.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Klik tombol batal di modal: sembunyikan modal
    modalBatal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Klik di luar modal untuk tutup modal (opsional)
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
    </script>

    <script>
    // Modal metode pembayaran (sudah ada)
    // ...

    // Modal syarat & ketentuan
    const btnKonfirmasi = document.getElementById('btn-konfirmasi');
    const modalSyarat = document.getElementById('modal-syarat');
    const batalSyarat = document.getElementById('batal-syarat');

    btnKonfirmasi.addEventListener('click', () => {
        modalSyarat.classList.remove('hidden');
    });

    batalSyarat.addEventListener('click', () => {
        modalSyarat.classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
        if (e.target === modalSyarat) {
            modalSyarat.classList.add('hidden');
        }
    });
</script>

</x-app-layout>
