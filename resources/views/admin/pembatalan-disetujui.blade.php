<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Pembatalan Disetujui</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($pembatalans as $pembatalan)
                @php
                    $pemesanan = $pembatalan->pemesanan;
                    $mobil = $pemesanan->mobil;
                    $user = $pemesanan->user;
                    $biayaSupir = $pemesanan->pakai_supir ? 200000 : 0;
                    $subtotal = $mobil->harga * $pemesanan->durasi;
                    $total = $subtotal + $biayaSupir;
                @endphp

                <div class="bg-white rounded shadow p-6 mb-6">
                    <h3 class="text-lg font-bold mb-2">Pemesanan oleh {{ $user->name }}</h3>
                    <p><strong>Mobil:</strong> {{ $mobil->nama }}</p>
                    <p><strong>Nama Penyewa:</strong> {{ $user->name }}</p>
                    <p><strong>No HP Penyewa:</strong> {{ $user->no_hp }}</p>
                    <p><strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }}</p>
                    <p><strong>Alamat:</strong> {{ $pemesanan->alamat_pengantaran}}</p>
                    <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
                    <p><strong>Total:</strong> Rp{{ number_format($total, 0, ',', '.') }}</p>
                    <p><strong>Status Refund:</strong>
                        @if ($pembatalan->refund_status === 'sudah')
                            <span class="text-green-600 font-semibold">Sudah Dikembalikan</span>
                        @else
                            <span class="text-red-600 font-semibold">Belum</span>
                        @endif
                    </p>

                    @if ($pembatalan->refund_status === 'belum')
                        <form action="{{ route('admin.proses.refund', $pembatalan->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-2">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Upload Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" accept="image/*" class="block w-full border p-1 rounded">

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Proses Refund
                            </button>
                        </form>
                    @else
                       <div class="py-10 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('admin.proses.refund', $pembatalan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <label class="block text-sm font-medium text-gray-700">Upload Bukti Transfer</label>
                <input type="file" name="bukti_transfer" accept="image/*" required
                    class="block w-full border border-gray-300 bg-white p-2 rounded shadow-sm
                    focus:outline-none focus:ring focus:border-blue-300 @error('bukti_transfer') border-red-500 @enderror">

                @error('bukti_transfer')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button type="submit" 
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
            </form>
        </div>
    </div>

                    @endif
                    
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
