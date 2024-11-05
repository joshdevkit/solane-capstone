<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="grid grid-cols-1 mb-6">
        <h1 class="text-4xl font-bold">Sign in</h1>
        <p class="text-lg mt-2">Stay updated on your professional world</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-text-input id="email" class="block mt-1 w-full py-4" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" placeholder="Email or Phone" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full py-4" type="password" name="password" required
                autocomplete="current-password" placeholder="Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-start mt-4">
            @if (Route::has('password.request'))
                <a class="text-lg text-blue-600 mb-3 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white py-4 rounded-full w-full">Login</button>
        </div>

        <div class="w-full mt-6 flex justify-center">
            <a href="{{ route('auto-login') }}"
                class="px-6 py-3 bg-blue-500 text-white font-semibold text-lg rounded-lg shadow-lg hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 ease-in-out">
                Login as Admin
            </a>
        </div>

    </form>
</x-guest-layout>
