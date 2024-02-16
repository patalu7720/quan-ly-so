<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyCachPhieuXXDHLog extends Model
{
    use HasFactory;

    protected $table = 'phieu_xxdh_quy_cach_log';

    public $timestamps = false;

    protected $fillable = [

        'phieu_xxdh_so_phieu_id_log',
        'quy_cach',
        'so_luong',
        'kieu_may_det',
        'lot',
        'lot_chinh_thuc',
        'so_cone',
        'so_kg_cone',
        'qa_kien_nghi',
        'line',
        'may',
        'ngay_giao_hang',
        'ngay_bat_dau_giao',
        'thanh_pham_cua_khach_hang',
        'phan_anh_cua_khach_hang',
        'thong_tin_dong_goi',
        'lich_du_kien',
        'pallet',
        'recycle',
        'status'

    ];
}
