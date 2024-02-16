<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TC extends Component
{
    public $state, $khachHang, $hopDong, $file, $paginate;

    public $maKhachHangTimKiem, $khachHangTimKiem, $soHopDongTimKiem;

    use WithFileUploads;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount(){

        $this->state = 'main';
        $this->paginate = '15';

    }

    public function upFileModal(){

        $this->state = 'upFileModal';

    }

    public function upFile(){

        if($this->file == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            DB::transaction(function (){

                $arrayFile = [];
    
                foreach ($this->file as $item) {
    
                    array_push($arrayFile, $item->getClientOriginalName());
    
                }
    
                DB::table('tc')
                ->insert([

                    'ma_khach_hang' => $this->khachHang,
                    'hop_dong' => $this->hopDong,
                    'file' => implode(',', $arrayFile),
                    'created_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ]);
                
                $path = 'TC/' . str_replace('/', '-', $this->hopDong);
    
                if(!Storage::disk('ftp')->exists($path)) {
    
                    Storage::disk('ftp')->makeDirectory($path);
    
                }
    
                foreach ($this->file as $item) {
    
                    Storage::disk('ftp')->putFileAs($path, $item, $item->getClientOriginalName());
    
                } 
    
                flash()->addSuccess('Thành công.');
                $this->state == 'main';
                $this->emit('upFileModal');
    
            });

        }

    }

    public function downloadFile($hopDong, $tenFile){

        $path = 'TC/' . str_replace('/', '-', $hopDong) . '/' . $tenFile;

        return Storage::disk('ftp')->download($path);

    }

    public function timKiem(){

        $this->state = 'main';

    }

    public function render()
    {
        $listKhachHang = null;
        $listHopDong = null;
        
        if($this->state == 'main'){

            $main = DB::table('tc')
            ->join('ben_b', 'tc.ma_khach_hang', 'ben_b.ma_khach_hang')
            ->where(function ($query){

                $query->whereRaw("'" . $this->maKhachHangTimKiem . "'" . "=''");
                $query->orWhere('tc.ma_khach_hang', 'like', '%' . $this->maKhachHangTimKiem . '%');

            })
            ->where(function ($query){

                $query->whereRaw("'" . $this->khachHangTimKiem . "'" . "=''");
                $query->orWhere(function ($query1){

                    $query1->where('ben_b.ten_tv', 'like', '%' . $this->khachHangTimKiem . '%');
                    $query1->orWhere('ben_b.ten_ta', 'like', '%' . $this->khachHangTimKiem . '%');

                });

            })
            ->where(function ($query){

                $query->whereRaw("'" . $this->soHopDongTimKiem . "'" . "=''");
                $query->orWhere('tc.hop_dong', 'like', '%' . $this->soHopDongTimKiem . '%');

            })
            ->select('tc.ma_khach_hang', 'tc.hop_dong', 'tc.file', 'tc.created_user', 'tc.created_at', 'ben_b.ten_tv', 'ben_b.ten_ta')
            ->paginate($this->paginate);

            session(['main' => $main]);

        }elseif($this->state == 'upFileModal'){

            $this->hopDong = null;

            $listKhachHang = DB::table('ben_b')->get();

            $listHopDong = DB::table('ben_b_vs_hop_dong')
            ->where('ma_khach_hang',$this->khachHang)
            ->select('sohd')
            ->distinct('sohd')
            ->get();

            $listHopDong->transform(function ($item) {

                if(substr($item->sohd, 0,1) == '2'){

                    $item->sohd_new = substr($item->sohd,4,5) . '/HĐMB-' . substr($item->sohd,0,4);

                }else{

                    $item->sohd_new = $item->sohd;

                }
    
                return $item;
            });
    
            $listHopDong->all();

        }

        return view('livewire.t-c', compact('listKhachHang', 'listHopDong'));
        
    }
}
