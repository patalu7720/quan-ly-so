<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenBHopDong extends Model
{
    use HasFactory;

    protected $table = 'ben_b_vs_hop_dong';

    protected $fillable = [

        'sohd',
        'ma_khach_hang',
        'ten_tv',
        'dia_chi_tv',
        'ma_so_thue_tv',
        'tai_khoan_ngan_hang_tv',
        'dien_thoai_tv',
        'fax_tv',
        'dai_dien_tv',
        'chuc_vu_tv',
        'giay_uy_quyen_tv',
        'ten_ta',
        'dia_chi_ta',
        'tai_khoan_ngan_hang_ta',
        'dai_dien_ta',
        'chuc_vu_ta',

        'check_ma_so_thue',
        'check_tai_khoan_ngan_hang',
        'check_dien_thoai',
        'check_fax',
        'check_dai_dien',
        'check_giay_uy_quyen',

    ];
}
