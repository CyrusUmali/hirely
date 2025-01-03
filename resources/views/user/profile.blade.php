<x-layout>
    <x-card class="p-10">

        {{-- User Profile Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ $user->id === Auth::id() ? 'Your' : $user->name . '\'s' }} Information</h2>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-4">
                    <p class="text-lg font-medium text-gray-800">Name:
                        <span class="text-lg text-gray-900">{{ $user->name }}</span>
                    </p>
                </div>

                <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-4">
                    <p class="text-lg font-medium text-gray-800">Email:
                        <span class="text-lg text-gray-900">{{ $user->email }}</span>
                    </p>
                </div>

                {{-- Only show the edit button if the authenticated user is viewing their own profile --}}
                @if (Auth::id() === $user->id)
                <div class="text-center mt-6">
                    <a
                        href="{{ url('/user/settings/edit') }}"
                        class="text-white bg-lightseagreen-500 px-6 py-2 rounded-lg hover:bg-lightseagreen-600 transition-colors duration-300">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Settings
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ $user->id === Auth::id() ? 'Your' : $user->name . '\'s' }} Comments from Client</h2>

            <div class="p-6 rounded-lg shadow-md border border-gray-200 bg-white">
                @forelse ($user->commentsAsTarget as $comment)
                <div class="mb-6 border-b border-gray-300 pb-4">
                    {{-- Fetch the associated job title --}}
                    @php
                    $jobTitle = $comment->application->listing->title ?? 'Unknown Job Title';
                    @endphp

                    <div class="flex justify-between items-center mb-2">
                        <p class="text-lg font-medium text-gray-800">
                            Job Title:
                            <a href="#" class="text-lightseagreen-500 hover:underline font-semibold">{{ $jobTitle }}</a>
                        </p>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg font-medium text-gray-800">
                                From:
                                <a href="{{ route('user.profile', $comment->user->id) }}" class="text-lightseagreen-500 hover:underline font-semibold">{{ $comment->user->name }}</a>
                            </p>
                            <p class="text-md text-gray-700 mt-1">
                                "{{ $comment->content }}"
                            </p>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $comment->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-lg">No comments from client yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Applied Jobs Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ $user->id === Auth::id() ? 'Your' : $user->name . '\'s' }} Applied Jobs</h2>

            <div class="bg-white p-6 rounded-lg shadow-md">
                @forelse ($user->applications as $application)
                <div class="mb-6 border-b border-gray-300 pb-4">
                    {{-- Debugging user_id from listing --}}
                    @php
                    $authUserId = Auth::id();
                    $targetUserId = $application->listing->user_id; // Get user_id from the listing
                    @endphp

                    <div class="mb-2">
                        <p class="text-lg font-medium text-gray-800">Job Title:
                            <span class="text-lg font-semibold text-lightseagreen-500">{{ $application->listing->title }}</span>
                        </p>
                    </div>

                    <div class="mb-2">
                        <p class="text-lg font-medium text-gray-800">
                            Status:
                            <span class="text-lg font-semibold {{ $application->status === 'pending' ? 'text-lightseagreen-400' : 'text-green-600' }}">
                                {{ $application->status === 'pending' ? 'Pending' : 'Accepted' }}
                            </span>
                        </p>
                    </div>

                    @if ($application->status === 'accepted')
                    @php
                    $existingReview = $application->comments->where('user_id', $authUserId)->first();
                    @endphp

                    {{-- Review Form --}}
                    <form action="{{ route('applications.review', ['application' => $application->id, 'targetUserId' => $targetUserId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="target_user_id" value="{{ $targetUserId }}">

                        @if ($existingReview)
                        {{-- If review exists, pre-fill the textarea for editing --}}
                        <textarea name="content" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-lightseagreen-500 focus:border-lightseagreen-500">{{ $existingReview->content }}</textarea>
                        <button type="submit" class="mt-3 px-4 py-2 bg-lightseagreen-500 text-white rounded-lg hover:bg-lightseagreen-600">
                            Update Review
                        </button>
                        @else
                        {{-- If no review exists, allow user to submit a new one --}}
                        <textarea name="content" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-lightseagreen-500 focus:border-lightseagreen-500" placeholder="Leave your review"></textarea>
                        <button type="submit" class="mt-3 px-4 py-2 bg-lightseagreen-500 text-white rounded-lg hover:bg-lightseagreen-600">
                            Submit Review
                        </button>
                        @endif
                    </form>
                    @endif

                </div>
                @empty
                <p class="text-gray-500 text-lg">This user has not applied for any jobs yet.</p>
                @endforelse
            </div>
        </div>

    </x-card>
</x-layout>