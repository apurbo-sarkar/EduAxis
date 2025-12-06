<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'class_id',
        'subject_id',
        'start_time',
        'end_time',
        'location',
        'teacher_name',
        'day_name',
    ];

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }
}
