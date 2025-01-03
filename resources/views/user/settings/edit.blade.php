<x-layout>
    <x-card class="p-10">

        {{-- Edit User Settings Section --}}
        <h1 class="text-3xl font-bold mb-6">Edit User Settings</h1>

        <form action="{{ url('/user/settings') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name Input --}}
            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lightseagreen-500"
                />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-lg font-medium text-gray-700">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lightseagreen-500"
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CV Section --}}
            <div class="flex items-center space-x-4 mb-6">  {{-- Added margin bottom here --}}
                <h3 class="text-lg font-medium text-gray-800">CV:</h3>
                @if ($user->cv_path)
                    {{-- Show download, edit, and delete options if CV exists --}}
                    <div class="flex space-x-4">
                        <a href="{{ url('/user/settings/download-cv') }}" class="text-white bg-blue-500 px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                            <i class="fa-solid fa-download"></i> Download CV
                        </a>

                        {{-- Edit CV Button --}}
                        <label for="cv-upload" class="text-white bg-green-500 px-6 py-2 rounded-lg cursor-pointer hover:bg-green-600 transition-colors duration-300">
                            <i class="fa-solid fa-edit"></i> Edit CV
                        </label>
                        <input type="file" id="cv-upload" name="cv" accept=".pdf,.doc,.docx" class="hidden" />

                        {{-- Delete CV Button --}}
                        <form action="{{ url('/user/settings/delete-cv') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your CV?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                                <i class="fa-solid fa-trash"></i> Delete CV
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Show upload option if CV does not exist --}}
                    <div class="flex items-center space-x-4">
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" class="block mb-2 border border-gray-300 rounded-lg p-2 focus:ring-green-500 focus:border-lightseagreen-500">
                        <button type="submit" class="text-white bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                            <i class="fa-solid fa-upload"></i> Upload CV
                        </button>
                    </div>
                @endif
            </div>

            {{-- Save Button --}}
<div class="text-center mt-4"> {{-- Added margin-top here --}}
    <button style="background-color: lightseagreen;"
        type="submit" 
        class="w-full bg-lightseagreen-500 text-white py-3 px-6 rounded-lg hover:bg-lightseagreen-600 focus:outline-none"
    >
        Save Changes
    </button>
</div>

        </form>

    </x-card>
</x-layout>
