<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_name',
        'file_path',
        'date',
        'plate',
        'customer',
        'dr',
        'driver',
        'seal_number',
        'total_cylinder_weight',
        'tare_weight'
    ];
}
