<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mathematics extends Model
{
    use HasFactory;
    protected $table = 'mathematics';
    protected $fillable = [
        'student_id',
        'quiz',
        'assignment',
        'mid_exam',
        'final_exam',
        'marks_obtained',
        'grade_obtained',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}

