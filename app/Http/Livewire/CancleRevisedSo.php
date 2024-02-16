<?php

namespace App\Http\Livewire;

use App\Mail\CancelRevisedSOEmail;
use App\Models\BenB;
use App\Models\CancelRevisedSO as M;
use App\Models\CancelRevisedSO;
use App\Models\CancelRevisedSOItem;
use App\Models\CancelRevisedSOItemLog;
use App\Models\CancelRevisedSOLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\AtMost;
use PhpOffice\PhpWord\TemplateProcessor;

class CancleRevisedSo extends Component
{
    public $cancelRevisedSO = [

        'so_phieu' => null,
        'ten_khach_hang' => null,
        'ma_khach_hang' => null,
        'so' => null,
        'date' => null,
        'san_xuat_moi' => 0,
        'ton_kho' => 0,
        'being_processed' => 0,
        'open' => 0,
        'cancel_order' => 0,
        'revised_latest_shipment_date' => 0,
        'old_date' => null,
        'new_date' => null,
        'cb_revised_qty' => 0,
        'revised_qty' => null,
        'cb_incoterms' => 0,
        'incoterms' => null,
        'cb_payment_terms' => 0,
        'payment_terms' => null,
        'cb_shipment_plan' => 0,
        'shipment_plan' => null,
        'cb_output_tax' => 0,
        'output_tax' => null,
        'cb_bill_to_party' => 0,
        'bill_to_party' => null,
        'cb_po_number' => 0,
        'po_number' => null,
        'cb_order_reason' => 0,
        'order_reason' => null,
        'cb_reason_for_reject' => 0,
        'reason_for_reject' => null,
        'cb_internal_order' => 0,
        'internal_order' => null,
        'cb_tolerance' => 0,
        'tolerance' => null,
        'other_reason' => null,
        'sale_phu_trach' => null,
        'created_user' => null,
        'updated_user' => null

    ];

    public $cancelRevisedSOItem, $cancelRevisedSOItemEdit, $cancelRevisedSOLog;

    public $soPhieuTimKiem, $tenKhachHangTimKiem, $soTimKiem, $trangThaiTimKiem, $adminTimKiem, $saleTimKiem, $tuNgay, $denNgay;

    public $oldItem, $newItem, $description, $oldQty, $newQty;

    public $oldItemEdit, $newItemEdit, $descriptionEdit, $oldQtyEdit, $newQtyEdit;

    public $inputs = [], $i = 0;

    public $paginate, $state;

    public $idCancelRevisedSO;

    public $noteReject;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

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

    public function removeEdit($idItem){

        $item = CancelRevisedSOItem::where('id', $idItem)->first();

        $item->delete();

        flash()->addSuccess('Xóa Item thành công.');

    }

    public function mount(){

        $this->paginate = 15;
        $this->state = 'main';
        $this->tuNgay = Carbon::now()->subDays(30)->isoFormat('YYYY-MM-DD');
        $this->denNgay = Carbon::now()->isoFormat('YYYY-MM-DD');

        if(Auth::user()->hasPermissionTo('create_cancel_revised_so'))
            $this->adminTimKiem = Auth::user()->username;
        elseif(Auth::user()->hasPermissionTo('approve_1_cancel_revised_so'))
            $this->saleTimKiem = Auth::user()->email;
        elseif(Auth::user()->hasPermissionTo('approve_2_cancel_revised_so'))
            $this->trangThaiTimKiem = 'Sale Approved';
        elseif(Auth::user()->hasPermissionTo('approve_3_cancel_revised_so'))
            $this->trangThaiTimKiem = 'SM Approved';
        elseif(Auth::user()->hasPermissionTo('approve_4_cancel_revised_so'))
            $this->trangThaiTimKiem = 'KHST Approved';

    }

    public function resetInputField(){

        $this->soPhieuTimKiem = null;
        $this->tenKhachHangTimKiem = null;
        $this->soTimKiem = null;
        $this->tuNgay = null;
        $this->denNgay = null;
        $this->state = 'main';
        $this->inputs = [];
        $this->i = 0;

        $this->oldItemEdit = null;
        $this->newItemEdit = null;
        $this->descriptionEdit = null;
        $this->oldQtyEdit = null;
        $this->newQtyEdit = null;
        
        $this->oldItem = null;
        $this->newItem = null;
        $this->description = null;
        $this->oldQty = null;
        $this->newQty = null;

        $this->cancelRevisedSO['ten_khach_hang'] = null;
        $this->cancelRevisedSO['ma_khach_hang'] = null;
        $this->cancelRevisedSO['so'] = null;
        $this->cancelRevisedSO['date'] = null;
        $this->cancelRevisedSO['san_xuat_moi'] = 0;
        $this->cancelRevisedSO['ton_kho'] = 0;
        $this->cancelRevisedSO['being_processed'] = 0;
        $this->cancelRevisedSO['open'] = 0;
        $this->cancelRevisedSO['cancel_order'] = 0;
        $this->cancelRevisedSO['revised_latest_shipment_date'] = 0;
        $this->cancelRevisedSO['old_date'] = null;
        $this->cancelRevisedSO['new_date'] = null;
        $this->cancelRevisedSO['cb_revised_qty'] = 0;
        $this->cancelRevisedSO['revised_qty'] = null;
        $this->cancelRevisedSO['cb_incoterms'] = 0;
        $this->cancelRevisedSO['incoterms'] = null;
        $this->cancelRevisedSO['cb_payment_terms'] = 0;
        $this->cancelRevisedSO['payment_terms'] = null;
        $this->cancelRevisedSO['cb_shipment_plan'] = 0;
        $this->cancelRevisedSO['shipment_plan'] = null;
        $this->cancelRevisedSO['cb_output_tax'] = 0;
        $this->cancelRevisedSO['output_tax'] = null;
        $this->cancelRevisedSO['cb_bill_to_party'] = 0;
        $this->cancelRevisedSO['bill_to_party'] = null;
        $this->cancelRevisedSO['cb_po_number'] = 0;
        $this->cancelRevisedSO['po_number'] = null;
        $this->cancelRevisedSO['cb_order_reason'] = 0;
        $this->cancelRevisedSO['order_reason'] = null;
        $this->cancelRevisedSO['cb_reason_for_reject'] = 0;
        $this->cancelRevisedSO['reason_for_reject'] = null;
        $this->cancelRevisedSO['cb_internal_order'] = 0;
        $this->cancelRevisedSO['internal_order'] = null;
        $this->cancelRevisedSO['cb_tolerance'] = 0;
        $this->cancelRevisedSO['tolerance'] = null;
        $this->cancelRevisedSO['other_reason'] = null;
        $this->cancelRevisedSO['sale_phu_trach'] = null;
        $this->cancelRevisedSO['created_user'] = null;
        $this->cancelRevisedSO['updated_user'] = null;
    }

    public function create(){

        $this->state = 'create';
        array_push($this->inputs ,0);

    }

