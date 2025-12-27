<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'description',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id', 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'student_class', 'name');
    }
}
