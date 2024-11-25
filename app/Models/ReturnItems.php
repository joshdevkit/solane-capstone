<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'serial_id',
        'date_return',
        'return_no',
        'attach_document',
        'remarks'
    ];


    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function serial()
    {
        return $this->belongsTo(ProductBarcodes::class, 'serial_id');
    }


    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
