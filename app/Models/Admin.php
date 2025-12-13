<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'full_name',
        'email',
        'phone',
        'role',
        'address',
        'terms_agreed',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
