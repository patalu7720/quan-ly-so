<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lear extends Model
{
    use HasFactory;

    protected $table = 'lear';

    protected $fillable = [

        'sohd',
        'wk',
        'container',
        'quantity',
        'unit_price',
        'amount',
        'created_at',
        'updated_at'

    ];
}
