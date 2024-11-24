<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceipt extends Model
{
    use HasFactory;

    // Ensure timestamps are enabled (this is usually true by default)
    public $timestamps = false;

    protected $fillable = [
        'date',
        'invoice_number',
        'invoice_to',
        'attention',
        'po_number',
        'terms',
        'rep',
        'ship_date',
        'fob',
        'project',
    ];

    // Define relationship with the DeliveryReceiptItem model
    public function items()
    {
        return $this->hasMany(DeliveryReceiptItem::class);
    }
}
