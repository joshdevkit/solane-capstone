<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_added',
        'reference_no',
        'biller',
        'customer_id',
        'order_tax',
        'order_discount',
        'shipping',
        'attached_documents',
        'sale_status',
        'payment_status',
        'sales_note',
    ];


    public function items()
    {
        return $this->hasMany(SalesItems::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customers::class);
    }


    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function salesItems()
    {
        return $this->hasMany(SalesItems::class);
    }
}
