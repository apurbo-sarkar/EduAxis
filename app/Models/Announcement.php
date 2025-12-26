<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $primaryKey = 'notification_id';
    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'content',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];
}

