<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MoPhong implements FromCollection, WithHeadings, WithStyles
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
            'SỐ LƯU KHO',
            'QUI CÁCH ',
            'MÃ HÀNG',
            'MÁY',
            'PLANT',
            'NGÀY SẢN XUẤT',
            'LẦN XUỐNG GIÀN',
            'NGÀY DỆT',
            'KẾT QUẢ NHUỘM',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
