<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Pengguna Terdaftar
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    <th class="border px-4 py-2">No</th>
                                    <th class="border px-4 py-2">Nama</th>
                                    <th class="border px-4 py-2">Email</th>
                                    <th class="border px-4 py-2">Nomor HP</th>
                                    <th class="border px-4 py-2">Tanggal Daftar</th>
                                    <th class="border px-4 py-2">Hapus</th>
                                    <th class="border px-4 py-2">Blokir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $i => $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border px-4 py-2">{{ $i + 1 }}</td>
                                        <td class="border px-4 py-2">{{ $user->name }}</td>
                                        <td class="border px-4 py-2">{{ $user->email }}</td>
                                        <td class="border px-4 py-2">{{ $user->no_hp ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>

                                        {{-- Tombol Hapus --}}
                                        <td class="border px-4 py-2 text-center">
                                            <form method="POST" action="#">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm cursor-not-allowed opacity-50" disabled>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Tombol Blokir --}}
                                        <td class="border px-4 py-2 text-center">
                                            <form method="POST" action="#">
                                                @csrf
                                                <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm cursor-not-allowed opacity-50" disabled>
                                                    Blokir
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
    </div>
</x-app-layout>
