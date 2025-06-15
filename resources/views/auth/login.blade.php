<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
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
        {{-- <!-- Google reCAPTCHA -->
        <div style="width: 320px; margin-bottom: 1rem;">
        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
    </div> --}}

    {{-- @error('g-recaptcha-response')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror --}}

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          class="block mt-1 w-full focus:ring-2 focus:ring-[#3b465a] focus:outline-none" 
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
           class="block mt-1 w-full pr-10 focus:ring-2 focus:ring-[#3b465a] focus:outline-none border-gray-300 rounded-md shadow-sm" />
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
                <input type="checkbox" id="terms" name="terms" class="rounded border-gray-300 text-[#3b465a]     shadow-sm focus:ring-[#3b465a]" required aria-describedby="terms-error" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    Saya setuju dengan 
                    <button type="button" id="openTermsBtn" class="underline text-[#3b465a] hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
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
                       class="rounded border-gray-300 text-[#3b465a] shadow-sm focus:ring-[#3b465a]" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <!-- Submit Button with Loading Spinner -->
        <div class="flex items-center justify-end">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-primary-600 dark:text-primary hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 me-4"
                   href="{{ route('password.request') }}">
                    {{ __('Lupa Password Anda?') }}
                </a>
            @endif


            <button type="submit" 
                    id="submitBtn"
                    class="relative inline-flex items-center px-4 py-2 bg-[#46556D] hover:bg-[#3b465a] border border-transparent rounded-md font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
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
                <p>Jaga kerahasiaan informasi login (email dan password). Segala aktivitas yang terjadi di akun Anda menjadi tanggung jawab pemilik akun.</p>
                <p>Jika terdapat indikasi penyalahgunaan akun, segera hubungi admin aplikasi.</p>
            </div>
            <button id="closeTermsBtn" class="mt-4 px-4 py-2 bg-[#3b465a] text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-[#3b465a]">
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

{{-- regex --}}
<script>
function validateEmail(email) {
    // Regex standar email
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    // Password minimal 8 karakter, harus ada huruf besar, huruf kecil, dan angka
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return re.test(password);
}

function validateAndShowLoading() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const termsCheckbox = document.getElementById('terms');
    let isValid = true;

    // Validasi Email
    if (!validateEmail(emailInput.value)) {
        document.getElementById('email-error').innerHTML = '<p class="text-red-600 text-sm mt-1">Format email tidak valid.</p>';
        isValid = false;
    } else {
        document.getElementById('email-error').innerHTML = '';
    }

    // Validasi Password
    if (!validatePassword(passwordInput.value)) {
        document.getElementById('password-error').innerHTML = '<p class="text-red-600 text-sm mt-1">Password minimal 6 karakter, mengandung huruf besar, kecil, dan angka.</p>';
        isValid = false;
    } else {
        document.getElementById('password-error').innerHTML = '';
    }

    // Validasi Terms
    if (!termsCheckbox.checked) {
        document.getElementById('terms-error').classList.remove('hidden');
        termsCheckbox.focus();
        isValid = false;
    } else {
        document.getElementById('terms-error').classList.add('hidden');
    }

    // Tampilkan loading spinner jika semua valid
    if (isValid) {
        document.getElementById('loadingSpinner').classList.remove('hidden');
        document.getElementById('submitBtn').disabled = true;
    }

    return isValid;
}
</script>

{{-- remember --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const rememberMe = document.getElementById('remember_me');

    // Load email if stored
    if (localStorage.getItem('remembered_email')) {
        emailInput.value = localStorage.getItem('remembered_email');
        rememberMe.checked = true;
    }

    document.getElementById('loginForm').addEventListener('submit', () => {
        if (rememberMe.checked) {
            localStorage.setItem('remembered_email', emailInput.value);
        } else {
            localStorage.removeItem('remembered_email');
        }
    });
});
</script>

</x-guest-layout>
