<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Pemesanan Mobil
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="mb-4 text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-2xl font-bold mb-4">{{ $mobil->nama }}</h3>
        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-52 object-cover rounded mb-6">
        <p class="mb-2 text-gray-700">{{ $mobil->deskripsi_lengkap }}</p>
        <p class="text-green-600 font-bold mb-6">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>

        <form action="{{ route('pemesanan.store', $mobil->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Tanggal Sewa -->
            <div>
                <label for="tanggal_sewa" class="block font-medium mb-1">Tanggal Sewa</label>
                <input type="text" id="tanggal_sewa" name="tanggal_sewa" class="form-input w-full border rounded px-3 py-2" required autocomplete="off" />
                <p id="peringatanTanggal" class="text-sm text-red-600 mt-1 hidden">Tanggal sewa harus dimulai dari hari ini atau setelahnya.</p>
                <p class="mt-2 text-sm text-gray-500">
                    <span class="inline-block w-3 h-3 bg-red-300 rounded-full mr-1 align-middle"></span> Tanggal tidak tersedia (sudah dipesan)
                </p>
            </div>

            <!-- Durasi Sewa -->
            <div>
                <label class="block font-medium mb-1">Durasi (hari)</label>
                <div class="flex items-center gap-2">
                    <button type="button" id="minusDurasi" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">-</button>
                    <input type="number" id="durasiInput" name="durasi" class="w-20 text-center border rounded px-3 py-2" value="1" min="1" readonly>
                    <button type="button" id="plusDurasi" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">+</button>
                </div>
                <p class="mt-2 font-semibold text-green-700">Total Harga: Rp <span id="totalHarga">{{ number_format($mobil->harga, 0, ',', '.') }}</span></p>
            </div>

            <!-- Opsi Sopir -->
            <div>
                <label for="opsi_sopir" class="block font-medium mb-1">Opsi Sopir</label>
                <select name="opsi_sopir" id="opsi_sopir" class="w-full border rounded px-3 py-2">
                    <option value="tanpa">Tanpa Sopir</option>
                    <option value="dengan">Dengan Sopir</option>
                </select>
            </div>

            <!-- Tujuan Penggunaan -->
            <div>
                <label for="tujuan_penggunaan" class="block font-medium mb-1">Tujuan Penggunaan</label>
                <select name="tujuan_penggunaan" id="tujuan_penggunaan" class="w-full border rounded px-3 py-2">
                    <option value="pribadi">Keperluan Pribadi</option>
                    <option value="dinas">Dinas / Bisnis</option>
                    <option value="liburan">Liburan</option>
                    <option value="keluarga">Acara Keluarga</option>
                </select>
            </div>

            <!-- Sistem Pengambilan -->
            <div>
                <label for="pengambilan" class="block font-medium mb-1">Sistem Pengambilan</label>
                <select name="pengambilan" id="pengambilan" class="w-full border rounded px-3 py-2">
                    <option value="antar">Diantar ke Lokasi</option>
                    <option value="ambil">Ambil di Tempat</option>
                </select>
            </div>

            <!-- Upload KTP -->
            <div>
                <label for="ktp" class="block font-medium mb-1">Upload KTP</label>
                <input type="file" name="ktp" id="ktp" class="w-full" required accept="image/*,application/pdf" />
            </div>

            <!-- Upload SIM -->
            <div>
                <label for="sim" class="block font-medium mb-1">Upload SIM</label>
                <input type="file" name="sim" id="sim" class="w-full" required accept="image/*,application/pdf" />
            </div>

            <!-- Tombol aksi -->
            <div class="flex justify-between mt-6">
                <button type="button" id="btnBatal" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Batalkan</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lanjut ke Pembayaran</button>
            </div>
        </form>

        <!-- Modal Konfirmasi Batal -->
        <div id="modalKonfirmasiBatal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full text-center relative">
                <h3 class="text-lg font-semibold mb-4">Yakin ingin membatalkan pemesanan?</h3>
                <div class="flex justify-center gap-4">
                    <button id="confirmBatal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, batal</button>
                    <button id="cancelBatal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Tidak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Styling tanggal tidak tersedia -->
    <style>
        .flatpickr-day.disabled-day {
            background-color: #fecaca !important; /* Merah muda */
            color: #b91c1c !important;            /* Merah tua */
            text-decoration: line-through;
            cursor: not-allowed;
        }
    </style>

    <script>
        const tanggalTerisi = @json($tanggalTerisi);

        flatpickr("#tanggal_sewa", {
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: tanggalTerisi,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj.toISOString().slice(0, 10);
                if (tanggalTerisi.includes(date)) {
                    dayElem.classList.add("disabled-day");
                    dayElem.setAttribute("title", "Tanggal sudah dipesan");
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                const peringatan = document.getElementById('peringatanTanggal');
                if (dateStr < instance.config.minDate) {
                    peringatan.classList.remove('hidden');
                    instance.clear();
                } else {
                    peringatan.classList.add('hidden');
                }
            }
        });

        const btnBatal = document.getElementById('btnBatal');
        const modalKonfirmasi = document.getElementById('modalKonfirmasiBatal');
        const confirmBatal = document.getElementById('confirmBatal');
        const cancelBatal = document.getElementById('cancelBatal');

        btnBatal.addEventListener('click', () => {
            modalKonfirmasi.classList.remove('hidden');
        });

        cancelBatal.addEventListener('click', () => {
            modalKonfirmasi.classList.add('hidden');
        });

        confirmBatal.addEventListener('click', () => {
            modalKonfirmasi.classList.add('hidden');
            window.location.href = "{{ route('user.dashboard') }}";
        });

        const hargaPerHari = {{ $mobil->harga }};
        const durasiInput = document.getElementById('durasiInput');
        const plusBtn = document.getElementById('plusDurasi');
        const minusBtn = document.getElementById('minusDurasi');
        const totalHarga = document.getElementById('totalHarga');

        function updateHarga() {
            const durasi = parseInt(durasiInput.value);
            const total = hargaPerHari * durasi;
            totalHarga.textContent = total.toLocaleString('id-ID');
        }

        plusBtn.addEventListener('click', () => {
            durasiInput.value = parseInt(durasiInput.value) + 1;
            updateHarga();
        });

        minusBtn.addEventListener('click', () => {
            if (parseInt(durasiInput.value) > 1) {
                durasiInput.value = parseInt(durasiInput.value) - 1;
                updateHarga();
            }
        });

        document.addEventListener('DOMContentLoaded', updateHarga);
    </script>

</x-app-layout>
