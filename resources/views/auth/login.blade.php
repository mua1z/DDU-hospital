<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-center text-2xl font-bold text-[#0e3b63] mb-6">{{ __('Login to DDU Clinic') }}</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Username (DDUC ID) -->
        <div>
            <label for="dduc_id" class="block text-gray-800 font-bold mb-2">{{ __('Username') }}:</label>
            <input id="dduc_id" type="text" name="dduc_id" value="{{ old('dduc_id') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0e3b63]"
                placeholder="{{ __('Enter your username') }}">
            <x-input-error :messages="$errors->get('dduc_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-gray-800 font-bold mb-2">{{ __('Password') }}:</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0e3b63]"
                placeholder="{{ __('Enter your password') }}">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Login Button -->
        <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md transition duration-200 mt-6">
            {{ __('Login') }}
        </button>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <div class="text-center mt-4">
                <a class="text-[#0e3b63] hover:underline text-sm" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            </div>
        @endif

        <div class="text-center mt-4 border-t pt-4">
            <a href="/" class="text-gray-600 hover:text-gray-900 text-sm flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Home') }}
            </a>
        </div>
    </form>
</x-guest-layout>