<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'email',
        'phone_number',
        'country',
        'address',
        'city',
        'state',
        'customer_group'
    ];


    public function orders()
    {
        return $this->hasMany(Sales::class, 'customer_id');
    }

    public function getOrderCountAttribute()
    {
        return $this->orders->count();
    }

    public function getRecentPaidOrdersCountAttribute()
    {
        return $this->orders
            ->where('payment_status', 'paid')
            ->count();
    }
}
