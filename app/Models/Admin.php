<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    // If admins have their own table
    protected $table = 'admins';

    // You can add other properties here as needed
    protected $fillable = ['name', 'password'];
}


?>