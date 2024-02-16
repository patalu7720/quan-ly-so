<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenAHopDong extends Model
{
    use HasFactory;

    protected $table = 'ben_a_vs_hop_dong';

    protected $fillable = [

        'sohd',
        'ma_cong_ty',
        'ten_tv',
        'dia_chi_tv',
        'ma_so_thue_tv',
        'dien_thoai_tv',
        'fax_tv',
        'ten_ta',
        'dia_chi_ta',

    ];
}
