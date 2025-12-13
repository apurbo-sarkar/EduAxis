<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDashboard extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Set to null as this model doesn't need direct database interaction.
     */
    protected $table = 'admin_dashboard';

    /**
     * Disable timestamps if not needed
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'section_key',
        'title',
        'description',
        'icon',
        'route_name',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active dashboard items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}