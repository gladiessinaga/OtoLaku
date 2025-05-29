<x-app-layout>
    <x-slot name="header">
        {{-- Judul halaman bisa kamu isi jika perlu --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-2xl font-bold mb-6">Notifikasi Kamu</h1>

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Jika tidak ada notifikasi --}}
                    @if($notifications->isEmpty())
                        <p class="text-gray-600">Tidak ada notifikasi.</p>
                    @else
                        {{-- Tombol tandai semua sudah dibaca --}}
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="mb-6">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                                Tandai Semua Sudah Dibaca
                            </button>
                        </form>

                        {{-- Daftar notifikasi --}}
                        <ul class="space-y-4">
                            @foreach($notifications as $notification)
                                <li class="p-4 rounded border {{ $notification->read_at ? 'bg-white' : 'bg-green-50 font-semibold' }}">
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="text-gray-800 hover:text-green-700">
                                        {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                                    </a>
                                    <br>
                                    <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>

                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline-block ml-4">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm underline">
                                                Tandai sudah dibaca
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
