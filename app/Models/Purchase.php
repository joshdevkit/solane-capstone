<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_no',
        'product_id',
        'quantity',
        'supplier_id',
        'shipping',
        'payment',
        'notes'
    ];


    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
}
