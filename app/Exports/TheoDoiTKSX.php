<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TheoDoiTKSX implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $collect;

    public function __construct($collect)
    {
        $this->collect = $collect;
    }

    public function collection()
    {
        return $this->collect;
    }

    public function headings(): array
    {
        return [
            'TKSX',
            'Máy',
            'Mã hàng',
            'Quy cách',
            'Đơn-chập',
            'Mã cũ-mới',
            'Line POY',
            'Mã POY',
            'KH',
            'Yêu cầu KH',
            'Điều kiện KH',
            'Khối lượng',
            'Ngày QA ký TK',
            'Ngày TK',
            'Ngày SX chính thức',
            'Ngày kiểm tra TSKT',
            'Ngày QC gửi TSKT',
            'Kết quả',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
