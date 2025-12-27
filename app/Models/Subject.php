<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'subject_id', 'subject_id');
    }
}