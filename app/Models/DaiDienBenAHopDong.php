<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaiDienBenAHopDong extends Model
{
    use HasFactory;

    public $table = 'dai_dien_ben_a_vs_hop_dong';

    public $fillable = [

        'sohd',
        'dai_dien_id',
        'ben_a_id',
        'dai_dien_tv',
        'chuc_vu_tv',
        'uy_quyen_tv',
        'dai_dien_ta',
        'chuc_vu_ta',
        'uy_quyen_ta',

    ];
}
