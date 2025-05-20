<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Pembayaran
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10 px-6">
        <div class="bg-white shadow rounded p-6 text-center">
            <h3 class="text-lg font-semibold mb-4 text-green-600">Terima kasih!</h3>
            <p class="mb-2">Pembayaran Anda untuk mobil <strong>{{ $pemesanan->mobil->nama }}</strong> telah kami terima.</p>
            <p class="mb-2">Metode: <strong>{{ strtoupper($pemesanan->metode_pembayaran) }}</strong></p>
            <p class="mb-4">Admin akan memverifikasi pembayaran Anda dalam waktu maksimal 1x24 jam.</p>
            <a href="{{ route('user.dashboard') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
