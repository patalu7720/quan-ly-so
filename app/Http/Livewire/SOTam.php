<?php

namespace App\Http\Livewire;

use App\Models\BenB;
use App\Models\SOTam as ModelsSOTam;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SOTam extends Component
{
    use WithPagination;

    public $soTimKiem, $khachHangTimKiem, $danhSachKhachHang;

    public $maKhachHang;

    public $state;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->state = 'main';

    }

    public function resetInputField(){

        $this->maKhachHang = null;

    }

    public function timKiem(){

        $this->state = 'timKiem';

    }

    public function create(){

        $this->state = 'create';

    }

    public function store(){

        $khachHang = BenB::where('ma_khach_hang', $this->maKhachHang)->first();
        
        if($khachHang == null){

            flash()->addError('Không tìm thấy thông tin khách hàng này.');
            $this->resetInputField();
            $this->emit('closeModal');
            $this->state = 'main';

        }else{

            $soPhieu = IdGenerator::generate(['table' => 'so_tam', 'field' => 'so_tam', 'length' => '12', 'prefix' => 'forecast','reset_on_prefix_change' => true]);

            $soTam = new ModelsSOTam();
    
            $soTam->so_tam = $soPhieu;
            $soTam->ma_khach_hang = $khachHang->ma_khach_hang;
            $soTam->ten_khach_hang = $khachHang->ten_tv;
            $soTam->created_user = auth()->user()->username;
            $soTam->updated_user = auth()->user()->username;
    
            $soTam->save();

            flash()->addSuccess('Thêm SO tạm thành công.');
            $this->resetInputField();
            $this->emit('closeModal');
            $this->state = 'main';

        }

    }

    public function render()
    {
        if(in_array($this->state, ['main', 'timKiem'])){

            $this->danhSachKhachHang = BenB::all();

            $main = ModelsSOTam::where(function($query){
                $query->whereRaw("'" . $this->soTimKiem . "' = ''");
                $query->orWhere('so_tam', $this->soTimKiem);
            })
            ->where(function($query){

                $query->whereRaw("'" . $this->khachHangTimKiem . "' = ''");
                $query->orWhere('ten_khach_hang', 'like', '%' . $this->khachHangTimKiem . '%');
    
            })
            
            ->paginate(15);

            session(['main' => $main]);

        }

        return view('livewire.s-o-tam');
    }
}
