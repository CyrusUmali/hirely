<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Check if the user is trying to access an admin route
        if ($request->is('admin') && ! $request->expectsJson()) {
            return route('admin.login'); // Redirect to the admin login page
        }
    
        // Default redirect to the regular login page
        if (! $request->expectsJson()) {
            // Only redirect to the regular login if the user is not trying to access an admin route
            return route('login');
        }
    }
    
}

