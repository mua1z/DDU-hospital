@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Edit User</h2>

        @if($errors->any())
            <div class="mb-4">
                <ul class="text-sm text-red-600">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="dduc_id" :value="__('DDUC ID')" />
                    <x-text-input id="dduc_id" name="dduc_id" class="mt-1 block w-full" value="{{ old('dduc_id', $user->dduc_id) }}" />
                    <x-input-error :messages="$errors->get('dduc_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <option {{ $user->role=='Admin' ? 'selected' : '' }}>Admin</option>
                        <option {{ $user->role=='Receptions' ? 'selected' : '' }}>Receptions</option>
                        <option {{ $user->role=='Doctors' ? 'selected' : '' }}>Doctors</option>
                        <option {{ $user->role=='Laboratory' ? 'selected' : '' }}>Laboratory</option>
                        <option {{ $user->role=='Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                        <option {{ $user->role=='User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ $user->is_active ? 'checked' : '' }} />
                    <label for="is_active" class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</label>
                </div>

                <div>
                    <x-primary-button>Save</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
