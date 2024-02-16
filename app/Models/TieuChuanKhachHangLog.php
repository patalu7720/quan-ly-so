<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TieuChuanKhachHangLog extends Model
{
    use HasFactory;

    protected $table = 'tieu_chuan_khach_hang_log';

    protected $fillable = [

        'so_phieu',
        'ma_khach_hang',
        'ten_khach_hang',
        'loai_may_det',
        'quy_cach_soi',
        'chung_loai_soi',
        'chip',
        'khach_hang_chi_dinh_chip',
        'lot',
        'twist',
        'denier',
        'tenacity',
        'elongation',
        'dty_bws',
        'dty_cr',
        'dty_cc',
        'dty_oil_pick',
        'dty_knots',
        'stability',
        'ti02',
        'times',
        'torque',
        'yeu_cau_tem',
        'thong_tin_khac',
        'status',
        'created_user',
        'updated_user',

    ];
}
