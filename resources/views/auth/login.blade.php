<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Masuk ke Back2Me</h2>
        <p class="text-sm text-slate-600 mt-1">Sistem Lost & Found Kampus</p>
    </div>

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

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-between mt-4 text-sm">
            @if (Route::has('password.request'))
                <a class="text-indigo-600 hover:text-indigo-800 font-medium" href="{{ route('password.request') }}">
                    <i class='bx bx-key'></i> {{ __('Lupa Password?') }}
                </a>
            @endif

            @if (Route::has('register'))
                <a class="text-indigo-600 hover:text-indigo-800 font-medium" href="{{ route('register') }}">
                    <i class='bx bx-user-plus'></i> {{ __('Daftar Akun Baru') }}
                </a>
            @endif
        </div>
    </form>

    <!-- Testing Accounts Info -->
    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-xs font-semibold text-blue-900 mb-2">🧪 Akun Testing:</p>
        <div class="text-xs text-blue-800 space-y-1">
            <div><strong>SuperAdmin:</strong> admin@back2me.test / password123</div>
            <div><strong>Petugas:</strong> petugas@back2me.test / password123</div>
            <div><strong>User:</strong> budi@back2me.test / password123</div>
        </div>
    </div>
</x-guest-layout>
