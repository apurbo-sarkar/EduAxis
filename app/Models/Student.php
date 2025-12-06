<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable

{
    use HasFactory;

    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'full_name',
        'admission_number',
        'date_of_birth',
        'gender',
        'student_class',
        'blood_group',
        'student_email',
        'parent1_name',
        'parent1_phone',
        'parent1_email',
        'parent2_name',
        'parent2_phone',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
        'terms_agreed',
        'password',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'terms_agreed' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'student_id';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'student_id', 'student_id');
    }
}


