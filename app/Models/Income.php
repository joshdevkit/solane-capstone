<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'product_id',
        'serial_id',
        'amount',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function productBarcode()
    {
        return $this->belongsTo(ProductBarcodes::class, 'serial_id', 'id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
}
