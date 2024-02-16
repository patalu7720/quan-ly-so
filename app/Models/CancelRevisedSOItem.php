<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRevisedSOItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cancel_revised_so_id',
        'old_item',
        'new_item',
        'description',
        'old_qty',
        'new_qty',
    ];
}
