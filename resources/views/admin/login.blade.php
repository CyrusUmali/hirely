<x-layout>

    {{-- Admin Login Form --}}
    <x-card class="p-10 max-w-lg mx-auto mt-24">

        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Admin Login
            </h2>
            <p class="mb-4">Log in to your admin account</p>
        </header>

        <form method="POST" action="/admin/login">  {{-- Updated the action to /admin/login for admin authentication --}}
            @csrf

            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">
                    Name
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    value="{{ old('name') }}"
                />

                {{-- Displaying the Validation Errors --}}
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">
                    Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"
                    value="{{ old('password') }}"
                />

                {{-- Displaying the Validation Errors --}}
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button style="background-color: #1ab394;"
                    type="submit"
                    class=" text-white rounded py-2 px-4 hover:bg-black"
                >
                    Sign In
                </button>
            </div>

        </form>

    </x-card>

</x-layout>
