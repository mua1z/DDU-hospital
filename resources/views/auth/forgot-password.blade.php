<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? Enter your DDUC ID and we will send a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- DDUC ID -->
        <div>
            <x-input-label for="dduc_id" :value="__('DDUC ID')" />
            <x-text-input id="dduc_id" class="block mt-1 w-full" type="text" name="dduc_id" :value="old('dduc_id')" required autofocus />
            <x-input-error :messages="$errors->get('dduc_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
