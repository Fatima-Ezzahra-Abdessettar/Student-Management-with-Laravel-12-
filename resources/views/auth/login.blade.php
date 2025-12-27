<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" id="google-login-btn" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.013-1.147 8.027-3.24 2.053-2.053 2.72-5.133 2.72-7.56 0-.52-.053-1.04-.133-1.52h-10.613z" />
                </svg>
                <span class="ml-3">Sign in with Google</span>
            </button>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-auth.js";

        // Your web app's Firebase configuration
        // Load from .env via blade if possible, or expect user to fill this
        const firebaseConfig = {
            apiKey: "AIzaSyCHRUmdwQPnGl5BnEbYeB_R_6ILVGvOkT0",
            authDomain: "gestionetudiantslaravel12.firebaseapp.com",
            projectId: "gestionetudiantslaravel12",
            storageBucket: "gestionetudiantslaravel12.firebasestorage.app",
            messagingSenderId: "956051501494",
            appId: "1:956051501494:web:1c368ae2a64a5a72725117",
            measurementId: "G-TYZPCSCTNR"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        document.getElementById('google-login-btn').addEventListener('click', () => {
             // Basic validation to check if config is present
             if (!firebaseConfig.apiKey) {
                 alert('Firebase configuration is missing in .env');
                 return;
             }

             signInWithPopup(auth, provider)
            .then((result) => {
                const user = result.user;
                
                // Get the ID token
                user.getIdToken().then((idToken) => {
                    // Send token to backend
                    fetch('{{ route("google.callback") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            idToken: idToken
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.href = data.redirect_url;
                        } else {
                            alert('Login failed');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred during backend authentication.');
                    });
                });

            }).catch((error) => {
                const errorCode = error.code;
                const errorMessage = error.message;
                console.error(errorCode, errorMessage);
                alert('Google Sign In Failed: ' + errorMessage);
            });
        });
    </script>
</x-guest-layout>
