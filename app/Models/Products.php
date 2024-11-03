<?php

namespace App\Models;

use App\Notifications\LowStockNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode_symbology',
        'net_weight',
        'category_id',
        'cost',
        'price',
        'quantity',
        'product_image',
        'product_description'
    ];


    public function barcodes()
    {
        return $this->hasMany(ProductBarcodes::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }


    public function checkStock()
    {
        if ($this->quantity < 20) {
            $this->notify(new LowStockNotification($this));
        }
    }
}
