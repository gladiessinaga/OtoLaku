<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            Daftar Pengguna Terdaftar
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm">
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Nama</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Nomor HP</th>
                                <th class="border px-4 py-2 text-left">Tanggal Daftar</th>
                                <th class="border px-4 py-2 text-center">Hapus</th>
                                <th class="border px-4 py-2 text-center">Blokir</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-100">
    @forelse($users as $i => $user)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="border px-4 py-2">{{ $i + 1 }}</td>
            <td class="border px-4 py-2">{{ $user->name }}</td>
            <td class="border px-4 py-2">{{ $user->email }}</td>
            <td class="border px-4 py-2">{{ $user->no_hp ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>

            {{-- Tombol Hapus --}}
            <td class="border px-4 py-2 text-center">
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin ingin menghapus pengguna ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                        Hapus
                    </button>
                </form>
            </td>

            {{-- Tombol Blokir / Buka Blokir --}}
            <td class="border px-4 py-2 text-center">
                <form action="{{ route('admin.users.toggleBlock', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('{{ $user->is_blocked ? 'Yakin ingin membuka blokir?' : 'Yakin ingin memblokir pengguna ini?' }}')"
                        class="{{ $user->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-yellow-500 hover:bg-yellow-600' }} text-white px-3 py-1 rounded text-sm">
                        {{ $user->is_blocked ? 'Buka Blokir' : 'Blokir' }}
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-4 text-gray-600 dark:text-gray-300">Belum ada pengguna.</td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
