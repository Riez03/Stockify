@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="p-4 my-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    <x-alert-error-form />
                    <div class="mb-5">
                        <label for="name" class="after:content-['*'] after:text-red-600 after:ml-1 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic" required />
                    </div>
                    <div class="mb-5">
                        <label for="email" class="after:content-['*'] after:text-red-600 after:ml-1 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic"  />
                    </div>
                    <div class="mb-5">
                        <label for="address" class="after:content-['*'] after:text-red-600 after:ml-1 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" id="password" name="password" value="{{ $user->password }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:italic"  />
                        <div class="mt-2">
                            <input type="checkbox" id="show-password" class="rounded-full" onclick="togglePassword()" />
                            <label for="show-password" class="text-xs font-medium text-gray-600 dark:text-gray-400 cursor-pointer">Show Password</label>
                        </div>
                    </div>
                    <div class="mb-5">
                        <x-form.select-option name="role" label="Role" placeholder="Select Role" required>
                            <option value="Admin" {{ $user->role ? 'selected' : '' }}>Admin</option>
                            <option value="Manajer Gudang" {{ $user->role ? 'selected' : '' }}>Manajer Gudang</option>
                            <option value="Staff Gudang" {{ $user->role ? 'selected' : '' }}>Staff Gudang</option>
                        </x-form.select-option>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </section>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const checkbox = document.getElementById('show-password');
            passwordField.type = checkbox.checked ? 'text' : 'password';
        }
    </script>
@endsection
