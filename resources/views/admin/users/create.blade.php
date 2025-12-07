@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Create User</h2>

        @if($errors->any())
            <div class="mb-4">
                <ul class="text-sm text-red-600">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name') }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="dduc_id" :value="__('DDUC ID')" />
                    <x-text-input id="dduc_id" name="dduc_id" class="mt-1 block w-full" value="{{ old('dduc_id') }}" />
                    <x-input-error :messages="$errors->get('dduc_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <option>Admin</option>
                        <option>Receptions</option>
                        <option>Doctors</option>
                        <option>Laboratory</option>
                        <option>Pharmacist</option>
                        <option selected>User</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    <label for="is_active" class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</label>
                </div>

                <div>
                    <x-primary-button>Create</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
