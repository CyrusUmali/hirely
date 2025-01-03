<x-layout>
    <a href="/" class="inline-block text-black ml-4 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="mx-4">

        <x-card class="p-10">

            <div class="flex flex-col items-center justify-center text-center">
                <img
                    class="w-48 mr-6 mb-6"
                    src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.png') }}"
                    alt="" />

                <h3 class="text-2xl mb-2">{{ $listing->title }}</h3>
                <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>

                <x-listing-tags :tagsCsv="$listing->tags" />

                <div class="text-lg my-4">
                    <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                </div>
                <div class="border border-gray-200 w-full mb-6"></div>
                <div>
                    <h3 class="text-3xl font-bold mb-4">Job Description</h3>
                    <div class="text-lg space-y-6">
                        <p>{{ $listing->description }}</p>

                        <a style="background-color: #1ab394;"
                            href="mailto:{{ $listing->email }}"
                            class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80">
                            <i class="fa-solid fa-envelope"></i> Contact Employer
                        </a>

                        <a
                            href="{{ $listing->website }}"
                            target="_blank"
                            class="block bg-black text-white py-2 rounded-xl hover:opacity-80">
                            <i class="fa-solid fa-globe"></i> Visit Website
                        </a>
                    </div>
                </div>


                {{-- Apply Button --}}
                <form action="{{ route('applications.store', $listing) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="block bg-green-500 text-white py-2 px-6 rounded-xl hover:bg-green-600">
                        <i class="fa-solid fa-briefcase"></i> Apply Now
                    </button>
                </form>

            </div>

            <div class="mb-8">
    <h2 class="text-2xl font-semibold mb-4">This Job's Recent Comments</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @php
        $hasValidComments = false; // Initialize a flag to check for valid comments
        @endphp

        @foreach ($listing->applications as $application)
        @foreach ($application->comments as $comment)
        @if ($comment->user_id !== $listing->user_id) {{-- Exclude comments from the job creator --}}
        @php
        $hasValidComments = true; // Set the flag if a valid comment is found
        @endphp
        <div class="mb-4 p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center mb-3">
                <p style="color: lightseagreen;" class="text-lg font-medium text-lightseagreen-500">
                    <a href="{{ route('user.profile', $comment->user->id) }}" class="hover:underline">
                        {{ $comment->user->name }}
                    </a> : 
                    <span class="text-lg text-gray-900"> "{{ $comment->content }}"</span> 
                </p> {{-- Name of the employee in lightseagreen --}}
            </div>
        </div>
        @endif
        @endforeach
        @endforeach

        @if (!$hasValidComments)
        <p class="text-gray-500 text-lg">No comments yet.</p>
        @endif
    </div>
</div>






        </x-card>

    </div>
</x-layout>