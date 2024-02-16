<?php

namespace App\Http\Livewire;

use App\Exports\TTDHExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use Livewire\Component;

class BCTTDH extends Component
{

    public $tuNgay, $denNgay;

    public function download(){

        return Excel::download(new TTDHExport($this->tuNgay, $this->denNgay), 'Bao_cao_TTDH_' . Carbon::now()->isoFormat('DD_MM_YYYY') . '.xlsx');

    }

    public function render()
    {
        return view('livewire.b-c-t-t-d-h');
    }
}
