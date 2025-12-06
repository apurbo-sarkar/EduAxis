<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_id',
        'current_year',

        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

    protected $casts = [
        'current_year' => 'integer',
        'January'      => 'string',
        'February'     => 'string',
        'March'        => 'string',
        'April'        => 'string',
        'May'          => 'string',
        'June'         => 'string',
        'July'         => 'string',
        'August'       => 'string',
        'September'    => 'string',
        'October'      => 'string',
        'November'     => 'string',
        'December'     => 'string',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}



