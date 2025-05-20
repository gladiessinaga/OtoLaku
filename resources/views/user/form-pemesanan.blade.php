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

    <div class="max-w-4xl mx-auto py-10 px-6">
        <h3 class="text-2xl font-bold mb-4">{{ $mobil->nama }}</h3>
        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama }}" class="w-full h-52 object-cover rounded mb-6">
        <p class="mb-2 text-gray-700">{{ $mobil->deskripsi_lengkap }}</p>
        <p class="text-green-600 font-bold mb-6">Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari</p>

        <form action="{{ route('pemesanan.store', $mobil->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Tanggal Sewa</label>
                <input type="date" name="tanggal_sewa" id="tanggalSewa" class="w-full border rounded px-3 py-2" required min="">
                <p id="peringatanTanggal" class="text-sm text-red-600 mt-1 hidden">Tanggal sewa harus dimulai dari besok.</p>
            </div>

            <div>
                <label class="block font-medium mb-1">Durasi (hari)</label>
                <div class="flex items-center gap-2">
                    <button type="button" id="minusDurasi" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">-</button>
                    <input type="number" id="durasiInput" name="durasi" class="w-20 text-center border rounded px-3 py-2" value="1" min="1" readonly>
                    <button type="button" id="plusDurasi" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">+</button>
                </div>
                <p class="mt-2 font-semibold text-green-700">Total Harga: Rp <span id="totalHarga">{{ number_format($mobil->harga, 0, ',', '.') }}</span></p>
            </div>


            <div>
                <label class="block font-medium">Opsi Sopir</label>
                <select name="opsi_sopir" class="w-full border rounded px-3 py-2">
                    <option value="tanpa">Tanpa Sopir</option>
                    <option value="dengan">Dengan Sopir</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Tujuan Penggunaan</label>
                <select name="tujuan_penggunaan" class="w-full border rounded px-3 py-2">
                    <option value="pribadi">Keperluan Pribadi</option>
                    <option value="dinas">Dinas / Bisnis</option>
                    <option value="liburan">Liburan</option>
                    <option value="keluarga">Acara Keluarga</option>
                </select>
            </div>


            <div>
                <label class="block font-medium">Sistem Pengambilan</label>
                <select name="pengambilan" class="w-full border rounded px-3 py-2">
                    <option value="antar">Diantar ke Lokasi</option>
                    <option value="ambil">Ambil di Tempat</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Upload KTP</label>
                <input type="file" name="ktp" class="w-full" required>
            </div>

            <div>
                <label class="block font-medium">Upload SIM</label>
                <input type="file" name="sim" class="w-full" required>
            </div>


            <div class="flex justify-between mt-6">
                <button type="button" id="btnBatal" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Batalkan</button>

            <div class="text-right">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lanjut ke Pembayaran</button>
            </div>
        </form>

        <div id="modalKonfirmasiBatal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full text-center relative">
                <h3 class="text-lg font-semibold mb-4">Yakin ingin membatalkan pemesanan?</h3>
                <div class="flex justify-center gap-4">
                    <button id="confirmBatal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, batal</button>
                    <button id="cancelBatal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Tidak</button>
                </div>
            </div>
        </div>


        <script>
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
                // aksi saat batal, misal redirect ke dashboard
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


    document.addEventListener('DOMContentLoaded', function () {
    // Atur tanggal minimum ke besok
    const tanggalSewaInput = document.getElementById('tanggalSewa');
    const peringatanTanggal = document.getElementById('peringatanTanggal');
    
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);

    const yyyy = tomorrow.getFullYear();
    const mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
    const dd = String(tomorrow.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    tanggalSewaInput.min = minDate;

    // Validasi saat user mengubah tanggal
    tanggalSewaInput.addEventListener('change', function () {
        if (tanggalSewaInput.value < minDate) {
            peringatanTanggal.classList.remove('hidden');
            tanggalSewaInput.value = ""; // reset input agar user isi ulang
        } else {
            peringatanTanggal.classList.add('hidden');
        }
    });

    // Tetap update harga saat halaman load
    updateHarga();
});


        </script>


    </div>
</x-app-layout>
