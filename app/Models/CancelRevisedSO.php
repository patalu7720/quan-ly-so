<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRevisedSO extends Model
{
    use HasFactory;

    protected $fillable = [

        'ten_khach_hang',
        'ma_khach_hang',
        'so',
        'date',
        'san_xuat_moi',
        'ton_kho',
        'being_processed',
        'open',
        'cancel_order',
        'revised_latest_shipment_date',
        'old_date',
        'new_date',
        'cb_revised_qty',
        'revised_qty',
        'cb_incoterms',
        'incoterms',
        'cb_payment_terms',
        'payment_terms',
        'cb_shipment_plan',
        'shipment_plan',
        'cb_output_tax',
        'output_tax',
        'cb_bill_to_party',
        'bill_to_party',
        'cb_po_number',
        'po_number',
        'cb_order_reason',
        'order_reason',
        'cb_reason_for_reject',
        'reason_for_reject',
        'cb_internal_order',
        'internal_order',
        'cb_tolerance',
        'tolerance',
        'other_reason',
        'sale_phu_trach',
        'sale_admin_approve',
        'sale_admin_approve_at',
        'sale_approve',
        'sale_approve_at',
        'sale_manager_approve',
        'sale_manager_approve_at',
        'khst_approve',
        'khst_approve_at',
        'finish',
        'finish_at',
        'reject',
        'reject_at',
        'note',
        'md_approve',
        'md_approve_at',
        'status',
        'is_delete',
        'created_user',
        'updated_user',

    ];
}
