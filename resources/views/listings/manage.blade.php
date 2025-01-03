<x-layout>
    <x-card class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Jobs
            </h1>
        </header>

        <div class="space-y-8">
            {{-- Check if listings exist --}}
            @unless ($listings->isEmpty())
            @foreach ($listings as $listing)

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800">{{ $listing->title }}</h3>
                    <div class="flex space-x-4">
                        <a href="/listings/{{ $listing->id }}/edit" class="text-blue-500 px-4 py-2 rounded-xl hover:bg-blue-600 transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form method="POST" action="/listings/{{ $listing->id }}" onsubmit="return confirm('Are you sure you want to delete this listing?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 px-4 py-2 rounded-xl hover:bg-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Display Applications for each listing --}}
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800">Applications</h4>

                    {{-- Filter buttons --}}
                    <div class="mb-4">
                        <button class="bg-green-500 text-white py-1 px-4 rounded-xl filter-btn hover:bg-green-600 transition-colors duration-300" data-filter="accepted">
                            Accepted
                        </button>
                        <button class="bg-yellow-500 text-white py-1 px-4 rounded-xl filter-btn hover:bg-yellow-600 transition-colors duration-300" data-filter="pending">
                            Pending
                        </button>
                    </div>

                    @if ($listing->applications && $listing->applications->isEmpty())
                    <p>No applications yet.</p>
                    @elseif ($listing->applications)
                    <div id="applications-list-{{ $listing->id }}">
                        @foreach ($listing->applications as $application)
                        <div class="border-b border-gray-300 pb-4 mb-4 application-item" data-status="{{ $application->status }}">

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">
                                    <a style="color: lightseagreen;" href="{{ route('user.profile', $application->user->id) }}" class="text-lightseagreen-500 hover:underline">
                                        {{ $application->user->name }}
                                    </a>
                                </span>
                                <div class="flex space-x-4">
                                    @if ($application->status === 'accepted')
                                    {{-- Options for accepted applications --}}
                                    <form action="{{ route('applications.delete', $application->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this application?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white py-1 px-4 rounded-xl hover:bg-red-600 transition-colors duration-300">
                                            Delete
                                        </button>
                                    </form>


                                    {{-- Show/Edit Review --}}
                                    @if ($application->comments->where('user_id', auth()->id())->first())
                                    <form action="{{ route('applications.addOrUpdateReview', $application->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <textarea name="content" class="w-full border rounded-lg p-2 hidden" id="comment-form-{{ $application->id }}">{{ $application->comments->where('user_id', auth()->id())->first()->content }}</textarea>
                                        <button type="button" class="bg-blue-500 text-white py-1 px-4 rounded-xl hover:bg-blue-600" onclick="toggleCommentForm({{ $application->id }})">
                                            Edit Review
                                        </button>
                                        <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-xl mt-2 hidden" id="submit-review-{{ $application->id }}">Update Review</button>
                                    </form>
                                    @else
                                    <form action="{{ route('applications.addOrUpdateReview', $application->id) }}" method="POST">
                                        @csrf
                                        <textarea name="content" class="w-full border rounded-lg p-2" placeholder="Write your review here..."></textarea>
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg mt-2">Submit Review</button>
                                    </form>
                                    @endif
                                    @else
                                    {{-- Accept/Reject Buttons for pending applications --}}
                                    <form action="{{ route('applications.accept', $application->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-green-500 text-white py-1 px-4 rounded-xl hover:bg-green-600 transition-colors duration-300">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('applications.reject', $application->id) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white py-1 px-4 rounded-xl hover:bg-red-600 transition-colors duration-300">
                                            Reject
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Display existing comments --}}
                            @if ($application->comments)
                            <div class="mt-4">
                                <h4 class="text-lg font-semibold mb-2">Comments</h4>

                                @foreach ($application->comments as $comment)
                                {{-- Check if the comment was made by the job poster --}}
                                @if ($comment->user_id === $listing->user_id)
                                <div class="bg-gray-50 p-4 mb-4 border border-gray-200 rounded-lg shadow-sm">
                                    <p class="text-gray-800 font-semibold mb-2">{{ $comment->user->name }}:</p>
                                    <p class="text-gray-600">{{ $comment->content }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endif

                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            @endforeach
            @else
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-center text-lg font-medium text-gray-700">No Listings Found</p>
            </div>
            @endunless
        </div>





    </x-card>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const defaultFilter = 'pending'; // Set default filter to pending

        const applyFilter = (filter) => {
            const listings = document.querySelectorAll('div[id^="applications-list-"]');
            listings.forEach(listing => {
                const applications = listing.querySelectorAll('.application-item');
                applications.forEach(app => {
                    if (app.getAttribute('data-status') === filter) {
                        app.classList.remove('hidden'); // Show the item
                    } else {
                        app.classList.add('hidden'); // Hide the item
                    }
                });
            });
        };

        // Apply default filter on page load
        applyFilter(defaultFilter);

        // Add event listeners to buttons
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                applyFilter(filter);
            });
        });
    });


    // Toggle form visibility for editing review
    function toggleCommentForm(applicationId) {
        const form = document.getElementById(`comment-form-${applicationId}`);
        const submitButton = document.getElementById(`submit-review-${applicationId}`);
        form.classList.toggle('hidden');
        submitButton.classList.toggle('hidden');
    }
</script>