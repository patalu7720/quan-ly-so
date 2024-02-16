<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;

class TDGExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public $tuNgay, $denNgay;

    public function __construct($tuNgay, $denNgay)
    {
        $this->tuNgay = $tuNgay . ' 00:00:00';
        $this->denNgay = $denNgay . ' 23:59:59';
    }

    public function headings(): array
    {
        return [
            'id',
            'so_phieu',
            'so_phieu_xac_nhan_don_hang',
            'customer',
            'customer_no',
            'consignee',
            'agency',
            'brand',
            'tc',
            'co',
            'incoterms',
            'payment_terms',
            'validity_of_delivery',
            'validity_of_payment',
            'application',
            'cone_set',
            'kg_cone',
            'packing',
            'shiptime',
            'stocknewproduct',
            'khung_xe',
            'spec',
            'grade',
            'material',
            'qty',
            'excluded_usd',
            'excluded_vnd',
            'zpr0_usd',
            'zpr0_vnd',
            'product',
            'listprice',
            'stran_usd',
            'stran_vnd',
            'small_usd',
            'small_vnd',
            'unload_usd',
            'unload_vnd',
            'banking_usd',
            'banking_vnd',
            'pl_usd',
            'pl_vnd',
            'comm_usd',
            'comm_vnd',
            'mang_co_usd',
            'mang_co_vnd',
            'claim_usd',
            'claim_vnd',
            'tc_usd',
            'tc_vnd',
            'name_other',
            'other_usd',
            'other_vnd',
            'payment',
            'exchange',
            'stockinyear',
            'customer_type',
            'delivery_term',
            'cs',
            'remark',
            'valid_from',
            'valid_to',
            'new',
            'new_at',
            'approved_1',
            'approved_1_at',
            'approved_2',
            'approved_2_at',
            'approved_3',
            'approved_3_at',
            'approved_4',
            'approved_4_at',
            'reject',
            'reject_at',
            'reason_for_reject',
            'status',
            'is_delete',
            'created_user',
            'updated_user',
            'created_at',
            'updated_at',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A:K')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
   
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
    
    public function collection()
    {
        $result = DB::table('phieu_tdg')
        ->whereBetween('created_at', [$this->tuNgay, $this->denNgay])
        ->get();

        return $result;
    }
}
