<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengembalian Uang
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Detail Pengembalian Uang</h1>

                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Mobil:</strong> {{ $pemesanan->mobil->nama }}</p>
                        <p><strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }}</p>
                        <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
                        <p><strong>Status:</strong>
                            <span class="text-red-600 font-semibold">Dibatalkan</span>
                        </p>
                        @php
                            $biayaSupir = $pemesanan->pakai_supir ? 200000 : 0;
                            $subtotal = $pemesanan->mobil->harga * $pemesanan->durasi;
                            $totalHarga = $subtotal + $biayaSupir;
                        @endphp
                        <p><strong>Total Harga:</strong> Rp{{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>

                    <hr class="my-4">

                    <p class="text-gray-600 text-sm">
                        Admin akan memproses pengembalian dana ke metode pembayaran yang digunakan saat pemesanan.
                        Mohon tunggu maksimal <strong>2x24 jam</strong> sejak disetujui.
                    </p>

                    {{-- Cek apakah bukti transfer sudah diupload oleh admin --}}
                    @if ($pemesanan->pembatalan && $pemesanan->pembatalan->bukti_transfer)
                        <div class="mt-6">
                            <p class="text-sm text-gray-700 font-semibold">Bukti Transfer Refund:</p>
                            <img src="{{ asset('storage/' . $pemesanan->pembatalan->bukti_transfer) }}" alt="Bukti Transfer" class="w-60 mt-2 rounded shadow">
                        </div>
                    @else
                        <p class="mt-6 text-sm text-yellow-600 font-semibold">
                            Admin akan segera mengupload bukti transfer refund, silakan pantau dalam 2x24 jam.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
