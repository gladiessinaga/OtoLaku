<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Permintaan Pembatalan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($pembatalans->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">Belum ada permintaan pembatalan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 text-sm uppercase">
                                    <th class="p-3">No</th>
                                    <th class="p-3">Nama Penyewa</th>
                                    <th class="p-3">Mobil</th>
                                    <th class="p-3">Alasan</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 dark:text-gray-100">
                                @foreach ($pembatalans as $index => $pembatalan)
                                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="p-3">{{ $index + 1 }}</td>
                                        <td class="p-3">{{ $pembatalan->pemesanan->user->name }}</td>
                                        <td class="p-3">{{ $pembatalan->pemesanan->mobil->nama_mobil }}</td>
                                        <td class="p-3">{{ $pembatalan->alasan }}</td>
                                        <td class="p-3">
                                            @if($pembatalan->status === 'pending')
                                                <span class="px-2 py-1 text-sm rounded bg-yellow-500 text-white font-semibold">Menunggu</span>
                                            @elseif($pembatalan->status === 'disetujui')
                                                <span class="px-2 py-1 text-sm rounded bg-green-600 text-white font-semibold">Disetujui</span>
                                            @elseif($pembatalan->status === 'ditolak')
                                                <span class="px-2 py-1 text-sm rounded bg-red-600 text-white font-semibold">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            @if($pembatalan->status === 'pending')
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('admin.pembatalan.approve', $pembatalan->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.pembatalan.reject', $pembatalan->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400 italic">Tidak ada aksi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SweetAlert Success --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>
    @endif
</x-app-layout>
