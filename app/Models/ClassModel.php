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
    ];

}
