<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerForm" onsubmit="return validateRegisterForm()">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nomor HP -->
        <div class="mb-4">
            <x-input-label for="no_hp" :value="__('Nomor HP')" />
            <x-text-input id="no_hp" class="block mt-1 w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                type="text" name="no_hp" :value="old('no_hp')" required autocomplete="tel" placeholder="08xxxxxxxxxx" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none" type="email" name="email" :value="old('email')" required autocomplete="username" aria-describedby="email-error" />
            <div id="email-error" class="text-red-600 text-sm mt-1"></div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4 relative">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full pr-10 focus:ring-2 focus:ring-indigo-500 focus:outline-none" type="password" name="password" required autocomplete="new-password" aria-describedby="password-error" />
            <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 focus:outline-none">👁️</button>
            <div id="password-error" class="text-red-600 text-sm mt-1"></div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4 relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10 focus:ring-2 focus:ring-indigo-500 focus:outline-none" type="password" name="password_confirmation" required autocomplete="new-password" aria-describedby="confirm-password-error" />
            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 focus:outline-none">👁️</button>
            <div id="confirm-password-error" class="text-red-600 text-sm mt-1"></div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Checkbox -->
        <!-- Terms Checkbox -->
<div class="mb-4">
    <label for="terms" class="inline-flex items-center cursor-pointer select-none">
        <input type="checkbox" id="terms" name="terms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required aria-describedby="terms-error" />
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
            Saya setuju dengan 
            <button type="button" onclick="openTermsModal()" class="underline text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
                Syarat dan Ketentuan
            </button>
        </span>
    </label>
    <p class="text-red-600 text-sm mt-1 hidden" id="terms-error">Anda harus menyetujui syarat dan ketentuan.</p>
</div>


        <!-- Submit -->
        <div class="flex items-center justify-between">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Sudah terdaftar?') }}
            </a>

            <button type="submit" id="submitBtn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <!-- Modal Syarat dan Ketentuan -->
<div id="termsModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-11/12 max-w-2xl shadow-lg relative">
        <h2 class="text-xl font-semibold text-indigo-700 dark:text-indigo-400 mb-4">Syarat dan Ketentuan</h2>
        <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2 max-h-64 overflow-y-auto">
            <p>1. Pengguna harus memberikan informasi yang benar dan akurat saat melakukan pendaftaran.</p>
            <p>2. Setiap akun hanya boleh digunakan oleh satu orang dan tidak boleh dipinjamkan ke orang lain.</p>
            <p>3. Data pribadi Anda akan dijaga kerahasiaannya sesuai dengan kebijakan privasi kami.</p>
            <p>4. Pengguna tidak diperbolehkan menggunakan layanan untuk tujuan ilegal atau merugikan pihak lain.</p>
            <p>5. Pelanggaran terhadap syarat ini dapat mengakibatkan penangguhan atau penghapusan akun.</p>
            <p>6. Kami berhak mengubah syarat dan ketentuan sewaktu-waktu tanpa pemberitahuan terlebih dahulu.</p>
            <p>7. Dengan mendaftar, Anda menyetujui semua aturan yang berlaku dalam layanan kami.</p>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeTermsModal()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Tutup</button>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function openTermsModal() {
        document.getElementById('termsModal').classList.remove('hidden');
    }

    function closeTermsModal() {
        document.getElementById('termsModal').classList.add('hidden');
    }
    </script>

    @if(session('register_success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('register_success') }}',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        });
    </script>
    @endif

    <script>
        function validateRegisterForm() {
            let isValid = true;

            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const confirmPasswordError = document.getElementById('confirm-password-error');

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;

            emailError.textContent = '';
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';

            if (!emailRegex.test(emailInput.value)) {
                emailError.textContent = 'Format email tidak valid.';
                isValid = false;
            }

            if (!passwordRegex.test(passwordInput.value)) {
                passwordError.textContent = 'Password harus minimal 8 karakter, mengandung minimal 1 huruf kapital dan 1 karakter spesial.';
                isValid = false;
            }

            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordError.textContent = 'Konfirmasi password tidak cocok.';
                isValid = false;
            }

            const termsChecked = document.getElementById('terms').checked;
            const termsError = document.getElementById('terms-error');
            termsError.classList.add('hidden');

            if (!termsChecked) {
                termsError.classList.remove('hidden');
                isValid = false;
            }

            const phoneError = document.getElementById('phone-error');
            phoneError.textContent = '';
            if (!/^08[0-9]{8,11}$/.test(phoneInput.value)) {
                isValid = false;
                phoneInput.classList.add('border-red-500');
                phoneError.textContent = 'Nomor HP tidak valid. Harus diawali 08 dan berisi 10–13 digit.';
            }


            return isValid;
        }

        function togglePassword(fieldId, iconElement) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";
            iconElement.textContent = isPassword ? "🙈" : "👁️";
        }
    </script>
</x-guest-layout>
