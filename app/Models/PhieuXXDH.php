<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuXXDH extends Model
{
    use HasFactory;

    protected $table = 'phieu_xxdh';

    protected $fillable = [

        'so_phieu',
        'loai',
        'don_hang_grs',
        'don_hang_non_grs',
        'don_hang_sx_moi',
        'don_hang_lap_lai',
        'don_hang_ton_kho',
        'date',
        'ten_cong_ty',
        'so',
        'hop_dong',
        'quy_cach_su_dung',
        'so_luong',
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
        'phan_hoi_khst',
        'phan_bo_cc',
        'phan_bo_tb2',
        'phan_bo_tb3',
        'phan_hoi_qa',
        'mail_chinh',
        'mail_phu_1',
        'mail_phu_2',
        'status',
        'updated_user',
        'created_user',
        'is_delete',
        'new',
        'new_at',
        'sale_approved',
        'sale_approved_at',
        'sm_approved',
        'sm_approved_at',
        'qa_request',
        'qa_request_at',
        'khst_approved',
        'khst_approved_at',
        'admin_approved',
        'admin_approved_at',
        'qa_approved',
        'qa_approved_at',
        'finish',
        'finish_at',

    ];
}