    public function store(){

        DB::transaction(function(){

            $khachHang = BenB::where('ten_tv', $this->cancelRevisedSO['ten_khach_hang'])->first();

            if($khachHang != null){
                $this->cancelRevisedSO['ma_khach_hang'] = $khachHang->ma_khach_hang;
            }else{
                flash()->addError('Không tìm thấy thông tin khách hàng.');
            }

            $soPhieu = IdGenerator::generate(['table' => 'cancel_revised_s_o_s', 'field' => 'so_phieu', 'length' => '12', 'prefix' => 'CR-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);
    
            $item = new CancelRevisedSO();
    
            $item->so_phieu = $soPhieu;
            $item->ten_khach_hang = $this->cancelRevisedSO['ten_khach_hang'];
            $item->ma_khach_hang = $this->cancelRevisedSO['ma_khach_hang'];
            $item->so = $this->cancelRevisedSO['so'];
            $item->date = $this->cancelRevisedSO['date'];
            $item->san_xuat_moi = $this->cancelRevisedSO['san_xuat_moi'];
            $item->ton_kho = $this->cancelRevisedSO['ton_kho'];
            $item->being_processed = $this->cancelRevisedSO['being_processed'];
            $item->open = $this->cancelRevisedSO['open'];
            $item->cancel_order = $this->cancelRevisedSO['cancel_order'];
            $item->revised_latest_shipment_date = $this->cancelRevisedSO['revised_latest_shipment_date'];
            $item->old_date = $this->cancelRevisedSO['old_date'];
            $item->new_date = $this->cancelRevisedSO['new_date'];
            $item->cb_revised_qty = $this->cancelRevisedSO['cb_revised_qty'];
            $item->revised_qty = $this->cancelRevisedSO['revised_qty'];
            $item->cb_incoterms = $this->cancelRevisedSO['cb_incoterms'];
            $item->incoterms = $this->cancelRevisedSO['incoterms'];
            $item->cb_payment_terms = $this->cancelRevisedSO['cb_payment_terms'];
            $item->payment_terms = $this->cancelRevisedSO['payment_terms'];
            $item->cb_shipment_plan = $this->cancelRevisedSO['cb_shipment_plan'];
            $item->shipment_plan = $this->cancelRevisedSO['shipment_plan'];
            $item->cb_output_tax = $this->cancelRevisedSO['cb_output_tax'];
            $item->output_tax = $this->cancelRevisedSO['output_tax'];
            $item->cb_bill_to_party = $this->cancelRevisedSO['cb_bill_to_party'];
            $item->bill_to_party = $this->cancelRevisedSO['bill_to_party'];
            $item->cb_po_number = $this->cancelRevisedSO['cb_po_number'];
            $item->po_number = $this->cancelRevisedSO['po_number'];
            $item->cb_order_reason = $this->cancelRevisedSO['cb_order_reason'];
            $item->order_reason = $this->cancelRevisedSO['order_reason'];
            $item->cb_reason_for_reject = $this->cancelRevisedSO['cb_reason_for_reject'];
            $item->reason_for_reject = $this->cancelRevisedSO['reason_for_reject'];
            $item->cb_internal_order = $this->cancelRevisedSO['cb_internal_order'];
            $item->internal_order = $this->cancelRevisedSO['internal_order'];
            $item->cb_tolerance = $this->cancelRevisedSO['cb_tolerance'];
            $item->tolerance = $this->cancelRevisedSO['tolerance'];
            $item->other_reason = $this->cancelRevisedSO['other_reason'];
            $item->sale_phu_trach = $this->cancelRevisedSO['sale_phu_trach'];
            $item->sale_admin_approve = Auth::user()->username;
            $item->sale_admin_approve_at = Carbon::now();
            $item->status = 'New';
            $item->created_user = Auth::user()->username;
            $item->updated_user = Auth::user()->username;
    
            $item->save();

            $itemLog = new CancelRevisedSOLog();
    
            $itemLog->so_phieu = $soPhieu;
            $itemLog->cancel_revised_so_id = $item->id;
            $itemLog->ten_khach_hang = $this->cancelRevisedSO['ten_khach_hang'];
            $itemLog->ma_khach_hang = $this->cancelRevisedSO['ma_khach_hang'];
            $itemLog->so = $this->cancelRevisedSO['so'];
            $itemLog->date = $this->cancelRevisedSO['date'];
            $itemLog->san_xuat_moi = $this->cancelRevisedSO['san_xuat_moi'];
            $itemLog->ton_kho = $this->cancelRevisedSO['ton_kho'];
            $itemLog->being_processed = $this->cancelRevisedSO['being_processed'];
            $itemLog->open = $this->cancelRevisedSO['open'];
            $itemLog->cancel_order = $this->cancelRevisedSO['cancel_order'];
            $itemLog->revised_latest_shipment_date = $this->cancelRevisedSO['revised_latest_shipment_date'];
            $itemLog->old_date = $this->cancelRevisedSO['old_date'];
            $itemLog->new_date = $this->cancelRevisedSO['new_date'];
            $itemLog->cb_revised_qty = $this->cancelRevisedSO['cb_revised_qty'];
            $itemLog->revised_qty = $this->cancelRevisedSO['revised_qty'];
            $itemLog->cb_incoterms = $this->cancelRevisedSO['cb_incoterms'];
            $itemLog->incoterms = $this->cancelRevisedSO['incoterms'];
            $itemLog->cb_payment_terms = $this->cancelRevisedSO['cb_payment_terms'];
            $itemLog->payment_terms = $this->cancelRevisedSO['payment_terms'];
            $itemLog->cb_shipment_plan = $this->cancelRevisedSO['cb_shipment_plan'];
            $itemLog->shipment_plan = $this->cancelRevisedSO['shipment_plan'];
            $itemLog->cb_output_tax = $this->cancelRevisedSO['cb_output_tax'];
            $itemLog->output_tax = $this->cancelRevisedSO['output_tax'];
            $itemLog->cb_bill_to_party = $this->cancelRevisedSO['cb_bill_to_party'];
            $itemLog->bill_to_party = $this->cancelRevisedSO['bill_to_party'];
            $itemLog->cb_po_number = $this->cancelRevisedSO['cb_po_number'];
            $itemLog->po_number = $this->cancelRevisedSO['po_number'];
            $itemLog->cb_order_reason = $this->cancelRevisedSO['cb_order_reason'];
            $itemLog->order_reason = $this->cancelRevisedSO['order_reason'];
            $itemLog->cb_reason_for_reject = $this->cancelRevisedSO['cb_reason_for_reject'];
            $itemLog->reason_for_reject = $this->cancelRevisedSO['reason_for_reject'];
            $itemLog->cb_internal_order = $this->cancelRevisedSO['cb_internal_order'];
            $itemLog->internal_order = $this->cancelRevisedSO['internal_order'];
            $itemLog->cb_tolerance = $this->cancelRevisedSO['cb_tolerance'];
            $itemLog->tolerance = $this->cancelRevisedSO['tolerance'];
            $itemLog->other_reason = $this->cancelRevisedSO['other_reason'];
            $itemLog->sale_phu_trach = $this->cancelRevisedSO['sale_phu_trach'];
            $itemLog->status = 'Tạo mới';
            $itemLog->created_user = Auth::user()->username;
            $itemLog->updated_user = Auth::user()->username;
    
            $itemLog->save();

            foreach ($this->oldItem as $key=>$value) {

                $repeat = new CancelRevisedSOItem();

                $repeat->cancel_revised_so_id = $item->id;
                $repeat->old_item = $this->oldItem[$key];
                $repeat->new_item = $this->newItem[$key];
                $repeat->description = $this->description[$key];
                $repeat->old_qty = $this->oldQty[$key];
                $repeat->new_qty = $this->newQty[$key];

                $repeat->save();
            }

            foreach ($this->oldItem as $key=>$value) {

                $repeatLog = new CancelRevisedSOItemLog();

                $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                $repeatLog->old_item = $this->oldItem[$key];
                $repeatLog->new_item = $this->newItem[$key];
                $repeatLog->description = $this->description[$key];
                $repeatLog->old_qty = $this->oldQty[$key];
                $repeatLog->new_qty = $this->newQty[$key];

                $repeatLog->save();
            }

            $array = [
                'New',
                $this->cancelRevisedSO['ten_khach_hang'],
                $this->cancelRevisedSO['ma_khach_hang'],
                $this->cancelRevisedSO['so']
            ];

            Mail::to($this->cancelRevisedSO['sale_phu_trach'])->send(new CancelRevisedSOEmail($array));

            flash()->addSuccess('Tạo phiếu thành công.');
            $this->resetInputField();
            $this->emit('closeModal');
            $this->state = 'main';

        } );
    }

    public function edit($idCancelRevisedSO){

        $this->state = 'edit';
        $this->idCancelRevisedSO = $idCancelRevisedSO;

    }

    public function update(){

        $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();
        $item->ten_khach_hang = $this->cancelRevisedSO['ten_khach_hang'];
        $item->ma_khach_hang = $this->cancelRevisedSO['ma_khach_hang'];
        $item->so = $this->cancelRevisedSO['so'];
        $item->date = $this->cancelRevisedSO['date'];
        $item->san_xuat_moi = $this->cancelRevisedSO['san_xuat_moi'];
        $item->ton_kho = $this->cancelRevisedSO['ton_kho'];
        $item->being_processed = $this->cancelRevisedSO['being_processed'];
        $item->open = $this->cancelRevisedSO['open'];
        $item->cancel_order = $this->cancelRevisedSO['cancel_order'];
        $item->revised_latest_shipment_date = $this->cancelRevisedSO['revised_latest_shipment_date'];
        $item->old_date = $this->cancelRevisedSO['old_date'];
        $item->new_date = $this->cancelRevisedSO['new_date'];
        $item->cb_revised_qty = $this->cancelRevisedSO['cb_revised_qty'];
        $item->revised_qty = $this->cancelRevisedSO['revised_qty'];
        $item->cb_incoterms = $this->cancelRevisedSO['cb_incoterms'];
        $item->incoterms = $this->cancelRevisedSO['incoterms'];
        $item->cb_payment_terms = $this->cancelRevisedSO['cb_payment_terms'];
        $item->payment_terms = $this->cancelRevisedSO['payment_terms'];
        $item->cb_shipment_plan = $this->cancelRevisedSO['cb_shipment_plan'];
        $item->shipment_plan = $this->cancelRevisedSO['shipment_plan'];
        $item->cb_output_tax = $this->cancelRevisedSO['cb_output_tax'];
        $item->output_tax = $this->cancelRevisedSO['output_tax'];
        $item->cb_bill_to_party = $this->cancelRevisedSO['cb_bill_to_party'];
        $item->bill_to_party = $this->cancelRevisedSO['bill_to_party'];
        $item->cb_po_number = $this->cancelRevisedSO['cb_po_number'];
        $item->po_number = $this->cancelRevisedSO['po_number'];
        $item->cb_order_reason = $this->cancelRevisedSO['cb_order_reason'];
        $item->order_reason = $this->cancelRevisedSO['order_reason'];
        $item->cb_reason_for_reject = $this->cancelRevisedSO['cb_reason_for_reject'];
        $item->reason_for_reject = $this->cancelRevisedSO['reason_for_reject'];
        $item->cb_internal_order = $this->cancelRevisedSO['cb_internal_order'];
        $item->internal_order = $this->cancelRevisedSO['internal_order'];
        $item->cb_tolerance = $this->cancelRevisedSO['cb_tolerance'];
        $item->tolerance = $this->cancelRevisedSO['tolerance'];
        $item->other_reason = $this->cancelRevisedSO['other_reason'];
        $item->sale_phu_trach = $this->cancelRevisedSO['sale_phu_trach'];
        $item->updated_user = Auth::user()->username;
        $item->save();

        $itemLog = new CancelRevisedSOLog();
        $itemLog->cancel_revised_so_id = $item->id;
        $itemLog->so_phieu = $item->so_phieu;
        $itemLog->ten_khach_hang = $this->cancelRevisedSO['ten_khach_hang'];
        $itemLog->ma_khach_hang = $this->cancelRevisedSO['ma_khach_hang'];
        $itemLog->so = $this->cancelRevisedSO['so'];
        $itemLog->date = $this->cancelRevisedSO['date'];
        $itemLog->san_xuat_moi = $this->cancelRevisedSO['san_xuat_moi'];
        $itemLog->ton_kho = $this->cancelRevisedSO['ton_kho'];
        $itemLog->being_processed = $this->cancelRevisedSO['being_processed'];
        $itemLog->open = $this->cancelRevisedSO['open'];
        $itemLog->cancel_order = $this->cancelRevisedSO['cancel_order'];
        $itemLog->revised_latest_shipment_date = $this->cancelRevisedSO['revised_latest_shipment_date'];
        $itemLog->old_date = $this->cancelRevisedSO['old_date'];
        $itemLog->new_date = $this->cancelRevisedSO['new_date'];
        $itemLog->cb_revised_qty = $this->cancelRevisedSO['cb_revised_qty'];
        $itemLog->revised_qty = $this->cancelRevisedSO['revised_qty'];
        $itemLog->cb_incoterms = $this->cancelRevisedSO['cb_incoterms'];
        $itemLog->incoterms = $this->cancelRevisedSO['incoterms'];
        $itemLog->cb_payment_terms = $this->cancelRevisedSO['cb_payment_terms'];
        $itemLog->payment_terms = $this->cancelRevisedSO['payment_terms'];
        $itemLog->cb_shipment_plan = $this->cancelRevisedSO['cb_shipment_plan'];
        $itemLog->shipment_plan = $this->cancelRevisedSO['shipment_plan'];
        $itemLog->cb_output_tax = $this->cancelRevisedSO['cb_output_tax'];
        $itemLog->output_tax = $this->cancelRevisedSO['output_tax'];
        $itemLog->cb_bill_to_party = $this->cancelRevisedSO['cb_bill_to_party'];
        $itemLog->bill_to_party = $this->cancelRevisedSO['bill_to_party'];
        $itemLog->cb_po_number = $this->cancelRevisedSO['cb_po_number'];
        $itemLog->po_number = $this->cancelRevisedSO['po_number'];
        $itemLog->cb_order_reason = $this->cancelRevisedSO['cb_order_reason'];
        $itemLog->order_reason = $this->cancelRevisedSO['order_reason'];
        $itemLog->cb_reason_for_reject = $this->cancelRevisedSO['cb_reason_for_reject'];
        $itemLog->reason_for_reject = $this->cancelRevisedSO['reason_for_reject'];
        $itemLog->cb_internal_order = $this->cancelRevisedSO['cb_internal_order'];
        $itemLog->internal_order = $this->cancelRevisedSO['internal_order'];
        $itemLog->cb_tolerance = $this->cancelRevisedSO['cb_tolerance'];
        $itemLog->tolerance = $this->cancelRevisedSO['tolerance'];
        $itemLog->other_reason = $this->cancelRevisedSO['other_reason'];
        $itemLog->sale_phu_trach = $this->cancelRevisedSO['sale_phu_trach'];
        $itemLog->status = 'Cập nhật';
        $itemLog->created_user = Auth::user()->username;
        $itemLog->updated_user = Auth::user()->username;
        $itemLog->save();

        if($this->oldItem != null){
            foreach ($this->oldItem as $key=>$value) {
                $repeat = new CancelRevisedSOItem();
                $repeat->cancel_revised_so_id = $item->id;
                $repeat->old_item = $this->oldItem[$key];
                $repeat->new_item = $this->newItem[$key];
                $repeat->description = $this->description[$key];
                $repeat->old_qty = $this->oldQty[$key];
                $repeat->new_qty = $this->newQty[$key];
                $repeat->save();

                $repeatLog = new CancelRevisedSOItemLog();
                $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                $repeatLog->old_item = $this->oldItem[$key];
                $repeatLog->new_item = $this->newItem[$key];
                $repeatLog->description = $this->description[$key];
                $repeatLog->old_qty = $this->oldQty[$key];
                $repeatLog->new_qty = $this->newQty[$key];
                $repeatLog->save();
            }
        }

        foreach ($this->oldItemEdit as $key=>$value) {

            $repeat = CancelRevisedSOItem::where('id', $key)->first();
            $repeat->old_item = $this->oldItemEdit[$key];
            $repeat->new_item = $this->newItemEdit[$key];
            $repeat->description = $this->descriptionEdit[$key];
            $repeat->old_qty = $this->oldQtyEdit[$key];
            $repeat->new_qty = $this->newQtyEdit[$key];
            $repeat->save();

            $repeatLog = new CancelRevisedSOItemLog();
            $repeatLog->cancel_revised_so_log_id = $itemLog->id;
            $repeatLog->old_item = $this->oldItemEdit[$key];
            $repeatLog->new_item = $this->newItemEdit[$key];
            $repeatLog->description = $this->descriptionEdit[$key];
            $repeatLog->old_qty = $this->oldQtyEdit[$key];
            $repeatLog->new_qty = $this->newQtyEdit[$key];
            $repeatLog->save();

        }

        flash()->addSuccess('Cập nhật phiếu thành công.');
        $this->resetInputField();
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function show($idCancelRevisedSO){

        $this->state = 'show';
        $this->idCancelRevisedSO = $idCancelRevisedSO;

    }

    public function approveModal($idCancelRevisedSO){

        $this->state = 'approve';
        $this->idCancelRevisedSO = $idCancelRevisedSO;

    }

    public function approve(){
        $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

        if($item->status == 'New'){
            if(Auth::user()->email == $item->sale_phu_trach){
                DB::transaction(function() use ($item){
                    $item->sale_approve = Auth::user()->username;
                    $item->sale_approve_at = Carbon::now();
                    $item->status = 'Sale Approved';
                    $item->updated_at = Carbon::now();
                    $item->save();
    
                    $itemLog = new CancelRevisedSOLog();
                    $itemLog->cancel_revised_so_id = $item->id;
                    $itemLog->so_phieu = $item->so_phieu;
                    $itemLog->ten_khach_hang = $item->ten_khach_hang;
                    $itemLog->ma_khach_hang = $item->ma_khach_hang;
                    $itemLog->so = $item->so;
                    $itemLog->date = $item->date;
                    $itemLog->san_xuat_moi = $item->san_xuat_moi;
                    $itemLog->ton_kho = $item->ton_kho;
                    $itemLog->being_processed = $item->being_processed;
                    $itemLog->open = $item->open;
                    $itemLog->cancel_order = $item->cancel_order;
                    $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
                    $itemLog->old_date = $item->old_date;
                    $itemLog->new_date = $item->new_date;
                    $itemLog->cb_revised_qty = $item->cb_revised_qty;
                    $itemLog->revised_qty = $item->revised_qty;
                    $itemLog->cb_incoterms = $item->cb_incoterms;
                    $itemLog->incoterms = $item->incoterms;
                    $itemLog->cb_payment_terms = $item->cb_payment_terms;
                    $itemLog->payment_terms = $item->payment_terms;
                    $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
                    $itemLog->shipment_plan = $item->shipment_plan;
                    $itemLog->cb_output_tax = $item->cb_output_tax;
                    $itemLog->output_tax = $item->output_tax;
                    $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
                    $itemLog->bill_to_party = $item->bill_to_party;
                    $itemLog->cb_po_number = $item->cb_po_number;
                    $itemLog->po_number = $item->po_number;
                    $itemLog->cb_order_reason = $item->cb_order_reason;
                    $itemLog->order_reason = $item->order_reason;
                    $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
                    $itemLog->reason_for_reject = $item->reason_for_reject;
                    $itemLog->cb_internal_order = $item->cb_internal_order;
                    $itemLog->internal_order = $item->internal_order;
                    $itemLog->cb_tolerance = $item->cb_tolerance;
                    $itemLog->tolerance = $item->tolerance;
                    $itemLog->other_reason = $item->other_reason;
                    $itemLog->sale_phu_trach = $item->sale_phu_trach;
                    $itemLog->status = 'Approve';
                    $itemLog->created_user = Auth::user()->username;
                    $itemLog->updated_user = Auth::user()->username;
                    $itemLog->save();
    
                    $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();
    
                    foreach ($this->cancelRevisedSOItem as $key => $value) {
                        $repeatLog = new CancelRevisedSOItemLog();
                        $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                        $repeatLog->old_item = $value->old_item;
                        $repeatLog->new_item = $value->new_item;
                        $repeatLog->description = $value->description;
                        $repeatLog->old_qty = $value->old_qty;
                        $repeatLog->new_qty = $value->new_qty;
                        $repeatLog->save();
                    }
    
                    $array = [
                        'Sale Approved',
                        $this->cancelRevisedSO['ten_khach_hang'],
                        $this->cancelRevisedSO['ma_khach_hang'],
                        $this->cancelRevisedSO['so']
                    ];

                    $user = User::permission('approve_2_cancel_revised_so')->first();
    
                    Mail::to($user->email)->send(new CancelRevisedSOEmail($array));
    
                    flash()->addSuccess('Duyệt phiếu thành công.');
                    $this->resetInputField();
                    $this->emit('closeModal');
                    $this->state = 'main';
                });
            }else{

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('closeModal');
                $this->resetInputField();
                return;

            }
        }elseif($item->status == 'Sale Approved'){
            if(Auth::user()->hasPermissionTo('approve_2_cancel_revised_so')){
                DB::transaction(function() use ($item){
                    $item->sale_manager_approve = Auth::user()->username;
                    $item->sale_manager_approve_at = Carbon::now();
                    $item->status = 'SM Approved';
                    $item->updated_at = Carbon::now();
                    $item->save();

                    $itemLog = new CancelRevisedSOLog();
                    $itemLog->cancel_revised_so_id = $item->id;
                    $itemLog->so_phieu = $item->so_phieu;
                    $itemLog->ten_khach_hang = $item->ten_khach_hang;
                    $itemLog->ma_khach_hang = $item->ma_khach_hang;
                    $itemLog->so = $item->so;
                    $itemLog->date = $item->date;
                    $itemLog->san_xuat_moi = $item->san_xuat_moi;
                    $itemLog->ton_kho = $item->ton_kho;
                    $itemLog->being_processed = $item->being_processed;
                    $itemLog->open = $item->open;
                    $itemLog->cancel_order = $item->cancel_order;
                    $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
                    $itemLog->old_date = $item->old_date;
                    $itemLog->new_date = $item->new_date;
                    $itemLog->cb_revised_qty = $item->cb_revised_qty;
                    $itemLog->revised_qty = $item->revised_qty;
                    $itemLog->cb_incoterms = $item->cb_incoterms;
                    $itemLog->incoterms = $item->incoterms;
                    $itemLog->cb_payment_terms = $item->cb_payment_terms;
                    $itemLog->payment_terms = $item->payment_terms;
                    $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
                    $itemLog->shipment_plan = $item->shipment_plan;
                    $itemLog->cb_output_tax = $item->cb_output_tax;
                    $itemLog->output_tax = $item->output_tax;
                    $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
                    $itemLog->bill_to_party = $item->bill_to_party;
                    $itemLog->cb_po_number = $item->cb_po_number;
                    $itemLog->po_number = $item->po_number;
                    $itemLog->cb_order_reason = $item->cb_order_reason;
                    $itemLog->order_reason = $item->order_reason;
                    $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
                    $itemLog->reason_for_reject = $item->reason_for_reject;
                    $itemLog->cb_internal_order = $item->cb_internal_order;
                    $itemLog->internal_order = $item->internal_order;
                    $itemLog->cb_tolerance = $item->cb_tolerance;
                    $itemLog->tolerance = $item->tolerance;
                    $itemLog->other_reason = $item->other_reason;
                    $itemLog->sale_phu_trach = $item->sale_phu_trach;
                    $itemLog->status = 'Approve';
                    $itemLog->created_user = Auth::user()->username;
                    $itemLog->updated_user = Auth::user()->username;
                    $itemLog->save();

                    $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

                    foreach ($this->cancelRevisedSOItem as $key => $value) {
                        $repeatLog = new CancelRevisedSOItemLog();
                        $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                        $repeatLog->old_item = $value->old_item;
                        $repeatLog->new_item = $value->new_item;
                        $repeatLog->description = $value->description;
                        $repeatLog->old_qty = $value->old_qty;
                        $repeatLog->new_qty = $value->new_qty;
                        $repeatLog->save();
                    }

                    $array = [
                        'SM Approved',
                        $this->cancelRevisedSO['ten_khach_hang'],
                        $this->cancelRevisedSO['ma_khach_hang'],
                        $this->cancelRevisedSO['so']
                    ];

                    $user = User::permission('approve_3_cancel_revised_so')->first();

                    Mail::to($user->email)->send(new CancelRevisedSOEmail($array));

                    flash()->addSuccess('Duyệt phiếu thành công.');
                    $this->resetInputField();
                    $this->emit('closeModal');
                    $this->state = 'main';
                });
            }else{

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('closeModal');
                $this->resetInputField();
                return;

            }
        }elseif($item->status == 'SM Approved'){
            if(Auth::user()->hasPermissionTo('approve_3_cancel_revised_so')){
                DB::transaction(function() use ($item){
                    $item->khst_approve = Auth::user()->username;
                    $item->khst_approve_at = Carbon::now();
                    $item->status = 'KHST Approved';
                    $item->updated_at = Carbon::now();
                    $item->save();

                    $itemLog = new CancelRevisedSOLog();
                    $itemLog->cancel_revised_so_id = $item->id;
                    $itemLog->so_phieu = $item->so_phieu;
                    $itemLog->ten_khach_hang = $item->ten_khach_hang;
                    $itemLog->ma_khach_hang = $item->ma_khach_hang;
                    $itemLog->so = $item->so;
                    $itemLog->date = $item->date;
                    $itemLog->san_xuat_moi = $item->san_xuat_moi;
                    $itemLog->ton_kho = $item->ton_kho;
                    $itemLog->being_processed = $item->being_processed;
                    $itemLog->open = $item->open;
                    $itemLog->cancel_order = $item->cancel_order;
                    $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
                    $itemLog->old_date = $item->old_date;
                    $itemLog->new_date = $item->new_date;
                    $itemLog->cb_revised_qty = $item->cb_revised_qty;
                    $itemLog->revised_qty = $item->revised_qty;
                    $itemLog->cb_incoterms = $item->cb_incoterms;
                    $itemLog->incoterms = $item->incoterms;
                    $itemLog->cb_payment_terms = $item->cb_payment_terms;
                    $itemLog->payment_terms = $item->payment_terms;
                    $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
                    $itemLog->shipment_plan = $item->shipment_plan;
                    $itemLog->cb_output_tax = $item->cb_output_tax;
                    $itemLog->output_tax = $item->output_tax;
                    $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
                    $itemLog->bill_to_party = $item->bill_to_party;
                    $itemLog->cb_po_number = $item->cb_po_number;
                    $itemLog->po_number = $item->po_number;
                    $itemLog->cb_order_reason = $item->cb_order_reason;
                    $itemLog->order_reason = $item->order_reason;
                    $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
                    $itemLog->reason_for_reject = $item->reason_for_reject;
                    $itemLog->cb_internal_order = $item->cb_internal_order;
                    $itemLog->internal_order = $item->internal_order;
                    $itemLog->cb_tolerance = $item->cb_tolerance;
                    $itemLog->tolerance = $item->tolerance;
                    $itemLog->other_reason = $item->other_reason;
                    $itemLog->sale_phu_trach = $item->sale_phu_trach;
                    $itemLog->status = 'Approve';
                    $itemLog->created_user = Auth::user()->username;
                    $itemLog->updated_user = Auth::user()->username;
                    $itemLog->save();

                    $valueArray = [];

                    $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

                    foreach ($this->cancelRevisedSOItem as $key => $value) {

                        $repeatLog = new CancelRevisedSOItemLog();
                        $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                        $repeatLog->old_item = $value->old_item;
                        $repeatLog->new_item = $value->new_item;
                        $repeatLog->description = $value->description;
                        $repeatLog->old_qty = $value->old_qty;
                        $repeatLog->new_qty = $value->new_qty;
                        $repeatLog->save();

                        $valueArray[$key] = [
                            'old_item' => $value->old_item,
                            'new_item' => $value->new_item,
                            'description' => $value->description,
                            'old_qty' => $value->old_qty,
                            'new_qty' => $value->new_qty,
                        ];
                    }
    
                    $templateProcessor = new TemplateProcessor(public_path('Cancel_Revised_SO.docx'));

                    $values = [
    
                        'so_phieu' => $item->so_phieu,
                        'date' => Carbon::create($item->date)->format('d-m-Y'),
                        'ten_khach_hang' => $item->ten_khach_hang,
                        'ma_khach_hang' => $item->ma_khach_hang,
                        'so' => $item->so,
                        'old_date' => $item->old_date != null ? Carbon::create($item->old_date)->format('d-m-Y') : '.............................',
                        'new_date' => $item->new_date != null ? Carbon::create($item->new_date)->format('d-m-Y') : '.............................',
                        'revised_qty' => $item->revised_qty ?? '.............................',
                        'incoterms' => $item->incoterms ?? '.............................',
                        'payment_terms' => $item->payment_terms ?? '.............................',
                        'shipment_plan' => $item->shipment_plan ?? '.............................',
                        'output_tax' => $item->output_tax ?? '.............................',
                        'bill_to_party' => $item->bill_to_party ?? '.............................',
                        'po_number' => $item->po_number ?? '.............................',
                        'order_reason' => $item->order_reason ?? '.............................',
                        'reason_for_reject' => $item->reason_for_reject ?? '.............................',
                        'internal_order' => $item->internal_order ?? '.............................',
                        'tolerance' => $item->tolerance ?? '.............................',
                        'other_reason' => $item->other_reason ?? '.............................',
                    ];

                    if($item->being_processed == '1')
                        $templateProcessor->setImageValue('im_being_processed', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_being_processed', 'images/icons-square.png');

                    if($item->open == '1')
                        $templateProcessor->setImageValue('im_open', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_open', 'images/icons-square.png');

                    if($item->cancel_order == '1')
                        $templateProcessor->setImageValue('im_a', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_a', 'images/icons-square.png');

                    if($item->revised_latest_shipment_date == '1')
                        $templateProcessor->setImageValue('im_b', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_b', 'images/icons-square.png');
                    
                    if($item->cb_revised_qty == '1')
                        $templateProcessor->setImageValue('im_c', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_c', 'images/icons-square.png');

                    if($item->cb_incoterms == '1')
                        $templateProcessor->setImageValue('im_d', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_d', 'images/icons-square.png');

                    if($item->cb_payment_terms == '1')
                        $templateProcessor->setImageValue('im_e', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_e', 'images/icons-square.png');

                    if($item->cb_shipment_plan == '1')
                        $templateProcessor->setImageValue('im_f', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_f', 'images/icons-square.png');

                    if($item->cb_output_tax == '1')
                        $templateProcessor->setImageValue('im_g', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_g', 'images/icons-square.png');

                    if($item->cb_bill_to_party == '1')
                        $templateProcessor->setImageValue('im_h', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_h', 'images/icons-square.png');

                    if($item->cb_po_number == '1')
                        $templateProcessor->setImageValue('im_i', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_i', 'images/icons-square.png');

                    if($item->cb_order_reason == '1')
                        $templateProcessor->setImageValue('im_j', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_j', 'images/icons-square.png');

                    if($item->cb_reason_for_reject == '1')
                        $templateProcessor->setImageValue('im_k', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_k', 'images/icons-square.png');

                    if($item->cb_internal_order == '1')
                        $templateProcessor->setImageValue('im_l', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_l', 'images/icons-square.png');
                    
                    if($item->cb_tolerance == '1')
                        $templateProcessor->setImageValue('im_m', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_m', 'images/icons-square.png');

                    $templateProcessor->setValues($values);

                    $templateProcessor->cloneRowAndSetValues('old_item', $valueArray);

                    if(!Storage::disk('public')->exists('CancelRevisedSO/' . $item->so))
                        Storage::disk('public')->makeDirectory('CancelRevisedSO/' . $item->so);

                    $templateProcessor->saveAs(storage_path('app/public/CancelRevisedSO/') . $item->so . '/' . $item->id .'.docx');

                    $array = [
                        'KHST Approved',
                        $this->cancelRevisedSO['ten_khach_hang'],
                        $this->cancelRevisedSO['ma_khach_hang'],
                        $this->cancelRevisedSO['so']
                    ];

                    $user = User::permission('approve_4_cancel_revised_so')->first();

                    Mail::to($user->email)->send(new CancelRevisedSOEmail($array));

                    flash()->addSuccess('Duyệt phiếu thành công.');
                    $this->resetInputField();
                    $this->emit('closeModal');
                    $this->state = 'main';
                });
            }else{

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('closeModal');
                $this->resetInputField();
                return;

            }
        }elseif($item->status == 'KHST Approved'){
            if(Auth::user()->hasPermissionTo('approve_4_cancel_revised_so')){
                DB::transaction(function() use ($item){
                    $item->md_approve = Auth::user()->username;
                    $item->md_approve_at = Carbon::now();
                    $item->status = 'MD Approved';
                    $item->updated_at = Carbon::now();
                    $item->save();

                    $itemLog = new CancelRevisedSOLog();
                    $itemLog->cancel_revised_so_id = $item->id;
                    $itemLog->so_phieu = $item->so_phieu;
                    $itemLog->ten_khach_hang = $item->ten_khach_hang;
                    $itemLog->ma_khach_hang = $item->ma_khach_hang;
                    $itemLog->so = $item->so;
                    $itemLog->date = $item->date;
                    $itemLog->san_xuat_moi = $item->san_xuat_moi;
                    $itemLog->ton_kho = $item->ton_kho;
                    $itemLog->being_processed = $item->being_processed;
                    $itemLog->open = $item->open;
                    $itemLog->cancel_order = $item->cancel_order;
                    $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
                    $itemLog->old_date = $item->old_date;
                    $itemLog->new_date = $item->new_date;
                    $itemLog->cb_revised_qty = $item->cb_revised_qty;
                    $itemLog->revised_qty = $item->revised_qty;
                    $itemLog->cb_incoterms = $item->cb_incoterms;
                    $itemLog->incoterms = $item->incoterms;
                    $itemLog->cb_payment_terms = $item->cb_payment_terms;
                    $itemLog->payment_terms = $item->payment_terms;
                    $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
                    $itemLog->shipment_plan = $item->shipment_plan;
                    $itemLog->cb_output_tax = $item->cb_output_tax;
                    $itemLog->output_tax = $item->output_tax;
                    $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
                    $itemLog->bill_to_party = $item->bill_to_party;
                    $itemLog->cb_po_number = $item->cb_po_number;
                    $itemLog->po_number = $item->po_number;
                    $itemLog->cb_order_reason = $item->cb_order_reason;
                    $itemLog->order_reason = $item->order_reason;
                    $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
                    $itemLog->reason_for_reject = $item->reason_for_reject;
                    $itemLog->cb_internal_order = $item->cb_internal_order;
                    $itemLog->internal_order = $item->internal_order;
                    $itemLog->cb_tolerance = $item->cb_tolerance;
                    $itemLog->tolerance = $item->tolerance;
                    $itemLog->other_reason = $item->other_reason;
                    $itemLog->sale_phu_trach = $item->sale_phu_trach;
                    $itemLog->status = 'Approve';
                    $itemLog->created_user = Auth::user()->username;
                    $itemLog->updated_user = Auth::user()->username;
                    $itemLog->save();

                    $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

                    foreach ($this->cancelRevisedSOItem as $key => $value) {
                        $repeatLog = new CancelRevisedSOItemLog();
                        $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                        $repeatLog->old_item = $value->old_item;
                        $repeatLog->new_item = $value->new_item;
                        $repeatLog->description = $value->description;
                        $repeatLog->old_qty = $value->old_qty;
                        $repeatLog->new_qty = $value->new_qty;
                        $repeatLog->save();
                    }

                    $array = [
                        'MD Approved',
                        $this->cancelRevisedSO['ten_khach_hang'],
                        $this->cancelRevisedSO['ma_khach_hang'],
                        $this->cancelRevisedSO['so']
                    ];

                    $user = User::where('username', $item->created_user)->first();

                    Mail::to($user->email)
                    ->cc($item->sale_phu_trach)
                    ->send(new CancelRevisedSOEmail($array));

                    flash()->addSuccess('Duyệt phiếu thành công.');
                    $this->resetInputField();
                    $this->emit('closeModal');
                    $this->state = 'main';
                });
            }else{

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('closeModal');
                $this->resetInputField();
                return;

            }
        }elseif($item->status == 'MD Approved'){
            if(Auth::user()->email == $item->sale_phu_trach){
                DB::transaction(function() use ($item){
                    $item->finish = Auth::user()->username;
                    $item->finish_at = Carbon::now();
                    $item->status = 'Finish';
                    $item->updated_at = Carbon::now();
                    $item->save();

                    $itemLog = new CancelRevisedSOLog();
                    $itemLog->cancel_revised_so_id = $item->id;
                    $itemLog->so_phieu = $item->so_phieu;
                    $itemLog->ten_khach_hang = $item->ten_khach_hang;
                    $itemLog->ma_khach_hang = $item->ma_khach_hang;
                    $itemLog->so = $item->so;
                    $itemLog->date = $item->date;
                    $itemLog->san_xuat_moi = $item->san_xuat_moi;
                    $itemLog->ton_kho = $item->ton_kho;
                    $itemLog->being_processed = $item->being_processed;
                    $itemLog->open = $item->open;
                    $itemLog->cancel_order = $item->cancel_order;
                    $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
                    $itemLog->old_date = $item->old_date;
                    $itemLog->new_date = $item->new_date;
                    $itemLog->cb_revised_qty = $item->cb_revised_qty;
                    $itemLog->revised_qty = $item->revised_qty;
                    $itemLog->cb_incoterms = $item->cb_incoterms;
                    $itemLog->incoterms = $item->incoterms;
                    $itemLog->cb_payment_terms = $item->cb_payment_terms;
                    $itemLog->payment_terms = $item->payment_terms;
                    $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
                    $itemLog->shipment_plan = $item->shipment_plan;
                    $itemLog->cb_output_tax = $item->cb_output_tax;
                    $itemLog->output_tax = $item->output_tax;
                    $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
                    $itemLog->bill_to_party = $item->bill_to_party;
                    $itemLog->cb_po_number = $item->cb_po_number;
                    $itemLog->po_number = $item->po_number;
                    $itemLog->cb_order_reason = $item->cb_order_reason;
                    $itemLog->order_reason = $item->order_reason;
                    $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
                    $itemLog->reason_for_reject = $item->reason_for_reject;
                    $itemLog->cb_internal_order = $item->cb_internal_order;
                    $itemLog->internal_order = $item->internal_order;
                    $itemLog->cb_tolerance = $item->cb_tolerance;
                    $itemLog->tolerance = $item->tolerance;
                    $itemLog->other_reason = $item->other_reason;
                    $itemLog->sale_phu_trach = $item->sale_phu_trach;
                    $itemLog->status = 'Finish';
                    $itemLog->created_user = Auth::user()->username;
                    $itemLog->updated_user = Auth::user()->username;
                    $itemLog->save();

                    $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

                    foreach ($this->cancelRevisedSOItem as $key => $value) {
                        $repeatLog = new CancelRevisedSOItemLog();
                        $repeatLog->cancel_revised_so_log_id = $itemLog->id;
                        $repeatLog->old_item = $value->old_item;
                        $repeatLog->new_item = $value->new_item;
                        $repeatLog->description = $value->description;
                        $repeatLog->old_qty = $value->old_qty;
                        $repeatLog->new_qty = $value->new_qty;
                        $repeatLog->save();
                    }

                    flash()->addSuccess('Hoàn thành phiếu thành công.');
                    $this->resetInputField();
                    $this->emit('closeModal');
                    $this->state = 'main';
                });
            }else{

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('closeModal');
                $this->resetInputField();
                return;

            }
        }
    }

    public function rejectModal($idCancelRevisedSO){

        $this->state = 'reject';
        $this->idCancelRevisedSO = $idCancelRevisedSO;

    }

    public function reject(){

        $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();
        
        $item->reject = Auth::user()->username;
        $item->reject_at = Carbon::now();
        $item->status = 'Reject';
        $item->note = $this->noteReject;
        $item->updated_user = Auth::user()->username;
        $item->save();

        $itemLog = new CancelRevisedSOLog();
        $itemLog->cancel_revised_so_id = $item->id;
        $itemLog->so_phieu = $item->so_phieu;
        $itemLog->ten_khach_hang = $item->ten_khach_hang;
        $itemLog->ma_khach_hang = $item->ma_khach_hang;
        $itemLog->so = $item->so;
        $itemLog->date = $item->date;
        $itemLog->san_xuat_moi = $item->san_xuat_moi;
        $itemLog->ton_kho = $item->ton_kho;
        $itemLog->being_processed = $item->being_processed;
        $itemLog->open = $item->open;
        $itemLog->cancel_order = $item->cancel_order;
        $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
        $itemLog->old_date = $item->old_date;
        $itemLog->new_date = $item->new_date;
        $itemLog->cb_revised_qty = $item->cb_revised_qty;
        $itemLog->revised_qty = $item->revised_qty;
        $itemLog->cb_incoterms = $item->cb_incoterms;
        $itemLog->incoterms = $item->incoterms;
        $itemLog->cb_payment_terms = $item->cb_payment_terms;
        $itemLog->payment_terms = $item->payment_terms;
        $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
        $itemLog->shipment_plan = $item->shipment_plan;
        $itemLog->cb_output_tax = $item->cb_output_tax;
        $itemLog->output_tax = $item->output_tax;
        $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
        $itemLog->bill_to_party = $item->bill_to_party;
        $itemLog->cb_po_number = $item->cb_po_number;
        $itemLog->po_number = $item->po_number;
        $itemLog->cb_order_reason = $item->cb_order_reason;
        $itemLog->order_reason = $item->order_reason;
        $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
        $itemLog->reason_for_reject = $item->reason_for_reject;
        $itemLog->cb_internal_order = $item->cb_internal_order;
        $itemLog->internal_order = $item->internal_order;
        $itemLog->cb_tolerance = $item->cb_tolerance;
        $itemLog->tolerance = $item->tolerance;
        $itemLog->other_reason = $item->other_reason;
        $itemLog->sale_phu_trach = $item->sale_phu_trach;
        $itemLog->status = 'Reject';
        $itemLog->note = $this->noteReject;
        $itemLog->created_user = Auth::user()->username;
        $itemLog->updated_user = Auth::user()->username;
        $itemLog->save();

        $cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

        foreach ($cancelRevisedSOItem as $key => $value) {
            $repeatLog = new CancelRevisedSOItemLog();
            $repeatLog->cancel_revised_so_log_id = $itemLog->id;
            $repeatLog->old_item = $value->old_item;
            $repeatLog->new_item = $value->new_item;
            $repeatLog->description = $value->description;
            $repeatLog->old_qty = $value->old_qty;
            $repeatLog->new_qty = $value->new_qty;
            $repeatLog->save();
        }

        flash()->addSuccess('Reject phiếu thành công.');
        $this->resetInputField();
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function deleteModal($idCancelRevisedSO){

        $this->state = 'delete';
        $this->idCancelRevisedSO = $idCancelRevisedSO;

    }

    public function delete(){

        $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();
        $item->is_delete = '1';
        $item->updated_user = Auth::user()->username;
        $item->save();

        $itemLog = new CancelRevisedSOLog();
        $itemLog->cancel_revised_so_id = $item->id;
        $itemLog->so_phieu = $item->so_phieu;
        $itemLog->ten_khach_hang = $item->ten_khach_hang;
        $itemLog->ma_khach_hang = $item->ma_khach_hang;
        $itemLog->so = $item->so;
        $itemLog->date = $item->date;
        $itemLog->san_xuat_moi = $item->san_xuat_moi;
        $itemLog->ton_kho = $item->ton_kho;
        $itemLog->being_processed = $item->being_processed;
        $itemLog->open = $item->open;
        $itemLog->cancel_order = $item->cancel_order;
        $itemLog->revised_latest_shipment_date = $item->revised_latest_shipment_date;
        $itemLog->old_date = $item->old_date;
        $itemLog->new_date = $item->new_date;
        $itemLog->cb_revised_qty = $item->cb_revised_qty;
        $itemLog->revised_qty = $item->revised_qty;
        $itemLog->cb_incoterms = $item->cb_incoterms;
        $itemLog->incoterms = $item->incoterms;
        $itemLog->cb_payment_terms = $item->cb_payment_terms;
        $itemLog->payment_terms = $item->payment_terms;
        $itemLog->cb_shipment_plan = $item->cb_shipment_plan;
        $itemLog->shipment_plan = $item->shipment_plan;
        $itemLog->cb_output_tax = $item->cb_output_tax;
        $itemLog->output_tax = $item->output_tax;
        $itemLog->cb_bill_to_party = $item->cb_bill_to_party;
        $itemLog->bill_to_party = $item->bill_to_party;
        $itemLog->cb_po_number = $item->cb_po_number;
        $itemLog->po_number = $item->po_number;
        $itemLog->cb_order_reason = $item->cb_order_reason;
        $itemLog->order_reason = $item->order_reason;
        $itemLog->cb_reason_for_reject = $item->cb_reason_for_reject;
        $itemLog->reason_for_reject = $item->reason_for_reject;
        $itemLog->cb_internal_order = $item->cb_internal_order;
        $itemLog->internal_order = $item->internal_order;
        $itemLog->cb_tolerance = $item->cb_tolerance;
        $itemLog->tolerance = $item->tolerance;
        $itemLog->other_reason = $item->other_reason;
        $itemLog->sale_phu_trach = $item->sale_phu_trach;
        $itemLog->status = 'Xóa';
        $itemLog->created_user = Auth::user()->username;
        $itemLog->updated_user = Auth::user()->username;
        $itemLog->save();

        $cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

        foreach ($cancelRevisedSOItem as $key => $value) {
            $repeatLog = new CancelRevisedSOItemLog();
            $repeatLog->cancel_revised_so_log_id = $itemLog->id;
            $repeatLog->old_item = $value->old_item;
            $repeatLog->new_item = $value->new_item;
            $repeatLog->description = $value->description;
            $repeatLog->old_qty = $value->old_qty;
            $repeatLog->new_qty = $value->new_qty;
            $repeatLog->save();
        }

        flash()->addSuccess('Xóa phiếu thành công.');
        $this->resetInputField();
        $this->emit('closeModal');
        $this->state = 'main';

    }
    
    public function download($so, $id){

        return response()->download(storage_path('app/public/CancelRevisedSO/') . $so . '/' . $id . '.docx');

    }

    public function timKiem(){

        $this->state = 'timKiem';

    }

    public function render()
    {
        $danhSachAdmin = null;
        $danhSachKhachHang = null;
        $danhSachSale = null;

        if(in_array($this->state, ['main', 'timKiem'])){

            $main = DB::table('cancel_revised_s_o_s')
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->soPhieuTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.so_phieu', $this->soPhieuTimKiem);
        
                })
                ->where(function($query){
    
                    $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.ten_khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->soTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.so', $this->soTimKiem);
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->trangThaiTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.status', $this->trangThaiTimKiem);
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->adminTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.created_user', $this->adminTimKiem);
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->saleTimKiem . "' = ''");
                    $query->orWhere('cancel_revised_s_o_s.sale_phu_trach', $this->saleTimKiem);
        
                })
                ->where('is_delete', null)
                ->where(function($query){

                    if($this->tuNgay == null && $this->denNgay == null){

                        $query->whereBetween('cancel_revised_s_o_s.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);
            
                    }elseif($this->tuNgay != null && $this->denNgay != null){
                        $query->whereBetween('cancel_revised_s_o_s.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);
            
                    }elseif($this->tuNgay == null && $this->denNgay != null){
                        $query->whereBetween('cancel_revised_s_o_s.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);
            
                    }
                    elseif($this->tuNgay != null && $this->denNgay == null){
                        $query->whereBetween('cancel_revised_s_o_s.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);
            
                    }

                })
                
            ->paginate($this->paginate);
    
            session(['main' => $main]);

            $danhSachAdmin = User::permission('create_cancel_revised_so')->get();
            $danhSachSale = User::permission('approve_1_cancel_revised_so')->get();

        }elseif($this->state == 'create'){

            $danhSachKhachHang = BenB::all();
            $danhSachSale = User::role('sale')->get();

        }elseif($this->state == 'edit'){

            $danhSachKhachHang = BenB::all();
            $danhSachSale = User::role('sale')->get();
            $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

            $this->cancelRevisedSO['so_phieu'] = $item->so_phieu;
            $this->cancelRevisedSO['ten_khach_hang'] = $item->ten_khach_hang;
            $this->cancelRevisedSO['ma_khach_hang'] = $item->ma_khach_hang;
            $this->cancelRevisedSO['so'] = $item->so;
            $this->cancelRevisedSO['date'] = $item->date;
            $this->cancelRevisedSO['san_xuat_moi'] = $item->san_xuat_moi;
            $this->cancelRevisedSO['ton_kho'] = $item->ton_kho;
            $this->cancelRevisedSO['being_processed'] = $item->being_processed;
            $this->cancelRevisedSO['open'] = $item->open;
            $this->cancelRevisedSO['cancel_order'] = $item->cancel_order;
            $this->cancelRevisedSO['revised_latest_shipment_date'] = $item->revised_latest_shipment_date;
            $this->cancelRevisedSO['old_date'] = $item->old_date;
            $this->cancelRevisedSO['new_date'] = $item->new_date;
            $this->cancelRevisedSO['cb_revised_qty'] = $item->cb_revised_qty;
            $this->cancelRevisedSO['revised_qty'] = $item->revised_qty;
            $this->cancelRevisedSO['cb_incoterms'] = $item->cb_incoterms;
            $this->cancelRevisedSO['incoterms'] = $item->incoterms;
            $this->cancelRevisedSO['cb_payment_terms'] = $item->cb_payment_terms;
            $this->cancelRevisedSO['payment_terms'] = $item->payment_terms;
            $this->cancelRevisedSO['cb_shipment_plan'] = $item->shipment_plan;
            $this->cancelRevisedSO['cb_output_tax'] = $item->output_tax;
            $this->cancelRevisedSO['cb_bill_to_party'] = $item->cb_bill_to_party;
            $this->cancelRevisedSO['bill_to_party'] = $item->bill_to_party;
            $this->cancelRevisedSO['cb_po_number'] = $item->cb_po_number;
            $this->cancelRevisedSO['po_number'] = $item->po_number;
            $this->cancelRevisedSO['cb_order_reason'] = $item->cb_order_reason;
            $this->cancelRevisedSO['order_reason'] = $item->order_reason;
            $this->cancelRevisedSO['cb_reason_for_reject'] = $item->cb_reason_for_reject;
            $this->cancelRevisedSO['reason_for_reject'] = $item->reason_for_reject;
            $this->cancelRevisedSO['cb_internal_order'] = $item->cb_internal_order;
            $this->cancelRevisedSO['internal_order'] = $item->internal_order;
            $this->cancelRevisedSO['cb_tolerance'] = $item->cb_tolerance;
            $this->cancelRevisedSO['tolerance'] = $item->tolerance;
            $this->cancelRevisedSO['other_reason'] = $item->other_reason;
            $this->cancelRevisedSO['sale_phu_trach'] = $item->sale_phu_trach;

            $this->cancelRevisedSOItemEdit = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

            if($this->cancelRevisedSOItemEdit != null){
                foreach ($this->cancelRevisedSOItemEdit as $item) {
                    $this->oldItemEdit[$item->id] = $item->old_item;
                    $this->newItemEdit[$item->id] = $item->new_item;
                    $this->descriptionEdit[$item->id] = $item->description;
                    $this->oldQtyEdit[$item->id] = $item->old_qty;
                    $this->newQtyEdit[$item->id] = $item->new_qty;
                }
            }
        }elseif($this->state == 'show'){

            $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

            $this->cancelRevisedSO['so_phieu'] = $item->so_phieu;
            $this->cancelRevisedSO['ten_khach_hang'] = $item->ten_khach_hang;
            $this->cancelRevisedSO['ma_khach_hang'] = $item->ma_khach_hang;
            $this->cancelRevisedSO['so'] = $item->so;
            $this->cancelRevisedSO['date'] = Carbon::create($item->date)->isoFormat('DD/MM/YYYY');
            $this->cancelRevisedSO['san_xuat_moi'] = $item->san_xuat_moi;
            $this->cancelRevisedSO['ton_kho'] = $item->ton_kho;
            $this->cancelRevisedSO['being_processed'] = $item->being_processed;
            $this->cancelRevisedSO['open'] = $item->open;
            $this->cancelRevisedSO['cancel_order'] = $item->cancel_order;
            $this->cancelRevisedSO['revised_latest_shipment_date'] = $item->revised_latest_shipment_date;
            $this->cancelRevisedSO['old_date'] = $item->old_date != null ? Carbon::create($item->old_date)->isoFormat('DD/MM/YYYY') : '';
            $this->cancelRevisedSO['new_date'] = $item->new_date != null ? Carbon::create($item->new_date)->isoFormat('DD/MM/YYYY') : '';
            $this->cancelRevisedSO['cb_revised_qty'] = $item->cb_revised_qty;
            $this->cancelRevisedSO['revised_qty'] = $item->revised_qty;
            $this->cancelRevisedSO['cb_incoterms'] = $item->cb_incoterms;
            $this->cancelRevisedSO['incoterms'] = $item->incoterms;
            $this->cancelRevisedSO['cb_payment_terms'] = $item->cb_payment_terms;
            $this->cancelRevisedSO['payment_terms'] = $item->payment_terms;
            $this->cancelRevisedSO['cb_shipment_plan'] = $item->shipment_plan;
            $this->cancelRevisedSO['cb_output_tax'] = $item->output_tax;
            $this->cancelRevisedSO['cb_bill_to_party'] = $item->cb_bill_to_party;
            $this->cancelRevisedSO['bill_to_party'] = $item->bill_to_party;
            $this->cancelRevisedSO['cb_po_number'] = $item->cb_po_number;
            $this->cancelRevisedSO['po_number'] = $item->po_number;
            $this->cancelRevisedSO['cb_order_reason'] = $item->cb_order_reason;
            $this->cancelRevisedSO['order_reason'] = $item->order_reason;
            $this->cancelRevisedSO['cb_reason_for_reject'] = $item->cb_reason_for_reject;
            $this->cancelRevisedSO['reason_for_reject'] = $item->reason_for_reject;
            $this->cancelRevisedSO['cb_internal_order'] = $item->cb_internal_order;
            $this->cancelRevisedSO['internal_order'] = $item->internal_order;
            $this->cancelRevisedSO['cb_tolerance'] = $item->cb_tolerance;
            $this->cancelRevisedSO['tolerance'] = $item->tolerance;
            $this->cancelRevisedSO['other_reason'] = $item->other_reason;

            $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

            $this->cancelRevisedSOLog = CancelRevisedSOLog::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

        }elseif($this->state == 'approve'){

            $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

            $this->cancelRevisedSO['so_phieu'] = $item->so_phieu;
            $this->cancelRevisedSO['ten_khach_hang'] = $item->ten_khach_hang;
            $this->cancelRevisedSO['ma_khach_hang'] = $item->ma_khach_hang;
            $this->cancelRevisedSO['so'] = $item->so;
            $this->cancelRevisedSO['date'] = Carbon::create($item->date)->isoFormat('DD/MM/YYYY');
            $this->cancelRevisedSO['san_xuat_moi'] = $item->san_xuat_moi;
            $this->cancelRevisedSO['ton_kho'] = $item->ton_kho;
            $this->cancelRevisedSO['being_processed'] = $item->being_processed;
            $this->cancelRevisedSO['open'] = $item->open;
            $this->cancelRevisedSO['cancel_order'] = $item->cancel_order;
            $this->cancelRevisedSO['revised_latest_shipment_date'] = $item->revised_latest_shipment_date;
            $this->cancelRevisedSO['old_date'] = $item->old_date != null ? Carbon::create($item->old_date)->isoFormat('DD/MM/YYYY') : '';
            $this->cancelRevisedSO['new_date'] = $item->new_date != null ? Carbon::create($item->new_date)->isoFormat('DD/MM/YYYY') : '';
            $this->cancelRevisedSO['cb_revised_qty'] = $item->cb_revised_qty;
            $this->cancelRevisedSO['revised_qty'] = $item->revised_qty;
            $this->cancelRevisedSO['cb_incoterms'] = $item->cb_incoterms;
            $this->cancelRevisedSO['incoterms'] = $item->incoterms;
            $this->cancelRevisedSO['cb_payment_terms'] = $item->cb_payment_terms;
            $this->cancelRevisedSO['payment_terms'] = $item->payment_terms;
            $this->cancelRevisedSO['cb_shipment_plan'] = $item->shipment_plan;
            $this->cancelRevisedSO['cb_output_tax'] = $item->output_tax;
            $this->cancelRevisedSO['cb_bill_to_party'] = $item->cb_bill_to_party;
            $this->cancelRevisedSO['bill_to_party'] = $item->bill_to_party;
            $this->cancelRevisedSO['cb_po_number'] = $item->cb_po_number;
            $this->cancelRevisedSO['po_number'] = $item->po_number;
            $this->cancelRevisedSO['cb_order_reason'] = $item->cb_order_reason;
            $this->cancelRevisedSO['order_reason'] = $item->order_reason;
            $this->cancelRevisedSO['cb_reason_for_reject'] = $item->cb_reason_for_reject;
            $this->cancelRevisedSO['reason_for_reject'] = $item->reason_for_reject;
            $this->cancelRevisedSO['cb_internal_order'] = $item->cb_internal_order;
            $this->cancelRevisedSO['internal_order'] = $item->internal_order;
            $this->cancelRevisedSO['cb_tolerance'] = $item->cb_tolerance;
            $this->cancelRevisedSO['tolerance'] = $item->tolerance;
            $this->cancelRevisedSO['other_reason'] = $item->other_reason;

            $this->cancelRevisedSOItem = CancelRevisedSOItem::where('cancel_revised_so_id', $this->idCancelRevisedSO)->get();

        }elseif($this->state == 'delete'){

            $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

            $this->cancelRevisedSO['so_phieu'] = $item->so_phieu;
            $this->cancelRevisedSO['ten_khach_hang'] = $item->ten_khach_hang;
            $this->cancelRevisedSO['ma_khach_hang'] = $item->ma_khach_hang;
            $this->cancelRevisedSO['so'] = $item->so;

        }elseif($this->state == 'reject'){

            $item = CancelRevisedSO::where('id', $this->idCancelRevisedSO)->first();

            $this->cancelRevisedSO['so_phieu'] = $item->so_phieu;
            $this->cancelRevisedSO['ten_khach_hang'] = $item->ten_khach_hang;
            $this->cancelRevisedSO['ma_khach_hang'] = $item->ma_khach_hang;
            $this->cancelRevisedSO['so'] = $item->so;

        }

        return view('livewire.cancle-revised-so', compact('danhSachAdmin', 'danhSachKhachHang', 'danhSachSale'));
    }
}
