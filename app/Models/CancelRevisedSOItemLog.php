<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRevisedSOItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'cancel_revised_so_log_id',
        'old_item',
        'new_item',
        'description',
        'old_qty',
        'new_qty',
    ];
}
