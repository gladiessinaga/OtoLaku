<footer class="bg-myprimary dark:bg-myprimary-900 text-gray-700 text-white mt-10 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Tentang Kami -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Tentang Kami</h2>
            <p class="text-sm">
                Aplikasi Rental Mobil ini memudahkan Anda dalam menyewa kendaraan dengan cepat dan aman. Tersedia berbagai pilihan mobil sesuai kebutuhan Anda.
            </p>
        </div>

        <!-- Kontak -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Kontak</h2>  
            <p class="text-sm">Telepon: +62 821 2358 7938</p>
            <p class="text-sm">Alamat: Jl. Jenderal Sudirman  No 385, Kelurahan Kayu Embun, Kecamatan Padang Sidempuan Utara Kota Padang Sidempuan</p>
        </div>

        <!-- Sosial Media -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Ikuti Kami</h2>
            <ul class="flex gap-4 text-sm">
                <li><a href="#" class="hover:underline">Instagram</a></li>
                <li><a href="#" class="hover:underline">Facebook</a></li>
                <li><a href="#" class="hover:underline">Twitter</a></li>
            </ul>
        </div>

        <!-- Navigasi Tambahan -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Tautan Cepat</h2>
            <ul class="text-sm space-y-2">
                <li><a href="{{ route('faq') }}" class="hover:underline">FAQ</a></li>
                <li><a href="{{ route('user.lapor-masalah') }}" class="hover:underline">Lapor Masalah</a></li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard Admin</a></li>
                    @elseif(auth()->user()->role === 'user')
                        <li><a href="{{ route('user.dashboard') }}" class="hover:underline">Dashboard User</a></li>
                    @endif
                @else
                    <li><a href="{{ route('login') }}" class="hover:underline">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:underline">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>

    <div class="bg-gray-200 dark:bg-gray-800 text-center text-sm text-gray-600 dark:text-gray-400 py-4">
        &copy; {{ date('Y') }} Aplikasi Rental Mobil. All rights reserved.
    </div>
</footer>
