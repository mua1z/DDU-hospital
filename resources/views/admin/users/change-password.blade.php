@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Change Password for {{ $user->name }} ({{ $user->dduc_id }})</h2>

        <form method="POST" action="{{ route('admin.users.change-password', $user) }}">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                </div>

                <div>
                    <x-primary-button>Change Password</x-primary-button>
                    <a href="{{ route('admin.users.index') }}" class="ms-4 text-sm text-gray-600 dark:text-gray-400">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
