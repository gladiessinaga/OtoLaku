<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Laporan Masalah</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Notifikasi sukses --}}
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-left text-sm font-medium text-gray-700">
                                <th class="py-3 px-4">User</th>
                                <th class="py-3 px-4">No Telepon</th>
                                <th class="py-3 px-4">Deskripsi</th>
                                <th class="py-3 px-4">Foto</th>
                                <th class="py-3 px-4">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse ($laporan as $item)
                                <tr class="border-t">
                                    <td class="py-3 px-4">{{ $item->user->name ?? 'Unknown' }}</td>
                                    <td class="py-3 px-4">{{ $item->user->no_hp ?? 'Unknown' }}</td>
                                    <td class="py-3 px-4">{{ $item->deskripsi }}</td>
                                    <td class="py-3 px-4">
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan" class="w-20 h-20 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-gray-500">Tidak ada laporan masalah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
