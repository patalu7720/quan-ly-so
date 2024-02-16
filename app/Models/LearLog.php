<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearLog extends Model
{
    use HasFactory;

    protected $table = 'lear_log';

    protected $fillable = [

        'sohd',
        'wk',
        'container',
        'quantity',
        'unit_price',
        'amount',
        'status',
        'created_at',
        'updated_at'

    ];
}
