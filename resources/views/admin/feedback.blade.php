<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Feedback User') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if($feedbacks->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Belum ada feedback.</p>
            @else
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-200 uppercase text-sm">
                            <th class="p-3">User</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Pesan</th>
                            <th class="p-3">Dikirim pada</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-100">
                        @foreach ($feedbacks as $fb)
                        <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-3">{{ $fb->user->name ?? 'User Tidak Dikenal' }}</td>
                            <td class="p-3 capitalize">{{ $fb->kategori }}</td>
                            <td class="p-3">{{ $fb->pesan }}</td>
                            <td class="p-3">{{ $fb->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
d