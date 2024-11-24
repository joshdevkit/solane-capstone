<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_receipt_id', // Foreign key to the delivery_receipts table
        'qty',
        'item',
        'description',
        'price_each',
        'amount',
    ];

    // Define inverse relationship to DeliveryReceipt
    public function deliveryReceipt()
    {
        return $this->belongsTo(DeliveryReceipt::class);
    }
}
