<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_added',
        'reference_no',
        'biller',
        'customer_id',
        'order_tax',
        'discount',
        'shipping',
        'attach_document',
        'return_notes'
    ];


    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
