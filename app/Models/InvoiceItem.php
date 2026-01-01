<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'invoice_id',
        'fee_structure_id',
        'item_name',
        'amount',
        'quantity',
        'total'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'invoice_id');
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id', 'fee_structure_id');
    }
}