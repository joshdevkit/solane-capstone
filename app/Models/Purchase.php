<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_added',
        'purchase_no',
        'supplier_id',
        'is_received',
        'order_tax',
        'discount',
        'shipping',
        'payment',
        'notes'
    ];


    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
}