<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $table = 'fee_structures';
    protected $primaryKey = 'fee_structure_id';

    protected $fillable = [
        'fee_name',
        'amount',
        'fee_type',
        'frequency',
        'description',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'fee_structure_id', 'fee_structure_id');
    }
}