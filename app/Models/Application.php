<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'listing_id'];  // You may want to add more fields, like 'status', 'applied_at', etc.

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Listing
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // Relationship to Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
