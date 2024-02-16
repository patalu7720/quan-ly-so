<?php

namespace App\Http\Livewire;

use App\Mail\BaoGia as MailBaoGia;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;
use Spatie\Permission\Models\Permission;

class BaoGia extends Component
{
    public $soPhieu, $loaiBaoGia, $ngay, $to, $yarnType1, $yarnType2, $yarnType3, $yarnType4, $yarnType5, $yarnType6, $oem; 

    public $yarnType1Edit, $yarnType2Edit, $yarnType3Edit, $yarnType4Edit, $yarnType5Edit, $yarnType6Edit, $oemEdit;

    public $quantityEdit, $bobbinWeightEdit, $yarnPriceEdit, $gradeEdit;
    
    public $quantity, $bobbinWeight, $yarnPrice, $grade, $remark, $paymentTerms, $exchangeRate, $validDate, $status, $thongTinXacNhan;

    public $baoGiaSanPham, $search, $tuNgay, $denNgay, $canhan_tatca, $search_fields, $paginate, $capRollBack;

    public $inputs = [], $i = 0;

    public $danhSachRemoveBaoGiaSanPham;

    public $danhSachBaoGiaSanPham, $log;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->loaiBaoGia = 'nd';
        $this->paginate = 15;
        $this->canhan_tatca = 'phieuDoiDuyet';

    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);

    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function resetInputField(){

        $this->soPhieu = '';
        $this->loaiBaoGia = 'nd';
        $this->ngay = ''; 
        $this->to = '';
        $this->remark = '';
        $this->paymentTerms = '';
        $this->exchangeRate = '';
        $this->validDate = '';
        $this->yarnType1 = '';
        $this->yarnType2 = '';
        $this->yarnType3 = '';
        $this->yarnType4 = '';
        $this->yarnType5 = ''; 
        $this->yarnType6 = ''; 
        $this->oem = ''; 
        $this->quantity = '';
        $this->bobbinWeight = '';
        $this->yarnPrice = '';
        $this->grade = '';
        $this->inputs = [];
        $this->i = 0;
        $this->baoGiaSanPham = '';

        $this->danhSachBaoGiaSanPham = '';
        $this->log = '';

    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function addBaoGia(){

        DB::transaction(function(){

            $this->soPhieu = IdGenerator::generate(['table' => 'bao_gia', 'field' => 'so_phieu', 'length' => '12', 'prefix' => 'BG-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);

            DB::table('bao_gia')->insert([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loaiBaoGia,
                'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                'to' => $this->to,
                'remark' => $this->remark,
                'payment_terms' => $this->paymentTerms,
                'exchange_rate' => $this->exchangeRate,
                'valid_date' => $this->validDate,
                'new' => Auth::user()->username,
                'new_at' => Carbon::now(),
                'status' => 'New',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('bao_gia_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loaiBaoGia,
                'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                'to' => $this->to,
                'remark' => $this->remark,
                'payment_terms' => $this->paymentTerms,
                'exchange_rate' => $this->exchangeRate,
                'valid_date' => $this->validDate,
                'status' => 'New',
                'status_log' => 'Created',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            foreach ($this->yarnType1 as $key => $value) {

                if($this->yarnType1[$key] == 'OEM'){

                    DB::table('bao_gia_san_pham')->insert([

                        'so_phieu' => $this->soPhieu,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'oem' => $this->oem[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'oem' => $this->oem[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);

                }else{

                    DB::table('bao_gia_san_pham')->insert([

                        'so_phieu' => $this->soPhieu,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'yarn_type_2' => $this->yarnType2[$key],
                        'yarn_type_3' => $this->yarnType3[$key],
                        'yarn_type_4' => $this->yarnType4[$key],
                        'yarn_type_5' => $this->yarnType5[$key],
                        'yarn_type_6' => $this->yarnType6[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'yarn_type_2' => $this->yarnType2[$key],
                        'yarn_type_3' => $this->yarnType3[$key],
                        'yarn_type_4' => $this->yarnType4[$key],
                        'yarn_type_5' => $this->yarnType5[$key],
                        'yarn_type_6' => $this->yarnType6[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);

                }

            }

            if($this->loaiBaoGia == 'nd'){

                $users = User::permission('approve_1_bao_gia')->first();

                Mail::to($users->email)->later(now()->addMinutes(1), new MailBaoGia('New',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

            }elseif($this->loaiBaoGia == 'xk'){
            
                $users = User::permission('approve_2_bao_gia')->first();
    
                Mail::to($users->email)->later(now()->addMinutes(1), new MailBaoGia('New',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

            }

            flash()->addFlash('success', 'Tạo thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('addBaoGiaModal');

        });

    }

    public function editBaoGiaModal($soPhieu){

        $baoGia = DB::table('bao_gia')->where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $baoGia->so_phieu;
        $this->loaiBaoGia = $baoGia->loai;
        $this->ngay = Carbon::create($baoGia->ngay)->isoFormat('YYYY-MM-DD');
        $this->to = $baoGia->to;
        $this->remark = $baoGia->remark;
        $this->paymentTerms = $baoGia->payment_terms;
        $this->exchangeRate = $baoGia->exchange_rate;
        $this->validDate = $baoGia->valid_date;
        $this->validDate = $baoGia->valid_date;
        

        $this->baoGiaSanPham = DB::table('bao_gia_san_pham')
        ->where('so_phieu', $soPhieu)
        ->get();

        if($this->baoGiaSanPham != null){

            foreach ($this->baoGiaSanPham as $item) {

                $this->yarnType1Edit[$item->id] = $item->yarn_type_1;
                $this->yarnType2Edit[$item->id] = $item->yarn_type_2;
                $this->yarnType3Edit[$item->id] = $item->yarn_type_3;
                $this->yarnType4Edit[$item->id] = $item->yarn_type_4;
                $this->yarnType5Edit[$item->id] = $item->yarn_type_5;
                $this->yarnType6Edit[$item->id] = $item->yarn_type_6;
                $this->oemEdit[$item->id] = $item->oem;
                $this->quantityEdit[$item->id] = $item->quantity;
                $this->bobbinWeightEdit[$item->id] = $item->bobbin_weight;
                $this->yarnPriceEdit[$item->id] = $item->yarn_price;
                $this->gradeEdit[$item->id] = $item->grade;

            }

        }

    }

    public function updateBaoGia(){

        DB::transaction(function(){

            DB::table('bao_gia')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'loai' => $this->loaiBaoGia,
                'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                'to' => $this->to,
                'remark' => $this->remark,
                'payment_terms' => $this->paymentTerms,
                'exchange_rate' => $this->exchangeRate,
                'valid_date' => $this->validDate,
                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('bao_gia_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loaiBaoGia,
                'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                'to' => $this->to,
                'remark' => $this->remark,
                'payment_terms' => $this->paymentTerms,
                'exchange_rate' => $this->exchangeRate,
                'valid_date' => $this->validDate,
                'status' => 'New',
                'status_log' => 'Updated',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            foreach (array_reverse($this->yarnType1Edit, true) as $key => $value) {

                if($this->yarnType1Edit[$key] == 'OEM'){

                    DB::table('bao_gia_san_pham')
                    ->where('id', $key)
                    ->update([

                        'oem' => $this->oemEdit[$key],
                        'quantity' => $this->quantityEdit[$key],
                        'bobbin_weight' => $this->bobbinWeightEdit[$key],
                        'yarn_price' => $this->yarnPriceEdit[$key],
                        'grade' => $this->gradEdite[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'oem' => $this->oem[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);

                }else{

                    DB::table('bao_gia_san_pham')
                    ->where('id', $key)
                    ->update([

                        'yarn_type_1' => $this->yarnType1Edit[$key],
                        'yarn_type_2' => $this->yarnType2Edit[$key],
                        'yarn_type_3' => $this->yarnType3Edit[$key],
                        'yarn_type_4' => $this->yarnType4Edit[$key],
                        'yarn_type_5' => $this->yarnType5Edit[$key],
                        'yarn_type_6' => $this->yarnType6Edit[$key],
                        'quantity' => $this->quantityEdit[$key],
                        'bobbin_weight' => $this->bobbinWeightEdit[$key],
                        'yarn_price' => $this->yarnPriceEdit[$key],
                        'grade' => $this->gradeEdit[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1Edit[$key],
                        'yarn_type_2' => $this->yarnType2Edit[$key],
                        'yarn_type_3' => $this->yarnType3Edit[$key],
                        'yarn_type_4' => $this->yarnType4Edit[$key],
                        'yarn_type_5' => $this->yarnType5Edit[$key],
                        'yarn_type_6' => $this->yarnType6Edit[$key],
                        'quantity' => $this->quantityEdit[$key],
                        'bobbin_weight' => $this->bobbinWeightEdit[$key],
                        'yarn_price' => $this->yarnPriceEdit[$key],
                        'grade' => $this->gradeEdit[$key],
    
                    ]);

                }

            }

            foreach ($this->yarnType1 as $key => $value) {

                if($this->yarnType1[$key] == 'OEM'){

                    DB::table('bao_gia_san_pham')->insert([

                        'so_phieu' => $this->soPhieu,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'oem' => $this->oem[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'oem' => $this->oem[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);

                }else{

                    DB::table('bao_gia_san_pham')->insert([

                        'so_phieu' => $this->soPhieu,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'yarn_type_2' => $this->yarnType2[$key],
                        'yarn_type_3' => $this->yarnType3[$key],
                        'yarn_type_4' => $this->yarnType4[$key],
                        'yarn_type_5' => $this->yarnType5[$key],
                        'yarn_type_6' => $this->yarnType6[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);
    
                    DB::table('bao_gia_san_pham_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'bao_gia_log_id' => $idLog,
                        'yarn_type_1' => $this->yarnType1[$key],
                        'yarn_type_2' => $this->yarnType2[$key],
                        'yarn_type_3' => $this->yarnType3[$key],
                        'yarn_type_4' => $this->yarnType4[$key],
                        'yarn_type_5' => $this->yarnType5[$key],
                        'yarn_type_6' => $this->yarnType6[$key],
                        'quantity' => $this->quantity[$key],
                        'bobbin_weight' => $this->bobbinWeight[$key],
                        'yarn_price' => $this->yarnPrice[$key],
                        'grade' => $this->grade[$key],
    
                    ]);

                }

            }

            flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('editBaoGiaModal');

        });

    }

    public function viewBaoGiaModal($soPhieu){

        $baoGia = DB::table('bao_gia')
        ->where('so_phieu', $soPhieu)
        ->first();

        $this->soPhieu = $soPhieu;
        $this->loaiBaoGia = $baoGia->loai;
        $this->ngay = $baoGia->ngay;
        $this->to = $baoGia->to;
        $this->remark = $baoGia->remark;
        $this->paymentTerms = $baoGia->payment_terms;
        $this->exchangeRate = $baoGia->exchange_rate;
        $this->validDate = $baoGia->valid_date;
        $this->status = $baoGia->status;

        $this->danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
        ->where('so_phieu', $soPhieu)
        ->get();

        $this->log = DB::table('bao_gia_log')
        ->where('so_phieu', $soPhieu)
        ->get();

    }

    public function approveBaoGiaModal($soPhieu){

        $baoGia = DB::table('bao_gia')
        ->where('so_phieu', $soPhieu)
        ->first();

        $this->soPhieu = $soPhieu;
        $this->loaiBaoGia = $baoGia->loai;
        $this->ngay = $baoGia->ngay;
        $this->to = $baoGia->to;
        $this->remark = $baoGia->remark;
        $this->paymentTerms = $baoGia->payment_terms;
        $this->exchangeRate = $baoGia->exchange_rate;
        $this->validDate = $baoGia->valid_date;
        $this->status = $baoGia->status;

        $this->danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
        ->where('so_phieu', $soPhieu)
        ->get();

    }

    public function approveBaoGia(){

        $baoGia = DB::table('bao_gia')
        ->where('so_phieu', $this->soPhieu)
        ->first();

        if($baoGia->loai == 'nd'){

            if($this->status == 'New'){

                if (!Auth::user()->hasPermissionTo('approve_1_bao_gia')) {
                    
                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($this->status == 'Approved 1'){

                if (!Auth::user()->hasPermissionTo('approve_2_bao_gia')) {
                    
                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($this->status == 'Approved 2'){

                if (!Auth::user()->hasPermissionTo('approve_3_bao_gia')) {
                
                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                    return;

                }

            }

        }elseif($baoGia->loai == 'xk'){

            if($this->status == 'New'){

                if (!Auth::user()->hasPermissionTo('approve_2_bao_gia')) {
                    
                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($this->status == 'Approved 2'){

                if (!Auth::user()->hasPermissionTo('approve_3_bao_gia')) {
                
                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                    return;

                }

            }

        }

        DB::transaction(function() use ($baoGia){

            if($baoGia->loai == 'nd'){

                if($this->status == 'New'){

                    DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'approved_1' => Auth::user()->username,
                        'approved_1_at' => Carbon::now(),
    
                        'status' => 'Approved 1',
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    $idLog = DB::table('bao_gia_log')->insertGetId([
    
                        'so_phieu' => $this->soPhieu,
                        'loai' => $this->loaiBaoGia,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $this->to,
                        'remark' => $this->remark,
                        'payment_terms' => $this->paymentTerms,
                        'exchange_rate' => $this->exchangeRate,
                        'valid_date' => $this->validDate,
                        'status' => 'Approved 1',
                        'status_log' => 'Approved',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    foreach ($this->danhSachBaoGiaSanPham as $item) {
    
                        DB::table('bao_gia_san_pham_log')->insert([
        
                            'so_phieu' => $this->soPhieu,
                            'bao_gia_log_id' => $idLog,
                            'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                            'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                            'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                            'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                            'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                            'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                            'oem' => $item->oem ?? $item['oem'],
                            'quantity' => $item->quantity ?? $item['quantity'],
                            'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                            'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                            'grade' => $item->grade ?? $item['grade'],
        
                        ]);
                        
                    }
    
                    $users = User::permission('approve_2_bao_gia')->first();

                    $userSale = User::where('username', $baoGia->created_user)->first();
    
                    Mail::to($users->email)
                    ->cc($userSale->email)
                    ->later(now()->addMinutes(1), new MailBaoGia('Approved 1',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
    
                }elseif($this->status == 'Approved 1'){
    
                    DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'approved_2' => Auth::user()->username,
                        'approved_2_at' => Carbon::now(),
    
                        'status' => 'Approved 2',
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    $idLog = DB::table('bao_gia_log')->insertGetId([
    
                        'so_phieu' => $this->soPhieu,
                        'loai' => $this->loaiBaoGia,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $this->to,
                        'remark' => $this->remark,
                        'payment_terms' => $this->paymentTerms,
                        'exchange_rate' => $this->exchangeRate,
                        'valid_date' => $this->validDate,
                        'status' => 'Approved 2',
                        'status_log' => 'Approved',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    foreach ($this->danhSachBaoGiaSanPham as $item) {
    
                        DB::table('bao_gia_san_pham_log')->insert([
        
                            'so_phieu' => $this->soPhieu,
                            'bao_gia_log_id' => $idLog,
                            'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                            'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                            'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                            'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                            'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                            'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                            'oem' => $item->oem ?? $item['oem'],
                            'quantity' => $item->quantity ?? $item['quantity'],
                            'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                            'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                            'grade' => $item->grade ?? $item['grade'],
        
                        ]);
                        
                    }
    
                    $users = User::permission('approve_3_bao_gia')->first();
    
                    $userSale = User::where('username', $baoGia->created_user)->first();
    
                    Mail::to($users->email)
                    ->cc($userSale->email)
                    ->later(now()->addMinutes(1), new MailBaoGia('Approved 2',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                
                }elseif($this->status == 'Approved 2'){
            
                    DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'finish' => Auth::user()->username,
                        'finish_at' => Carbon::now(),
    
                        'status' => 'Finish',
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
        
                    ]);
        
                    $idLog = DB::table('bao_gia_log')->insertGetId([
    
                        'so_phieu' => $this->soPhieu,
                        'loai' => $this->loaiBaoGia,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $this->to,
                        'remark' => $this->remark,
                        'payment_terms' => $this->paymentTerms,
                        'exchange_rate' => $this->exchangeRate,
                        'valid_date' => $this->validDate,
                        'status' => 'Finish',
                        'status_log' => 'Approved',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
        
                    ]);
        
                    foreach ($this->danhSachBaoGiaSanPham as $item) {
    
                        DB::table('bao_gia_san_pham_log')->insert([
        
                            'so_phieu' => $this->soPhieu,
                            'bao_gia_log_id' => $idLog,
                            'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                            'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                            'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                            'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                            'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                            'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                            'oem' => $item->oem ?? $item['oem'],
                            'quantity' => $item->quantity ?? $item['quantity'],
                            'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                            'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                            'grade' => $item->grade ?? $item['grade'],
        
                        ]);
                        
                    }

                    $templateProcessor = new TemplateProcessor(public_path('BaoGia/QUOTATION.docx'));

                    $baoGia = DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->first();

                    $values = [
    
                        'ngay' => Carbon::create($baoGia->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $baoGia->to,
                        'remark' => $baoGia->remark,
                        'payment_terms' => $baoGia->payment_terms,
                        'exchange_rate' => $baoGia->exchange_rate,
                        'valid' => $baoGia->valid_date,
    
                    ];

                    $values_table = [];

                    foreach ($this->danhSachBaoGiaSanPham as $item){

                        if($item['oem'] != ''){
                                    
                            $values_table = array_merge($values_table,[
                                [
                                    'item' => $item['oem'], 
                                    'quantity' => $item['quantity'], 
                                    'bobbin_weight' => $item['bobbin_weight'], 
                                    'yarn_price' => $item['yarn_price'],
                                    'grade' => $item['grade'],
                                ]
                            ]);

                        }else{
                        
                            $values_table = array_merge($values_table,[
                                [
                                    'item' => $item['yarn_type_1'] . ' ' . $item['yarn_type_3'] . ' ' . $item['yarn_type_4'] . ' ' . $item['yarn_type_2'] . ' ' . $item['yarn_type_6'] . ' ' . $item['yarn_type_5'], 
                                    'quantity' => $item['quantity'], 
                                    'bobbin_weight' => $item['bobbin_weight'], 
                                    'yarn_price' => $item['yarn_price'],
                                    'grade' => $item['grade'],
                                ]
                            ]);
                        
                        }
                    }

                    $templateProcessor->setValues($values);

                    $templateProcessor->cloneRowAndSetValues('item', $values_table);

                    Storage::disk('public')->makeDirectory('BaoGia/' . $this->soPhieu);

                    $templateProcessor->saveAs(storage_path('app/public/BaoGia/') . $this->soPhieu . '/' . $this->soPhieu .'.docx');
    
                    $userSale = User::where('username', $baoGia->created_user)->first();
    
                    Mail::to($userSale->email)->later(now()->addMinutes(1), new MailBaoGia('Finish',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

                    $this->emit('approveBaoGiaModal');

                    $this->resetInputField();

                }
            }elseif($baoGia->loai == 'xk'){
            
                if($this->status == 'New'){

                    DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'approved_2' => Auth::user()->username,
                        'approved_2_at' => Carbon::now(),
    
                        'status' => 'Approved 2',
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    $idLog = DB::table('bao_gia_log')->insertGetId([
    
                        'so_phieu' => $this->soPhieu,
                        'loai' => $this->loaiBaoGia,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $this->to,
                        'remark' => $this->remark,
                        'payment_terms' => $this->paymentTerms,
                        'exchange_rate' => $this->exchangeRate,
                        'valid_date' => $this->validDate,
                        'status' => 'Approved 2',
                        'status_log' => 'Approved',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
        
                    ]);
    
                    foreach ($this->danhSachBaoGiaSanPham as $item) {
    
                        DB::table('bao_gia_san_pham_log')->insert([
        
                            'so_phieu' => $this->soPhieu,
                            'bao_gia_log_id' => $idLog,
                            'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                            'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                            'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                            'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                            'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                            'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                            'oem' => $item->oem ?? $item['oem'],
                            'quantity' => $item->quantity ?? $item['quantity'],
                            'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                            'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                            'grade' => $item->grade ?? $item['grade'],
        
                        ]);
                        
                    }
    
                    $users = User::permission('approve_3_bao_gia')->first();

                    $userSale = User::where('username', $baoGia->created_user)->first();
    
                    Mail::to($users->email)
                    ->cc($userSale->email)
                    ->later(now()->addMinutes(1), new MailBaoGia('Approved 2',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
    
                }elseif($this->status == 'Approved 2'){
            
                    DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'finish' => Auth::user()->username,
                        'finish_at' => Carbon::now(),
    
                        'status' => 'Finish',
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
        
                    ]);
        
                    $idLog = DB::table('bao_gia_log')->insertGetId([
    
                        'so_phieu' => $this->soPhieu,
                        'loai' => $this->loaiBaoGia,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $this->to,
                        'remark' => $this->remark,
                        'payment_terms' => $this->paymentTerms,
                        'exchange_rate' => $this->exchangeRate,
                        'valid_date' => $this->validDate,
                        'status' => 'Finish',
                        'status_log' => 'Approved',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
        
                    ]);
        
                    foreach ($this->danhSachBaoGiaSanPham as $item) {
    
                        DB::table('bao_gia_san_pham_log')->insert([
        
                            'so_phieu' => $this->soPhieu,
                            'bao_gia_log_id' => $idLog,
                            'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                            'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                            'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                            'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                            'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                            'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                            'oem' => $item->oem ?? $item['oem'],
                            'quantity' => $item->quantity ?? $item['quantity'],
                            'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                            'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                            'grade' => $item->grade ?? $item['grade'],
        
                        ]);
                        
                    }

                    $templateProcessor = new TemplateProcessor(public_path('BaoGia/QUOTATION.docx'));

                    $baoGia = DB::table('bao_gia')
                    ->where('so_phieu', $this->soPhieu)
                    ->first();

                    $values = [
    
                        'ngay' => Carbon::create($baoGia->ngay)->isoFormat('DD.MM.YYYY'),
                        'to' => $baoGia->to,
                        'remark' => $baoGia->remark,
                        'payment_terms' => $baoGia->payment_terms,
                        'exchange_rate' => $baoGia->exchange_rate,
                        'valid' => $baoGia->valid_date,
    
                    ];

                    $values_table = [];

                    foreach ($this->danhSachBaoGiaSanPham as $item){

                        if($item['oem'] != ''){
                                    
                            $values_table = array_merge($values_table,[
                                [
                                    'item' => $item['oem'], 
                                    'quantity' => $item['quantity'], 
                                    'bobbin_weight' => $item['bobbin_weight'], 
                                    'yarn_price' => $item['yarn_price'],
                                    'grade' => $item['grade'],
                                ]
                            ]);

                        }else{
                        
                            $values_table = array_merge($values_table,[
                                [
                                    'item' => $item['yarn_type_1'] . ' ' . $item['yarn_type_3'] . ' ' . $item['yarn_type_4'] . ' ' . $item['yarn_type_2'] . ' ' . $item['yarn_type_6'] . ' ' . $item['yarn_type_5'], 
                                    'quantity' => $item['quantity'], 
                                    'bobbin_weight' => $item['bobbin_weight'], 
                                    'yarn_price' => $item['yarn_price'],
                                    'grade' => $item['grade'],
                                ]
                            ]);
                        
                        }
                    }

                    $templateProcessor->setValues($values);

                    $templateProcessor->cloneRowAndSetValues('item', $values_table);

                    Storage::disk('public')->makeDirectory('BaoGia/' . $this->soPhieu);

                    $templateProcessor->saveAs(storage_path('app/public/BaoGia/') . $this->soPhieu . '/' . $this->soPhieu .'.docx');

                    $userSale = User::where('username', $baoGia->created_user)->first();
    
                    Mail::to($userSale->email)->later(now()->addMinutes(1), new MailBaoGia('Finish',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

                    $this->emit('approveBaoGiaModal');
                    $this->resetInputField();
                }
            
            }

            flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('approveBaoGiaModal');

        });

    }

    public function deleteBaoGiaModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function deleteBaoGia(){

        DB::transaction(function(){

            DB::table('bao_gia')
            ->where('so_phieu', $this->soPhieu)
            ->update([
                'is_delete' => '1',
            ]);

            $baoGia = DB::table('bao_gia')->where('so_phieu', $this->soPhieu)->first();

            $idLog = DB::table('bao_gia_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $baoGia->loai,
                'ngay' => $baoGia->ngay,
                'to' => $baoGia->to,
                'remark' => $baoGia->remark,
                'payment_terms' => $baoGia->payment_terms,
                'exchange_rate' => $baoGia->exchange_rate,
                'valid_date' => $baoGia->valid_date,
                'new' => $baoGia->new,
                'new_at' => $baoGia->new_at,
                'approved_1' => $baoGia->approved_1,
                'approved_1_at' => $baoGia->approved_1_at,
                'finish' => $baoGia->finish,
                'finish_at' => $baoGia->finish_at,
                'status' => $baoGia->status,
                'status_log' => 'Deleted',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
            ->where('so_phieu', $this->soPhieu)
            ->get();

            foreach ($danhSachBaoGiaSanPham as $item) {

                DB::table('bao_gia_san_pham')
                ->where('so_phieu', $this->soPhieu)
                ->update([
                    'is_delete' => '1',
                ]);

                DB::table('bao_gia_san_pham_log')->insert([

                    'so_phieu' => $this->soPhieu,
                    'bao_gia_log_id' => $idLog,
                    'yarn_type_1' => $item->yarn_type_1,
                    'yarn_type_2' => $item->yarn_type_2,
                    'yarn_type_3' => $item->yarn_type_3,
                    'yarn_type_4' => $item->yarn_type_4,
                    'yarn_type_5' => $item->yarn_type_5,
                    'yarn_type_6' => $item->yarn_type_6,
                    'oem' => $item->oem,
                    'quantity' => $item->quantity,
                    'bobbin_weight' => $item->bobbin_weight,
                    'yarn_price' => $item->yarn_price,
                    'grade' => $item->grade,

                ]);
                
            }

            flash()->addFlash('success', 'Xóa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('deleteBaoGiaModal');

        });

    }

    public function rollBackModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $this->danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
        ->where('so_phieu', $soPhieu)
        ->get();

    }

    public function rollBack(){

        DB::transaction(function(){
            
            $baoGia = DB::table('bao_gia')->where('so_phieu', $this->soPhieu)->first();

            DB::table('bao_gia')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'approved_1' => null,
                'approved_1_at' => null,
                'approved_2' => null,
                'approved_2_at' => null,
                'finish' => null,
                'finish_at' => null,
                'status' => $this->capRollBack,
                'updated_user' => $baoGia->created_user,
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('bao_gia_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loaiBaoGia,
                'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                'to' => $baoGia->to,
                'remark' => $baoGia->remark,
                'payment_terms' => $baoGia->paymentTerms,
                'exchange_rate' => $baoGia->exchangeRate,
                'valid_date' => $baoGia->validDate,
                'status' => $baoGia->status,
                'status_log' => 'Rollback',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
            ->where('so_phieu', $this->soPhieu)
            ->get();

            foreach ($danhSachBaoGiaSanPham as $item) {

                DB::table('bao_gia_san_pham_log')->insert([

                    'so_phieu' => $this->soPhieu,
                    'bao_gia_log_id' => $idLog,
                    'yarn_type_1' => $item->yarn_type_1,
                    'yarn_type_2' => $item->yarn_type_2,
                    'yarn_type_3' => $item->yarn_type_3,
                    'yarn_type_4' => $item->yarn_type_4,
                    'yarn_type_5' => $item->yarn_type_5,
                    'yarn_type_6' => $item->yarn_type_6,
                    'oem' => $item->oem,
                    'quantity' => $item->quantity,
                    'bobbin_weight' => $item->bobbin_weight,
                    'yarn_price' => $item->yarn_price,
                    'grade' => $item->grade,

                ]);
                
            }

            Mail::to($baoGia->created_user)->later(now()->addMinutes(1), new MailBaoGia('Rollback',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Rollback thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('rollbackBaoGiaModal');
        });
    }

    public function confirmBaoGiaModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function confirmBaoGia(){

        DB::table('bao_gia')
        ->where('so_phieu', $this->soPhieu)
        ->update([

            'confirm' => $this->thongTinXacNhan,
            'status' => 'Confirmed',

            'updated_user' => Auth::user()->username,
            'updated_at' => Carbon::now(),

        ]);

        $baoGia = DB::table('bao_gia')
        ->where('so_phieu', $this->soPhieu)
        ->first();

        $idLog = DB::table('bao_gia_log')->insertGetId([
    
            'so_phieu' => $baoGia->soPhieu,
            'loai' => $baoGia->loaiBaoGia,
            'ngay' => Carbon::create($baoGia->ngay)->isoFormat('DD.MM.YYYY'),
            'to' => $baoGia->to,
            'remark' => $baoGia->remark,
            'payment_terms' => $baoGia->paymentTerms,
            'exchange_rate' => $baoGia->exchangeRate,
            'valid_date' => $baoGia->validDate,
            'confirm' => $this->thongTinXacNhan,
            'status' => $baoGia->status,
            'status_log' => 'Confirmed',
            'created_user' => Auth::user()->username,
            'updated_user' => Auth::user()->username,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        $danhSachBaoGiaSanPham = DB::table('bao_gia_san_pham')
        ->where('so_phieu', $this->soPhieu)
        ->get();

        foreach ($danhSachBaoGiaSanPham as $item) {
    
            DB::table('bao_gia_san_pham_log')->insert([

                'so_phieu' => $this->soPhieu,
                'bao_gia_log_id' => $idLog,
                'yarn_type_1' => $item->yarn_type_1 ?? $item['yarn_type_1'],
                'yarn_type_2' => $item->yarn_type_2 ?? $item['yarn_type_2'],
                'yarn_type_3' => $item->yarn_type_3 ?? $item['yarn_type_3'],
                'yarn_type_4' => $item->yarn_type_4 ?? $item['yarn_type_4'],
                'yarn_type_5' => $item->yarn_type_5 ?? $item['yarn_type_5'],
                'yarn_type_6' => $item->yarn_type_6 ?? $item['yarn_type_6'],
                'oem' => $item->oem ?? $item['oem'],
                'quantity' => $item->quantity ?? $item['quantity'],
                'bobbin_weight' => $item->bobbin_weight ?? $item['bobbin_weight'],
                'yarn_price' => $item->yarn_price ?? $item['yarn_price'],
                'grade' => $item->grade ?? $item['grade'],

            ]);
            
        }

        $users = User::permission('approve_3_bao_gia')->first();
    
        Mail::to($users->email)
        ->later(now()->addMinutes(1), new MailBaoGia('Confirmed',$this->soPhieu, Auth::user()->username, Carbon::now(), $this->thongTinXacNhan));

        flash()->addFlash('success', 'Xác nhận thành công phiếu : ' . $this->soPhieu,'Thông báo');
        $this->resetInputField();
        $this->emit('confirmBaoGiaModal');

    }
    

    public function downloadFile($soPhieu){
        return response()->download(storage_path('app/public/BaoGia/') . $soPhieu . '/' . $soPhieu . '.docx');
    }

    public function render()
    {

        $search_fields = [
            'bao_gia.so_phieu',
            'bao_gia.ngay',
            'bao_gia.to',
            'bao_gia.created_user',
        ];

        $search_terms = explode(',', $this->search);

        $danhSachBaoGia = DB::table('bao_gia')

        ->where(function ($query) use($search_terms, $search_fields){

            if($this->search != ''){

                foreach ($search_terms as $term) {
                    $query->orWhere(function ($query) use ($search_fields, $term) {
        
                        foreach ($search_fields as $field) {
                            $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                        }
                    });
                }

            } 

        })
        
        ->where('bao_gia.is_delete', null)

        ->where( function ($query){

            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('bao_gia.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);
    
            }elseif($this->tuNgay != null && $this->denNgay != null){
    
                $query->whereBetween('bao_gia.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }elseif($this->tuNgay == null && $this->denNgay != null){
    
                $query->whereBetween('bao_gia.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }
            elseif($this->tuNgay != null && $this->denNgay == null){
    
                $query->whereBetween('bao_gia.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);
    
            }

        })

        ->where(function ($query){

            if($this->canhan_tatca == 'phieuDoiDuyet'){

                if(Auth::user()->hasPermissionTo('create_bao_gia')){

                    $query->orWhere(function($query){

                        $query->where('bao_gia.status', '<>', 'Finish');

                        $query->where('bao_gia.created_user', Auth::user()->username);

                    }); 

                }

                if(Auth::user()->hasPermissionTo('approve_1_bao_gia')){

                    $query->orWhere(function($query){

                        $query->where('bao_gia.status', 'New');

                        $query->where('bao_gia.loai', 'nd');

                    }); 

                }

                if(Auth::user()->hasPermissionTo('approve_2_bao_gia')){

                    $query->orWhere(function($query){

                        $query->orWhere(function($query){

                            $query->where('bao_gia.status', 'Approved 1');

                            $query->where('bao_gia.loai', 'nd');

                        });

                        $query->orWhere(function($query){

                            $query->where('bao_gia.status', 'New');

                            $query->where('bao_gia.loai', 'xk');
                            
                        });
                    }); 
                }
                
                if(Auth::user()->hasPermissionTo('approve_3_bao_gia')){

                    $query->orWhere(function($query){

                        $query->where('bao_gia.status', 'Approved 2');

                    });

                }

            }elseif($this->canhan_tatca == 'phieuDaDuyet'){
                
                $query->where(function($query){

                    $query->orWhere('approved_1', Auth::user()->username);
                    $query->orWhere('approved_2', Auth::user()->username);
                    $query->orWhere('finish', Auth::user()->username);
                    $query->orWhere(function ($query){

                        $query->where('bao_gia.status', 'Finish');

                        $query->where('bao_gia.new', Auth::user()->username);

                    });

                });
            }elseif($this->canhan_tatca == 'phieuChoXacNhan'){

                $query->where('bao_gia.status', 'Finish');

                $query->where('bao_gia.created_user', Auth::user()->username);

            }

        });

        $danhSachBaoGia->select('bao_gia.so_phieu', 'bao_gia.loai' , 'bao_gia.ngay', 'bao_gia.to', 'bao_gia.status', 'bao_gia.created_user', 'bao_gia.created_at');
                
        $result = $danhSachBaoGia->paginate($this->paginate);

        return view('livewire.bao-gia', compact('result'));
    }
}
