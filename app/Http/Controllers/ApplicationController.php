<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Listing;
use App\Models\Comment; // Assuming a Comment model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Apply to a job listing
    public function apply(Listing $listing)
    {
        // Check if the user is logged in
        if (Auth::check()) {

            // Check if the logged-in user is the creator of the listing
            if ($listing->user_id === Auth::id()) {
                return back()->with('message', 'You cannot apply for your own job.');
            }

            // Check if the user has already applied to this listing
            if (Application::where('user_id', Auth::id())->where('listing_id', $listing->id)->exists()) {
                return back()->with('message', 'You have already applied to this job.');
            }

            // Create the application
            Application::create([
                'user_id' => Auth::id(),
                'listing_id' => $listing->id,
                'status' => 'pending',  // Default to 'pending' status
            ]);

            return back()->with('message', 'Your application has been submitted.');
        }

        // Redirect if not authenticated
        return redirect('/login');
    }

    // Accept the application
    public function accept(Application $application)
    {
        // Logic for accepting the application
        $application->status = 'accepted'; // Assuming 'status' is a column in the 'applications' table
        $application->save();

        return redirect()->back()->with('message', 'Application accepted successfully!');
    }

    public function addOrUpdateReview(Request $request, Application $application)
    {
        $request->validate([
            'content' => 'required|string|max:500', // Validation for content length
        ]);

        // Assuming the target user is related to the application
        // You may need to modify this logic depending on how the target user is determined.
        $targetUserId = $application->user_id; // For example, assuming target user is related to the application’s user_id.

        // Check if the user has already left a review for this application
        $review = $application->comments()->where('user_id', Auth::id())->first();

        if ($review) {
            // Update the existing review
            $review->content = $request->input('content');
            $review->target_user_id = $targetUserId; // Ensure target_user_id is correctly set
            $review->save();
            return redirect()->back()->with('message', 'Review updated successfully!');
        } else {
            // Create a new review
            $application->comments()->create([
                'user_id' => Auth::id(), // The commenter (current user)
                'content' => $request->input('content'),
                'target_user_id' => $targetUserId, // The user receiving the comment (target user)
            ]);
            return redirect()->back()->with('message', 'Review added successfully!');
        }
    }
 

    public function addOrUpdateReview2(Request $request, Application $application, $targetUserId)
    {
        // Validate review content
        $request->validate([
            'content' => 'required|string|max:500', // Validation for content length
        ]);
    
        // Check if the user has already left a review for this application
        $review = $application->comments()->where('user_id', Auth::id())->first();
    
        if ($review) {
            // Update the existing review
            $review->content = $request->input('content');
            $review->target_user_id = $targetUserId; // Use the passed targetUserId from the route
            $review->save();
            return redirect()->back()->with('message', 'Review updated successfully!');
        } else {
            // Create a new review
            $application->comments()->create([
                'user_id' => Auth::id(), // The commenter (current user)
                'content' => $request->input('content'),
                'target_user_id' => $targetUserId, // The user receiving the comment (target user)
            ]);
            return redirect()->back()->with('message', 'Review added successfully!');
        }
    }
    








    // Show the listing and associated applications
    public function delete(Application $application)
    {
        $application->delete();

        return redirect()->back()->with('message', 'Application deleted successfully!');
    }
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing,
            'applications' => $listing->applications // Pass all applications
        ]);
    }
}
