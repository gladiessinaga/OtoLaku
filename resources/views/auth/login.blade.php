<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- SweetAlert2 Notifikasi Sukses Login -->
    @if(session('login_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('login_success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif


    <form method="POST" action="{{ route('login') }}" id="loginForm" onsubmit="return validateAndShowLoading()">
        @csrf
        <!-- Google reCAPTCHA -->
        <div style="width: 320px; margin-bottom: 1rem;">
        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
    </div>

    @error('g-recaptcha-response')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror
        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          class="block mt-1 w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username"
                          aria-describedby="email-error" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
        </div>

        

        <!-- Password -->
<div class="mb-4 relative">
    <x-input-label for="password" :value="__('Password')" />
    <input id="password"
           type="password"
           name="password"
           required
           autocomplete="current-password"
           aria-describedby="password-error"
           class="block mt-1 w-full pr-10 focus:ring-2 focus:ring-indigo-500 focus:outline-none border-gray-300 rounded-md shadow-sm" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />

    <!-- Eye icon -->
    <button type="button" id="togglePassword"
            class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 focus:outline-none">
        👁️
    </button>
</div>


        <!-- Terms and Conditions Checkbox -->
        <div class="mb-4">
            <label for="terms" class="inline-flex items-center cursor-pointer select-none">
                <input type="checkbox" id="terms" name="terms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required aria-describedby="terms-error" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    Saya setuju dengan 
                    <button type="button" id="openTermsBtn" class="underline text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
                        Syarat dan Ketentuan
                    </button>
                </span>
            </label>
            <p class="text-red-600 text-sm mt-1 hidden" id="terms-error">Anda harus menyetujui syarat dan ketentuan.</p>
        </div>

        <!-- Remember Me -->
        <div class="block mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button with Loading Spinner -->
        <div class="flex items-center justify-end">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 me-4"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif


            <button type="submit" 
                    id="submitBtn"
                    class="relative inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                <svg id="loadingSpinner" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <!-- Modal Terms and Conditions -->
    <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-3xl mx-4 p-6 relative shadow-lg overflow-y-auto max-h-[80vh]">
            <h2 class="text-2xl font-semibold mb-4">Syarat dan Ketentuan</h2>
            <div class="text-sm text-gray-700 dark:text-gray-300 mb-6 overflow-y-auto max-h-64">
                <p>Isi syarat dan ketentuan lengkap di sini...</p>
                <p>Contoh: Penggunaan aplikasi ini tunduk pada aturan yang berlaku, jangan membagikan password, dsb.</p>
            </div>
            <button id="closeTermsBtn" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Tutup
            </button>
        </div>
    </div>

    


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const termsModal = document.getElementById('termsModal');
        const openTermsBtn = document.getElementById('openTermsBtn');
        const closeTermsBtn = document.getElementById('closeTermsBtn');
        const termsCheckbox = document.getElementById('terms');
        const termsError = document.getElementById('terms-error');

        openTermsBtn.addEventListener('click', () => {
            termsModal.classList.remove('hidden');
            termsModal.classList.add('flex');
        });

        closeTermsBtn.addEventListener('click', () => {
            termsModal.classList.remove('flex');
            termsModal.classList.add('hidden');
        });

        function validateAndShowLoading() {
            if (!termsCheckbox.checked) {
                termsError.classList.remove('hidden');
                termsCheckbox.focus();
                return false;
            } else {
                termsError.classList.add('hidden');
            }
            document.getElementById('loadingSpinner').classList.remove('hidden');
            document.getElementById('submitBtn').disabled = true;
            return true;
        }
    </script>

    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        togglePassword.textContent = isPassword ? '🙈' : '👁️';
    });
</script>
</x-guest-layout>
