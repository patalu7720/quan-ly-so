<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOLog extends Model
{
    use HasFactory;

    protected $table = 'so_log';

    protected $fillable = [

        'so',
        'ten_file',
        'note',
        'status',
        'status_log',
        'username',
        'created_at',
        'updated_at',

    ];
}
