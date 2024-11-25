<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBarcodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_code',
        'barcode',
        'net_weight',
        'length'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function income()
    {
        return $this->hasOne(Income::class, 'serial_id', 'id');
    }
}
