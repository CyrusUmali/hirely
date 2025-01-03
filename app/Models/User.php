<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cv_path', // Add this to allow mass assignment
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // Relationship of a User `users` with Listing `listings`
    public function listings() { // A User `users` has many Listing `listings`, and the Foreign Key of the Relationship is the `user_id` column
        return $this->hasMany(Listing::class, 'user_id');
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}
// User model
public function commentsAsTarget()
{
    return $this->hasMany(Comment::class, 'target_user_id');
}

// In User.php model
public function applications()
{
    return $this->hasMany(Application::class);
}



}
