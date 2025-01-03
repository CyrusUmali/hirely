<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'application_id', 'content' ,'target_user_id'];

    // Relationship to Application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


     // Relationship to the comment's author
     public function author()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
 
     // Relationship to the target user
     public function targetUser()
     {
         return $this->belongsTo(User::class, 'target_user_id');
     }
}
