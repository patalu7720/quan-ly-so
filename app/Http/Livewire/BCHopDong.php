<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BCHopDong extends Component
{
    public $danhSachSaleAdmin, $saleAdmin, $danhSachHopDongTatCa, $danhSachHopDongCaNhan;

    public $tuNgay, $denNgay, $state;

    public function mount(){

        $this->tuNgay = Carbon::now()->isoFormat('YYYY-MM-DD');

        $this->denNgay = Carbon::now()->isoFormat('YYYY-MM-DD');

        $this->state = 'main';

    }

    public function timKiem(){

        if($this->saleAdmin == ''){

            sweetalert()->addError('Chưa chọn nhân viên.');
            $this->state = 'main';
            return;

        }

        $this->danhSachHopDongCaNhan = DB::table('hop_dong')
        ->where('username', $this->saleAdmin)
        ->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59'])
        ->select('username', 'loaihopdong', DB::raw('count(loaihopdong) as total'))
        ->groupBy('username', 'loaihopdong')
        ->get();

        $this->state = 'timKiem';

    }

    public function render()
    {
        if ($this->state == 'main') {

            $this->danhSachSaleAdmin = User::permission('create_contracts')->get();

        }elseif ($this->state == 'timKiem'){
        
            $this->danhSachHopDongTatCa = DB::table('hop_dong')
            ->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59'])
            ->select('loaihopdong', DB::raw('count(loaihopdong) as total'))
            ->groupBy('loaihopdong')
            ->get();

        }

        return view('livewire.bao-cao.b-c-hop-dong');
    }
}
