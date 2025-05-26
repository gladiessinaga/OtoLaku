<x-app-layout>
    <x-slot name="header">
        <h2>Daftar Laporan Masalah</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">User</th>
                    <th class="border border-gray-300 p-2">Deskripsi</th>
                    <th class="border border-gray-300 p-2">Foto</th>
                    <th class="border border-gray-300 p-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $item->user->name ?? 'Unknown' }}</td>
                        <td class="border border-gray-300 p-2">{{ $item->deskripsi }}</td>
                        <td class="border border-gray-300 p-2">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan" class="w-20 h-20 object-cover">
                            @else
                                -
                            @endif
                        </td>
                        <td class="border border-gray-300 p-2">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
