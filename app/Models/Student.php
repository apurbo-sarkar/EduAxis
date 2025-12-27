<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'students';
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'full_name',
        'admission_number',
        'date_of_birth',
        'gender',
        'student_class',
        'blood_group',
        'student_email',
        'password',
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
        'academic_status',
        'status_remarks',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'terms_agreed' => 'boolean',
    ];

    public function mathematics()
    {
        return $this->hasOne(Mathematics::class, 'student_id', 'student_id');
    }

    public function englishLanguage()
    {
        return $this->hasOne(EnglishLanguage::class, 'student_id', 'student_id');
    }

    public function literature()
    {
        return $this->hasOne(Literature::class, 'student_id', 'student_id');
    }
}