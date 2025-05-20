<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Status Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Status Pemesanan User</h1>

            @if ($pemesanan && $pemesanan->mobil)
                <div class="border rounded-lg p-6 shadow bg-white space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $pemesanan->mobil->nama }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($pemesanan->status == 'terverifikasi') bg-green-100 text-green-800
                            @elseif($pemesanan->status == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                            @elseif($pemesanan->status == 'dibatalkan') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst(str_replace('_', ' ', $pemesanan->status)) }}
                        </span>
                    </div>

                    <div class="text-gray-700 space-y-2">
                        <p><strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }}</p>
                        <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
                        <p><strong>Opsi Sopir:</strong> {{ ucfirst($pemesanan->opsi_sopir) }}</p>
                        <p><strong>Metode Pengambilan:</strong> {{ ucfirst($pemesanan->pengambilan) }}</p>
                        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($pemesanan->metode_pembayaran) }}</p>
                    </div>

                    <div class="text-gray-700 space-y-2">
                        <p><strong>KTP:</strong>
                            @if($pemesanan->ktp)
                                <a href="{{ asset('storage/' . $pemesanan->ktp) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                            @else
                                <span class="text-red-500">Belum diunggah</span>
                            @endif
                        </p>
                        <p><strong>SIM:</strong>
                            @if($pemesanan->sim)
                                <a href="{{ asset('storage/' . $pemesanan->sim) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                            @else
                                <span class="text-red-500">Belum diunggah</span>
                            @endif
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-500">Data tidak ditemukan</p>
            @endif  
        </div>
    </div>
</x-app-layout>
