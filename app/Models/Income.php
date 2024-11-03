<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'serial_id',
        'amount',
        'income_date'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
