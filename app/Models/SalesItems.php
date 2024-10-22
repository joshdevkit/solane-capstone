<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItems extends Model
{
    use HasFactory;

    protected $fillable  = [
        'sales_id',
        'product_id',
        'product_serial_id',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function productSerial()
    {
        return $this->belongsTo(ProductBarcodes::class, 'product_serial_id');
    }

    public function productSerials()
    {
        return $this->hasMany(ProductBarcodes::class, 'product_id', 'product_id');
    }
}
