<?php

namespace App\Http\Livewire\BaoCao;

use App\Exports\TDGExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class BCTDG extends Component
{
    public $tuNgay, $denNgay;

    public function download(){

        return Excel::download(new TDGExport($this->tuNgay, $this->denNgay), 'Bao_cao_TDG_' . Carbon::now()->isoFormat('DD_MM_YYYY') . '.xlsx');

    }

    public function render()
    {
        return view('livewire.bao-cao.b-c-t-d-g');
    }
}
