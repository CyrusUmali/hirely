<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

use App\Models\User;  // Include User model
use App\Models\Admin;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admin()
    {
        // Return the admin dashboard view
        return view('layout.design');
    }

    // Display all listings in the admin dashboard
    public function listings()
    {
        $listings = Listing::paginate(10);  // Paginate the listings (10 per page)
        return view('admin.listings', compact('listings'));
    }

    // Delete a listing
    public function deleteListing($id)
    {
        $listing = Listing::find($id);
        if ($listing) {
            $listing->delete();
            return redirect('/admin/listings')->with('message', 'Listing deleted successfully.');
        }

        return redirect('/admin/listings')->with('error', 'Listing not found.');
    }







    // Admin login view
    public function showLoginForm()
    {
        return view('admin.login');
    }


    public function login(Request $request)
    {
        // Get the credentials from the request
        $credentials = $request->only('name', 'password');

        // Find the admin by name
        $admin = Admin::where('name', $credentials['name'])->first();

        // Check if the admin exists and the password matches
        if ($admin && $admin->password === $credentials['password']) {
            // Log the admin in manually
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        }

        // If credentials don't match, return back with an error
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }
    // Logout an admin
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('../');
    }




    // Get list of all users
    public function index()
    {
        // Paginate the users (10 users per page)
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    // Delete a user
    public function destroy(User $user)
    {
        // Make sure not to delete the currently logged-in admin or a necessary user
        if (Auth::id() === $user->id) {
            return redirect('/admin/users')->with('error', 'Cannot delete yourself.');
        }

        $user->delete();
        return redirect('/admin/users')->with('message', 'User deleted successfully.');
    }





    // Show all comments in the admin panel
    public function comments()
    {
        $comments = Comment::with(['author', 'targetUser'])->paginate(10); // Load relationships
        return view('admin.comments', compact('comments'));
    }

    // Delete a specific comment
    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return redirect('/admin/comments')->with('message', 'Comment deleted successfully.');
        }

        return redirect('/admin/comments')->with('error', 'Comment not found.');
    }
}
