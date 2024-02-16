<?php

namespace App\Http\Livewire;

use App\Mail\TTDHMail;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TTDH extends Component
{
    use WithFileUploads;

    public $state;

    public $buyer, $buyerType, $buyerCode, $consignee, $agency, $brand, $tc, $co, $incoterms, $paymentTerms, $validityOfDelivery, $validityOfPayment,
            $application, $coneSet, $kgCone, $packing, $exchangeRate, $exchangeRateDay;

    public $hangChanHangLe, $listThongTinDongGoi;

    public $inputs = [], $i = 0;

    // public $inputsHangLe = [], $iHangLe = 0;

    public $spec, $grade, $material, $quantity, $stockInYear, $excludedVatUSD, $excludedVatVND, $zpr0USD, $zpr0VND, $listPrice;

    public $checkBoxTransportation, $checkBoxSmallCone, $checkBoxUnload, $checkBoxBanking, $checkBoxPallet, $checkBoxCommission, $checkBoxMangCo, $checkBoxClaim, $checkBoxTC, $checkBoxOther;

    public $tranFeeUSD, $tranFeeVND, $smallConeUSD, $smallConeVND, $unloadUSD, $unloadVND, $bankingUSD, $bankingVND, $palletUSD, $palletVND, $commissionUSD, $commissionVND, 
            $mangCoUSD, $mangCoVND, $claimUSD, $claimVND, $tcUSD, $tcVND, $nameOtherFee, $otherUSD, $otherVND;



    public $soPhieu, $uncheckData, $soThapPhan, $danhSachMailSale, $danhSachMailSaleAll , $fileExcel, $dataFileExcel, $dataFileExcelUnique, $note;

    public $buyerName, $commission, $endUse, $fabricConstruction, $_1setOfYarn, $paymentDate, $deliveryDate, $brandName, $truckFee;
    
    public $mailSale, $mailPhu1, $mailPhu2;

    public $validFrom, $validTo;

    public $khachHang;

    public $search, $tuNgay, $denNgay,$canhan_tatca, $paginate, $log;

    public $reject, $detail;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->soThapPhan = 3;
        $this->uncheckData = 0;
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

        $this->buyer = null;
        $this->buyerCode = null;
        $this->consignee = null;
        $this->agency = null;
        $this->brand = null;
        $this->tc = null;
        $this->co = null;
        $this->incoterms = null;
        $this->paymentTerms = null;
        $this->validityOfDelivery = null;
        $this->validityOfPayment = null;
        $this->application = null;
        $this->coneSet = null;
        $this->kgCone = null;
        $this->packing = null;
        $this->inputs = [];
        $this->i = 0;
        $this->spec = null;
        $this->grade = null;
        $this->material = null;
        $this->quantity = null;
        $this->excludedVatUSD = null;
        $this->excludedVatVND = null;
        $this->zpr0USD = null;
        $this->zpr0VND = null;
        $this->listPrice = null;
        $this->stockInYear = null;

        $this->checkBoxTransportation = null;
        $this->checkBoxSmallCone = null;
        $this->checkBoxUnload = null;
        $this->checkBoxBanking = null;
        $this->checkBoxPallet = null;
        $this->checkBoxCommission = null;
        $this->checkBoxMangCo = null;
        $this->checkBoxClaim = null;
        $this->checkBoxTC = null;
        $this->checkBoxOther = null;

        $this->checkBoxClick();

        $this->buyerName = '';
        $this->consignee = '';
        $this->commission = '';
        $this->endUse = '';
        $this->fabricConstruction = '';
        $this->_1setOfYarn = '';
        $this->incoterms = '';
        $this->paymentTerms = '';
        $this->paymentDate = '';
        $this->deliveryDate = '';
        $this->brandName = '';
        $this->packing = '';
        $this->truckFee = '';
        $this->tc = '';
        $this->co = '';
        $this->mailSale = '';
        $this->mailPhu1 = '';
        $this->mailPhu2 = '';
        $this->note = '';
        $this->fileExcel = null;
        $this->dataFileExcel = null;
        $this->reject = '';

    }

    // TDG NEW

    public function checkBoxClick(){

        if($this->checkBoxTransportation == null){

            $this->tranFeeUSD = '';
            $this->tranFeeVND = '';

        }

        if($this->checkBoxSmallCone == null){

            $this->smallConeUSD = '';
            $this->smallConeVND = '';

        }

        if($this->checkBoxUnload == null){

            $this->unloadUSD = '';
            $this->unloadVND = '';

        }

        if($this->checkBoxBanking == null){

            $this->bankingUSD = '';
            $this->bankingVND = '';

        }

        if($this->checkBoxPallet == null){

            $this->palletUSD = '';
            $this->palletVND = '';

        }

        if($this->checkBoxCommission == null){

            $this->commissionUSD = '';
            $this->commissionVND = '';

        }

        if($this->checkBoxMangCo == null){

            $this->mangCoUSD = '';
            $this->mangCoVND = '';

        }

        if($this->checkBoxClaim == null){

            $this->claimUSD = '';
            $this->claimVND = '';

        }

        if($this->checkBoxTC == null){

            $this->tcUSD = '';
            $this->tcVND = '';

        }

        if($this->checkBoxOther == null){

            $this->nameOtherFee = '';
            $this->otherUSD = '';
            $this->otherVND = '';

        }

    }

    public function createTTDHNewVersionModal(){

        $this->state = 'create';
        $this->hangChanHangLe = 'hangChan';
        $this->buyerType = 'local';
        array_push($this->inputs ,0);

    }

    public function createTTDHNewVersion(){

        if($this->mailSale == ''){

            sweetalert()->addError('Chưa chọn Sale.');
            return;

        }

        if($this->hangChanHangLe == 'hangLe'){

            if($this->fileExcel == null){

                sweetalert()->addError('Thao tác quá nhanh, vui lòng thực hiện lại thao tác "Load Excel".');
                return;
    
            }
        }

        $contentMailQuyCach = '';

        $buyer = $this->buyer;

        if ($this->buyerType == 'export' || $this->buyerType == 'localexport') {

            foreach ($this->spec as $key => $value) {

                $this->zpr0USD[$key] = round((float)$this->excludedVatUSD[$key]
                    - (float)$this->tranFeeUSD
                    - (float)$this->smallConeUSD
                    - (float)$this->unloadUSD
                    - (float)$this->bankingUSD
                    - (float)$this->palletUSD
                    - (float)$this->commissionUSD
                    - (float)$this->mangCoUSD
                    - (float)$this->claimUSD
                    - (float)$this->tcUSD
                    - (float)$this->otherUSD,(int)$this->soThapPhan);
            }

        } elseif ($this->buyerType == 'local'){

            if($this->checkBoxTransportation == '1'){

                if($this->tranFeeUSD != '' && $this->tranFeeVND == ''){
    
                    $this->tranFeeVND = number_format($this->tranFeeUSD * $this->exchangeRate);
    
                }elseif($this->tranFeeUSD == '' && $this->tranFeeVND != ''){
    
                    $this->tranFeeUSD = number_format($this->tranFeeVND / $this->exchangeRate);
    
                }elseif($this->tranFeeUSD == '' && $this->tranFeeVND == ''){
                
                    sweetalert()->addError('Chưa nhập Transportation fee.');
                    return;
    
                }
            }
    
            if($this->checkBoxSmallCone == '1'){
    
                if($this->smallConeUSD != '' && $this->smallConeVND == ''){
    
                    $this->smallConeVND = number_format($this->smallConeUSD * $this->exchangeRate);
    
                }elseif($this->smallConeUSD == '' && $this->smallConeVND != ''){
    
                    $this->smallConeUSD = number_format($this->smallConeVND / $this->exchangeRate);
    
                }elseif($this->smallConeUSD == '' && $this->smallConeVND == ''){
                
                    sweetalert()->addError('Chưa nhập Small cone fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxUnload == '1'){
    
                if($this->unloadUSD != '' && $this->unloadVND == ''){
    
                    $this->unloadVND = number_format($this->unloadUSD * $this->exchangeRate);
    
                }elseif($this->unloadUSD == '' && $this->unloadVND != ''){
    
                    $this->unloadUSD = number_format($this->unloadVND / $this->exchangeRate);
    
                }elseif($this->unloadUSD == '' && $this->unloadVND == ''){
                
                    sweetalert()->addError('Chưa nhập Unload fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxBanking == '1'){
    
                if($this->bankingUSD != '' && $this->bankingVND == ''){
    
                    $this->bankingVND = number_format($this->bankingUSD * $this->exchangeRate);
    
                }elseif($this->bankingUSD == '' && $this->bankingVND != ''){
    
                    $this->bankingUSD = number_format($this->bankingVND / $this->exchangeRate);
    
                }elseif($this->bankingUSD == '' && $this->bankingVND == ''){
                
                    sweetalert()->addError('Chưa nhập Banking fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxPallet == '1'){
    
                if($this->palletUSD != '' && $this->palletVND == ''){
    
                    $this->palletVND = number_format($this->palletUSD * $this->exchangeRate);
    
                }elseif($this->palletUSD == '' && $this->palletVND != ''){
    
                    $this->palletUSD = number_format($this->palletVND / $this->exchangeRate);
    
                }elseif($this->palletUSD == '' && $this->palletVND == ''){
                
                    sweetalert()->addError('Chưa nhập Pallet fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxCommission == '1'){
    
                if($this->commissionUSD != '' && $this->commissionVND == ''){
    
                    $this->commissionVND = number_format($this->commissionUSD * $this->exchangeRate);
    
                }elseif($this->commissionUSD == '' && $this->commissionVND != ''){
    
                    $this->commissionUSD = number_format($this->commissionVND / $this->exchangeRate);
    
                }elseif($this->commissionUSD == '' && $this->commissionVND == ''){
                
                    sweetalert()->addError('Chưa nhập Commission fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxMangCo == '1'){
    
                if($this->mangCoUSD != '' && $this->mangCoVND == ''){
    
                    $this->mangCoVND = number_format($this->mangCoUSD * $this->exchangeRate);
    
                }elseif($this->mangCoUSD == '' && $this->mangCoVND != ''){
    
                    $this->mangCoUSD = number_format($this->mangCoVND / $this->exchangeRate);
    
                }elseif($this->mangCoUSD == '' && $this->mangCoVND == ''){
                
                    sweetalert()->addError('Chưa nhập Mang Co fee.');
                    return;
    
                }
    
    
            }
    
            if($this->checkBoxClaim == '1'){
    
                if($this->claimUSD != '' && $this->claimVND == ''){
    
                    $this->claimVND = number_format($this->claimUSD * $this->exchangeRate);
    
                }elseif($this->claimUSD == '' && $this->claimVND != ''){
    
                    $this->claimUSD = number_format($this->claimVND / $this->exchangeRate);
    
                }elseif($this->claimUSD == '' && $this->claimVND == ''){
                
                    sweetalert()->addError('Chưa nhập Claim fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxTC == '1'){
    
                if($this->tcUSD != '' && $this->tcVND == ''){
    
                    $this->tcVND = number_format($this->tcUSD * $this->exchangeRate);
    
                }elseif($this->tcUSD == '' && $this->tcVND != ''){
    
                    $this->tcUSD = number_format($this->tcVND / $this->exchangeRate);
    
                }elseif($this->tcUSD == '' && $this->tcVND == ''){
                
                    sweetalert()->addError('Chưa nhập TC fee.');
                    return;
    
                }
    
            }
    
            if($this->checkBoxOther == '1'){
    
                if($this->otherUSD != '' && $this->otherVND == ''){
    
                    $this->otherVND = number_format($this->otherUSD * $this->exchangeRate);
    
                }elseif($this->otherUSD == '' && $this->otherVND != ''){
    
                    $this->otherUSD = number_format($this->otherVND / $this->exchangeRate);
    
                }elseif($this->otherUSD == '' && $this->otherVND == ''){
                
                    sweetalert()->addError('Chưa nhập TC fee.');
                    return;
    
                }
    
            }

            foreach ($this->spec as $key => $value) {

                // Tính toán  excluded VAT price(VND), Excluded VAT price(USD)
                if($this->excludedVatVND == null || ( $this->excludedVatVND != null && !array_key_exists($key, $this->excludedVatVND))){

                    $this->excludedVatVND[$key] = round((float)$this->excludedVatUSD[$key] * (float)$this->exchangeRate,$this->soThapPhan);

                }

                // Tính toán Zpr0 (VND)
                if($this->zpr0VND == null || ( $this->zpr0VND != null && !array_key_exists($key, $this->zpr0VND))){

                    $this->zpr0VND[$key] = round((float)$this->excludedVatVND[$key]
                    - (float)$this->tranFeeVND
                    - (float)$this->smallConeVND
                    - (float)$this->unloadVND
                    - (float)$this->bankingVND
                    - (float)$this->palletVND
                    - (float)$this->commissionVND
                    - (float)$this->mangCoVND
                    - (float)$this->claimVND
                    - (float)$this->tcVND
                    - (float)$this->otherVND,(int)$this->soThapPhan);

                }
                

                // Tính toán Zpr0 (USD)
                if($this->zpr0USD == null || ( $this->zpr0USD != null && !array_key_exists($key, $this->zpr0USD))){

                    $this->zpr0USD[$key] = round((float)$this->excludedVatUSD[$key]
                    - (float)$this->tranFeeUSD
                    - (float)$this->smallConeUSD
                    - (float)$this->unloadUSD
                    - (float)$this->bankingUSD
                    - (float)$this->palletUSD
                    - (float)$this->commissionUSD
                    - (float)$this->mangCoUSD
                    - (float)$this->claimUSD
                    - (float)$this->tcUSD
                    - (float)$this->otherUSD,(int)$this->soThapPhan);

                }

            }

        }

        // Lấy Stran Fee

        $tran = '';

        if($this->checkBoxTransportation == '1'){

            if($this->tranFeeVND != ''){

                $tran = "<br />Transportation fee: " . $this->tranFeeVND;

            }elseif($this->tranFeeUSD != '' && $this->tranFeeVND == ''){

                $tran = "<br />Transportation fee: " . $this->tranFeeUSD;

            }

        }

        // Lấy Small cone Fee
        $small = '';

        if($this->checkBoxSmallCone == '1'){

            if($this->smallConeVND != ''){

                $small = "<br />Small cone fee: " . $this->smallConeVND;

            }elseif($this->smallConeUSD != '' && $this->smallConeVND == ''){

                $small = "<br />Small cone fee: " . $this->smallConeUSD;

            }

        }

        // Lấy Unload fee

        $unload = '';
        if($this->checkBoxUnload == '1'){

            if($this->unloadVND != ''){

                $unload = "<br />Unload fee: " . $this->unloadVND;

            }elseif($this->unloadUSD != '' && $this->unloadVND == ''){

                $unload = "<br />Unload fee: " . $this->unloadUSD;

            }

        }

        // Lấy Banking fee

        $banking = '';

        if($this->checkBoxBanking == '1'){

            if($this->bankingVND != ''){

                $banking = "<br />Banking fee: " . $this->bankingVND;

            }elseif($this->bankingUSD != '' && $this->bankingVND == ''){

                $banking = "<br />Banking fee: " . $this->bankingUSD;

            }

        }

         // Lấy Pallet fee

         $pallet = '';

        if($this->checkBoxPallet == '1'){

            if($this->palletVND != ''){

                $pallet = "<br />Pallet fee: " . $this->palletVND;

            }elseif($this->palletUSD != '' && $this->palletVND == ''){

                $pallet = "<br />Pallet fee: " . $this->palletUSD;

            }

        }

        // Lấy Commission fee

        $commission = '';

        if($this->checkBoxCommission == '1'){

            if($this->commissionVND != ''){

                $commission = "<br />Commission fee: " . $this->commissionVND;

            }elseif($this->commissionUSD != '' && $this->commissionVND == ''){

                $commission = "<br />Commission fee: " . $this->commissionUSD;

            }

        }

        // Lấy Mang co fee

        $mangCo = '';

        if($this->checkBoxMangCo == '1'){

            if($this->mangCoVND != ''){

                $mangCo = "<br />Mang co fee: " . $this->mangCoVND;

            }elseif($this->mangCoUSD != '' && $this->mangCoVND == ''){

                $mangCo = "<br />Mang co fee: " . $this->mangCoUSD;

            }

        }

        // Lấy Claim fee

        $claim = '';

        if($this->checkBoxClaim == '1'){

            if($this->claimVND != ''){

                $claim = "<br />Claim fee: " . $this->claimVND;

            }elseif($this->claimUSD != '' && $this->claimVND == ''){

                $claim = "<br />Claim fee: " . $this->claimUSD;

            }

        }

        // Lấy TC fee

        $tc = '';

        if($this->checkBoxTC == '1'){

            if($this->tcVND != ''){

                $tc = "<br />TC fee: " . $this->tcVND;

            }elseif($this->tcUSD != '' && $this->tcVND == ''){

                $tc = "<br />TC fee: " . $this->tcUSD;

            }

        }

        // Lấy Other fee

        $other = '';

        if($this->checkBoxOther == '1'){

            if($this->otherVND != ''){

                $other = "<br />" . $this->nameOtherFee . ": " . $this->otherVND;

            }elseif($this->otherUSD != '' && $this->otherVND == ''){

                $other = "<br />" . $this->nameOtherFee . ": " . $this->otherUSD;

            }

        }

        $ZproTemp = '';

        foreach ($this->spec as $key => $value) {

            if($this->buyerType == 'export' || $this->buyerType == 'localexport'){

                $excluded = $this->excludedVatUSD[$key] . " usd/kg => ";

                $zpr0 = "Zpr0= " . $this->zpr0USD[$key];

            } elseif ($this->buyerType == 'local'){

                $excluded = number_format($this->excludedVatVND[$key]) . " vnd/kg => ";

                $zpr0 = "Zpr0= " . number_format($this->zpr0VND[$key]);

            }

            $contentMailQuyCach = $contentMailQuyCach . "<br />" . $this->spec[$key] . ' - ' . $this->grade[$key] . ' Grade - ' . $excluded . $zpr0;

            // Lấy Zpr0

            if($key == 0){

                $ZproTemp = "<br />USD~" . $this->zpr0USD[$key];

            }else{

                $ZproTemp = $ZproTemp . ', ' . $this->zpr0USD[$key];

            }   

            // Lấy Stock in year

            $stockInYearArray = [];

            $stockInYear = '';

            if($this->stockInYear != null){

                foreach ($this->spec as $key => $value) {
                
                    if( array_key_exists($key, $this->stockInYear)){
    
                        array_push($stockInYearArray, $this->stockInYear[$key]);
    
                    }
    
                }   
    
                if(count($stockInYearArray) > 0){
    
                    $stockInYearArray = array_unique($stockInYearArray);
                    sort($stockInYearArray);
    
                    $stockInYear = implode('-',$stockInYearArray);
    
                }

            }
        
        }

        $contentMailFinish = '<span style="color: #0431B4;font-size:16px">'.'Dear Sir or Madam<br />' . "Please kindly approve " . $buyer . " special price<br />" . $contentMailQuyCach
            . $ZproTemp . $tran . $small . $unload . $banking . $pallet . $commission . $mangCo . $claim . $tc . $other . '<br />' . $stockInYear . '<br />' . $this->note . '</span><br /><br />';

        $this->soPhieu = IdGenerator::generate(['table' => 'phieu_ttdh', 'field' => 'so_phieu', 'length' => '14', 'prefix' => 'TTDH-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);

        DB::transaction(function() use($contentMailFinish) {

            foreach ($this->spec as $key=>$value) {
            
                DB::table('phieu_ttdh')->insert([

                    'so_phieu' => $this->soPhieu,
                    'customer' => $this->buyer,
                    'customer_no' => $this->buyerCode,
                    'consignee' => $this->consignee,
                    'agency' => $this->agency,
                    'brand' => $this->brand,
                    'tc' => $this->tc,
                    'co' => $this->co,
                    'incoterms' => $this->incoterms,
                    'payment_terms' => $this->paymentTerms,
                    'validity_of_delivery' => $this->validityOfDelivery,
                    'validity_of_payment' => $this->validityOfPayment,
                    'application' => $this->application,
                    'cone_set' => $this->coneSet,
                    'kg_cone' => $this->kgCone,
                    'packing' => $this->packing,

                    'spec' => $this->spec[$key] ?? null,
                    'grade' => $this->grade[$key] ?? null,
                    'material' => $this->material[$key] ?? null,
                    'qty' => $this->quantity[$key] ?? null,
                    'excluded_usd' => $this->excludedVatUSD[$key] ?? null,
                    'excluded_vnd' => $this->excludedVatVND[$key] ?? null,
                    'zpr0_usd' => $this->zpr0USD[$key] ?? null,
                    'zpr0_vnd' => $this->zpr0VND[$key] ?? null,
                    'listprice' => $this->listPrice[$key] ?? null,
                    'stockinyear' => $this->stockInYear[$key] ?? null,
                    'stran_usd' => $this->tranFeeUSD,
                    'stran_vnd' => $this->tranFeeVND,
                    'small_usd' => $this->smallConeUSD,
                    'small_vnd' => $this->smallConeVND,
                    'unload_usd' => $this->unloadUSD,
                    'unload_vnd' => $this->unloadVND,
                    'banking_usd' => $this->bankingUSD,
                    'banking_vnd' => $this->bankingVND,
                    'pl_usd' => $this->palletUSD,
                    'pl_vnd' => $this->palletVND,
                    'comm_usd' => $this->commissionUSD,
                    'comm_vnd' => $this->commissionVND,
                    'mang_co_usd' => $this->mangCoUSD,
                    'mang_co_vnd' => $this->mangCoVND,
                    'claim_usd' => $this->claimUSD,
                    'claim_vnd' => $this->claimVND,
                    'tc_usd' => $this->tcUSD,
                    'tc_vnd' => $this->tcVND,
                    'name_other' => $this->nameOtherFee,
                    'other_usd' => $this->otherUSD,
                    'other_vnd' => $this->otherVND,
                    'payment' => $this->paymentTerms,
                    'exchange' => $this->exchangeRate,
                    // 'customer_type' => $this->customerType,
                    // 'delivery_term' => $this->deliveryTerm,
                    // 'cs' => $this->cs,
                    // 'valid_from' => $this->validFrom,
                    // 'valid_to' => $this->validTo,
                    'new' => Auth::user()->username,
                    'new_at' => Carbon::now(),
                    'status' => 'New',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            }

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $this->soPhieu,
                'status' => 'New',
                'status_log' => 'Created',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('phieu_ttdh_content')->insert([

                'so_phieu' => $this->soPhieu,
                'content' => $contentMailFinish,
                'mail_admin' => Auth::user()->email,
                'mail_to' => $this->mailSale,
                'mail_cc_1' => $this->mailPhu1,
                'mail_cc_2' => $this->mailPhu2,
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

        });

        // Tạo File Excel

        $spreadsheet = new Spreadsheet();

        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setTitle('Customer');

        $activeWorksheet->setCellValue('G1', 'TTDH Number'); $activeWorksheet->setCellValue('H1', $this->soPhieu); $activeWorksheet->setCellValue('I1', Carbon::now()->isoFormat('DD.MM.YYYY'));
        
        // Order information

        $activeWorksheet->setCellValue('A3', 'Order Information');

        $activeWorksheet->mergeCells('A3:I3');

        $activeWorksheet->setCellValue('A4', 'Buyer');
        $activeWorksheet->setCellValue('B4', 'Buyer Code');
        $activeWorksheet->setCellValue('C4', 'Buyer Type');
        $activeWorksheet->setCellValue('D4', 'Consignee');
        $activeWorksheet->setCellValue('E4', 'Agency');
        $activeWorksheet->setCellValue('F4', 'Brand');
        $activeWorksheet->setCellValue('G4', 'GRS T/C');
        $activeWorksheet->setCellValue('H4', 'C/O');

        $activeWorksheet->mergeCells('H4:I4');

        $activeWorksheet->setCellValue('A5', $this->buyer);
        $activeWorksheet->setCellValue('B5', $this->buyerCode);

        if ($this->buyerType == 'export') {

            $activeWorksheet->setCellValue('C5', 'EXPORT');

        } elseif ($this->buyerType == 'local'){

            $activeWorksheet->setCellValue('C5', 'LOCAL');

        }elseif ($this->buyerType == 'localexport'){

            $activeWorksheet->setCellValue('C5', 'LOCAL EXPORT');

        }
        
        $activeWorksheet->setCellValue('D5', $this->consignee);
        $activeWorksheet->setCellValue('E5', $this->agency);
        $activeWorksheet->setCellValue('F5', $this->brand);
        $activeWorksheet->setCellValue('G5', $this->tc);
        $activeWorksheet->setCellValue('H5', $this->co);

        $activeWorksheet->mergeCells('H5:I5');

        $activeWorksheet->setCellValue('A6', 'Incoterms 2010');
        $activeWorksheet->setCellValue('B6', 'Payment terms');
        $activeWorksheet->setCellValue('C6', 'Validity of Delivery');
        $activeWorksheet->setCellValue('D6', 'Contract Expiration Date');
        $activeWorksheet->setCellValue('E6', 'Application');
        $activeWorksheet->setCellValue('F6', 'CONE/SET');
        $activeWorksheet->setCellValue('G6', 'KG/CONE');
        $activeWorksheet->setCellValue('H6', 'PACKING');

        $activeWorksheet->mergeCells('H6:I6');

        $activeWorksheet->setCellValue('A7', $this->incoterms);
        $activeWorksheet->setCellValue('B7', $this->paymentTerms);
        $activeWorksheet->setCellValue('C7', $this->validityOfDelivery);
        $activeWorksheet->setCellValue('D7', $this->validityOfPayment);
        $activeWorksheet->setCellValue('E7', $this->application);
        $activeWorksheet->setCellValue('F7', $this->coneSet);
        $activeWorksheet->setCellValue('G7', $this->kgCone);
        $activeWorksheet->setCellValue('H7', $this->packing);

        $activeWorksheet->mergeCells('H7:I7');

        $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
        $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);

        $activeWorksheet
        ->getStyle('A3:I7')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('17202A'));

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $activeWorksheet->getStyle('A3:I7')->applyFromArray($styleArray);

        $styleArray = [
            'font' => [
                'size'  =>  9,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ];
        $activeWorksheet->getStyle('A:I')->applyFromArray($styleArray);

        $activeWorksheet->getStyle('G1:I1')->getFont()->setBold(true);

        $activeWorksheet->getStyle('A3:I4')->getFont()->setBold(true);

        $activeWorksheet->getStyle('A6:I6')->getFont()->setBold(true);

        $activeWorksheet
        ->getStyle('A3:I3')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('BFBFBF');

        // Price

        $activeWorksheet->setCellValue('A10', 'Price');

        $activeWorksheet->mergeCells('A10:I10');

        $activeWorksheet->setCellValue('A11', 'Spec');
        $activeWorksheet->setCellValue('B11', 'Grade');
        $activeWorksheet->setCellValue('C11', 'Lot Number');
        $activeWorksheet->setCellValue('D11', 'Qty (kg)');
        $activeWorksheet->setCellValue('E11', 'Contract Price (excluded VAT)');

        $activeWorksheet->mergeCells('E11:F11');

        $activeWorksheet->setCellValue('G11', 'ZPR0');
        $activeWorksheet->setCellValue('H11', 'List Price');
        $activeWorksheet->setCellValue('I11', 'Stock Year');

        $activeWorksheet->mergeCells('A11:A12');
        $activeWorksheet->mergeCells('B11:B12');
        $activeWorksheet->mergeCells('C11:C12');
        $activeWorksheet->mergeCells('D11:D12');

        $activeWorksheet->setCellValue('E12', 'USD/KG');
        $activeWorksheet->setCellValue('F12', 'VND/KG');
        $activeWorksheet->setCellValue('G12', 'USD/KG');
        $activeWorksheet->setCellValue('H12', 'VND/KG');
        $activeWorksheet->mergeCells('I11:I12');

        $currentRow = 13;

        foreach ($this->spec as $key=>$value) {

            $activeWorksheet->setCellValue('A' . $currentRow, $this->spec[$key]);
            $activeWorksheet->setCellValue('B' . $currentRow, $this->grade[$key]);

            $activeWorksheet->setCellValue('C' . $currentRow, $this->material[$key]);

            $activeWorksheet->setCellValue('D' . $currentRow, (float)$this->quantity[$key]);
            $activeWorksheet->setCellValue('E' . $currentRow, $this->excludedVatUSD[$key]);
            $activeWorksheet->setCellValue('F' . $currentRow, $this->buyerType == 'local' ? $this->excludedVatVND[$key] : '');
            $activeWorksheet->setCellValue('G' . $currentRow, $this->zpr0USD[$key] ?? '' );
            $activeWorksheet->setCellValue('H' . $currentRow, $this->listPrice[$key] ?? null);
            $activeWorksheet->setCellValue('I' . $currentRow, $this->stockInYear[$key] ?? null);

            $currentRow = $currentRow + 1;
            
        }

        $activeWorksheet->getStyle('D13:D' . $currentRow)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeWorksheet->getStyle('F13:F' . $currentRow - 1)->getNumberFormat()->setFormatCode('#,##0');
        $activeWorksheet->getStyle('D' . $currentRow + 1)->getNumberFormat()->setFormatCode('#,##0');

        $activeWorksheet
        ->getStyle('A10:I' . $currentRow - 1)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('17202A'));

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
    
        $activeWorksheet->getStyle('A10:I' . $currentRow - 1)->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A10:I12')->getFont()->setBold(true);

        $activeWorksheet
        ->getStyle('A10:I12')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('BFBFBF');

        $activeWorksheet->setCellValue('A' . $currentRow, 'Total Order Quantity (kg)');
        $activeWorksheet->mergeCells('A' . $currentRow . ':C' . $currentRow);
        $activeWorksheet->setCellValue('D' . $currentRow, '=SUM(D13:' . 'D' . $currentRow - 1 . ')');

        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Exchange Rate');
        $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':C' . $currentRow + 1);
        $activeWorksheet->setCellValue('D' . $currentRow + 1, $this->exchangeRate);
        $activeWorksheet->setCellValue('E' . $currentRow + 1, $this->exchangeRateDay);
        $activeWorksheet->mergeCells('E' . $currentRow + 1 . ':I' . $currentRow + 1);

        $activeWorksheet->getStyle('A' . $currentRow . ':D' . $currentRow + 1)->getFont()->setBold(true);
        $activeWorksheet->getStyle('A'. $currentRow . ':D' . $currentRow + 1)->getAlignment()->setHorizontal('right');
        $activeWorksheet->getStyle('E'. $currentRow + 1)->getAlignment()->setHorizontal('left');

        $currentRow = $currentRow + 1;

        $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Breakdown of Expense');
        $activeWorksheet->mergeCells('A' . $currentRow + 2 . ':C' . $currentRow + 2);

        $activeWorksheet->setCellValue('A' . $currentRow + 3, 'Total Expense');
        $activeWorksheet->mergeCells('A' . $currentRow + 3 . ':A' . $currentRow + 4);
        $activeWorksheet->setCellValue('B' . $currentRow + 3, 'USD/KG');
        $activeWorksheet->setCellValue('B' . $currentRow + 4, '=SUM(B' . $currentRow + 5 . ':B' . $currentRow + 14 . ')');
        $activeWorksheet->setCellValue('C' . $currentRow + 3, 'VND/KG');
        $activeWorksheet->setCellValue('C' . $currentRow + 4, '=SUM(C' . $currentRow + 5 . ':C' . $currentRow + 14 . ')');

        $activeWorksheet->getStyle('A' . $currentRow + 2 . ':C' . $currentRow + 4)->getFont()->setBold(true);

        $activeWorksheet->setCellValue('A' . $currentRow + 5, 'Transportation fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 6, 'Small cone fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 7, 'Unload fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 8, 'Banking fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 9, 'Pallet fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 10, 'Commission fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 11, 'Mang co fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 12, 'Claim fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 13, 'T/C fee');
        $activeWorksheet->setCellValue('A' . $currentRow + 14, $this->nameOtherFee ?? 'Other fee');

        $activeWorksheet->setCellValue('B' . $currentRow + 5, $this->tranFeeUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 6, $this->smallConeUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 7, $this->unloadUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 8, $this->bankingUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 9, $this->palletUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 10, $this->commissionUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 11, $this->mangCoUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 12, $this->claimUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 13, $this->tcUSD);
        $activeWorksheet->setCellValue('B' . $currentRow + 14, $this->otherUSD);

        $activeWorksheet->setCellValue('C' . $currentRow + 5, $this->tranFeeVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 6, $this->smallConeVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 7, $this->unloadVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 8, $this->bankingVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 9, $this->palletVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 10, $this->commissionVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 11, $this->mangCoVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 12, $this->claimVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 13, $this->tcVND);
        $activeWorksheet->setCellValue('C' . $currentRow + 14, $this->otherVND);

        $activeWorksheet->getStyle('C' . $currentRow + 5 . ':C' . $currentRow + 14)->getNumberFormat()->setFormatCode('#,##0');

        $activeWorksheet
        ->getStyle('A' . $currentRow + 2 . ':C' . $currentRow + 14)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('17202A'));

        $activeWorksheet
        ->getStyle('B' . $currentRow + 4 . ':C' . $currentRow + 4)
        ->getFont()
        ->getColor()
        ->setARGB('00BD00');

        $activeWorksheet->setCellValue('A' . $currentRow + 16, 'Note');
        $activeWorksheet->setCellValue('A' . $currentRow + 17, $this->note);

        $activeWorksheet->setCellValue('A' . $currentRow + 19, 'APPROVAL LEVEL - 01');
        $activeWorksheet->setCellValue('C' . $currentRow + 19, 'APPROVAL LEVEL - 02');
        $activeWorksheet->setCellValue('E' . $currentRow + 19, 'APPROVAL LEVEL - 03');

        $activeWorksheet->setCellValue('A' . $currentRow + 20, 'Time 1');
        $activeWorksheet->setCellValue('C' . $currentRow + 20, 'Time 2');
        $activeWorksheet->setCellValue('E' . $currentRow + 20, 'Time 3');

        $activeWorksheet->setCellValue('A' . $currentRow + 21, Auth::user()->name);
        $activeWorksheet->setCellValue('C' . $currentRow + 21, 'User 2');
        $activeWorksheet->setCellValue('E' . $currentRow + 21, 'User 3');

        $activeWorksheet->setCellValue('A' . $currentRow + 22, 'AP 1');
        $activeWorksheet->setCellValue('C' . $currentRow + 22, 'User 2');
        $activeWorksheet->setCellValue('E' . $currentRow + 22, 'User 3');

        $activeWorksheet->mergeCells('A' . $currentRow + 19 . ':B' . $currentRow + 19);
        $activeWorksheet->mergeCells('C' . $currentRow + 19 . ':D' . $currentRow + 19);
        $activeWorksheet->mergeCells('E' . $currentRow + 19 . ':F' . $currentRow + 19);

        $activeWorksheet->mergeCells('A' . $currentRow + 20 . ':B' . $currentRow + 20);
        $activeWorksheet->mergeCells('C' . $currentRow + 20 . ':D' . $currentRow + 20);
        $activeWorksheet->mergeCells('E' . $currentRow + 20 . ':F' . $currentRow + 20);

        $activeWorksheet->mergeCells('A' . $currentRow + 21 . ':B' . $currentRow + 21);
        $activeWorksheet->mergeCells('C' . $currentRow + 21 . ':D' . $currentRow + 22);
        $activeWorksheet->mergeCells('E' . $currentRow + 21 . ':F' . $currentRow + 22);

        $activeWorksheet->mergeCells('A' . $currentRow + 22 . ':B' . $currentRow + 22);
        $activeWorksheet->mergeCells('C' . $currentRow + 22 . ':D' . $currentRow + 22);

        $activeWorksheet
        ->getStyle('A' . $currentRow + 19 . ':F' . $currentRow + 22)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('17202A'));

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
    
        $activeWorksheet->getStyle('A' . $currentRow + 2 . ':C' . $currentRow + 14)->applyFromArray($styleArray);
        $activeWorksheet->getStyle('A' . $currentRow + 19 . ':F' . $currentRow + 22)->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        $path = 'TTDH/' . $this->soPhieu;

        if(!Storage::disk('ftp')->exists($path)) {

            Storage::disk('ftp')->makeDirectory($path);

        }

        Storage::disk('ftp')->put($path . '/' . $this->soPhieu . ".xlsx", $content);

        if($this->hangChanHangLe == 'hangLe'){

            Storage::disk('ftp')->put($path . '/' . $this->soPhieu . ".xlsx", $content);

            foreach ($this->fileExcel as $file){
    
                Storage::disk('ftp')->putFileAs($path, $file, $file->getClientOriginalName());
    
            }

        }
        
        $ccMail = [];

        $ccMail = array_merge($ccMail, [Auth::user()->email]);
        
        $ccMail = array_merge($ccMail, [$this->mailSale]);

        if($this->mailPhu1 != ''){

            $ccMail = array_merge($ccMail, [$this->mailPhu1]);

        }

        if($this->mailPhu2 != ''){

            $ccMail = array_merge($ccMail, [$this->mailPhu2]);

        }

        $user = User::permission('approve_1_ttdh')->first();

        Mail::to($user->email)
        ->cc($ccMail)
        ->send(new TTDHMail($this->soPhieu, 'Approve 1', $this->buyer, $contentMailFinish, Carbon::now()));

        flash()->addSuccess('Tạo TTDH thành công.');

        $this->resetInputField();

        $this->emit('createTTDHNewVersionModal');

    }

    public function loadFileExcelNew(){

        if($this->fileExcel == null){

            sweetalert()->addError('Thao tác quá nhanh, vui lòng thực hiện lại thao tác "Load Excel".');
            return;

        }else{

            $extension = pathinfo($this->fileExcel->getRealPath(), PATHINFO_EXTENSION);

            if($extension != 'xlsx'){

                sweetalert()->addError('Vui lòng Load File có định dạng .xlsx');
                return;

            }

            $data = fastexcel()->import($this->fileExcel->getRealPath());

            $data = $data->where('Spec','!=','')->where('Material','!=','');

            $this->inputs = [];

            for ($i=0; $i < $data->count() ; $i++) { 
                
                array_push($this->inputs ,$i);

            }

            foreach ($data as $key => $value) {

                $this->spec[$key] = $value['Spec'];
                $this->grade[$key] = $value['Grade'];
                $this->material[$key] = $value['Material'];
                $this->quantity[$key] = $value['Qty'];
                $this->excludedVatUSD[$key] = $value['Excluded VAT (USD)'];
                $this->excludedVatVND[$key] = $value['Excluded VAT (VND)'];
                $this->zpr0USD[$key] = $value['Zpr0 (USD)'];
                $this->zpr0VND[$key] = $value['Zpr0 (VND)'];
                $this->listPrice[$key] = $value['List price'];
                $this->stockInYear[$key] = $value['Stock in year'];

            }

        }
    }

    // ============================

    public function loadFileExcel(){
        
        if($this->fileExcel == null){

            sweetalert()->addError('Thao tác quá nhanh, vui lòng thực hiện lại thao tác "Load Excel".');
            return;

        }else{

            $extension = pathinfo($this->fileExcel->getRealPath(), PATHINFO_EXTENSION);

            if($extension != 'xlsx'){

                sweetalert()->addError('Vui lòng Load File có định dạng .xlsx');
            return;

            }

            $data = fastexcel()->import($this->fileExcel->getRealPath());

            $data = $data->where('Spec','!=','')->where('Material','!=','');

            if($this->uncheckData == 0){

                $data->transform(function ($item) {
    
                    if (substr($item['Customer No'], 0, 1) == '2') {
    
                        $item['Zpr0 (USD)'] = round((float)$item['Excluded VAT price(USD)']
                        - (float)$item['Transportation fee(USD)'] 
                        - (float)$item['Small cone fee(USD)'] 
                        - (float)$item['Unload fee(USD)']
                        - (float)$item['Banking fee(USD)'] 
                        - (float)$item['Pallet fee(USD)'] 
                        - (float)$item['Commission fee(USD)'] 
                        - (float)$item['T/C fee(USD)']
                        - (float)$item['Other fee(USD)'],(int)$this->soThapPhan);
    
                    } elseif (substr($item['Customer No'], 0, 1) == '1'){
    
                        // Tính toán  excluded VAT price(VND), Excluded VAT price(USD)
                        if($item['excluded VAT price(VND)'] == '' && $item['Excluded VAT price(USD)'] != '') {
    
                            $item['excluded VAT price(VND)'] = round((float)$item['Excluded VAT price(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['excluded VAT price(VND)'] != '' && $item['Excluded VAT price(USD)'] == '') {
    
                            $item['Excluded VAT price(USD)'] = round((float)$item['excluded VAT price(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Transportation fee(VND), Transportation fee(USD)
                        if($item['Transportation fee(VND)'] == '' && $item['Transportation fee(USD)'] != '') {
    
                            $item['Transportation fee(VND)'] = round((float)$item['Transportation fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Transportation fee(VND)'] != '' && $item['Transportation fee(USD)'] == '') {
    
                            $item['Transportation fee(USD)'] = round((float)$item['Transportation fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Small cone fee(VND), Small cone fee(USD)
                        if($item['Small cone fee(VND)'] == '' && $item['Small cone fee(USD)'] != '') {
    
                            $item['Small cone fee(VND)'] = round((float)$item['Small cone fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Small cone fee(VND)'] != '' && $item['Small cone fee(USD)'] == '') {
    
                            $item['Small cone fee(USD)'] = round((float)$item['Small cone fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Unload fee(VND), Unload fee(USD)
                        if($item['Unload fee(VND)'] == '' && $item['Unload fee(USD)'] != '') {
    
                            $item['Unload fee(VND)'] = round((float)$item['Unload fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Unload fee(VND)'] != '' && $item['Unload fee(USD)'] == '') {
    
                            $item['Unload fee(USD)'] = round((float)$item['Unload fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Banking fee(VND), Banking fee(USD)
                        if($item['Banking fee(VND)'] == '' && $item['Banking fee(USD)'] != '') {
    
                            $item['Banking fee(VND)'] = round((float)$item['Banking fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Banking fee(VND)'] != '' && $item['Banking fee(USD)'] == '') {
    
                            $item['Banking fee(USD)'] = round((float)$item['Banking fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Pallet fee(VND), Pallet fee(USD)
                        if($item['Pallet fee(VND)'] == '' && $item['Pallet fee(USD)'] != '') {
    
                            $item['Pallet fee(VND)'] = round((float)$item['Pallet fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Pallet fee(VND)'] != '' && $item['Pallet fee(USD)'] == '') {
    
                            $item['Pallet fee(USD)'] = round((float)$item['Pallet fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Commission fee(VND), Commission fee(USD)
                        if($item['Commission fee(VND)'] == '' && $item['Commission fee(USD)'] != '') {
    
                            $item['Commission fee(VND)'] = round((float)$item['Commission fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Commission fee(VND)'] != '' && $item['Commission fee(USD)'] == '') {
    
                            $item['Commission fee(USD)'] = round((float)$item['Commission fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán TC(VND), TC(USD)
                        if($item['T/C fee(VND)'] == '' && $item['T/C fee(USD)'] != '') {
    
                            $item['T/C fee(VND)'] = round((float)$item['T/C fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['T/C fee(VND)'] != '' && $item['T/C fee(USD)'] == '') {
    
                            $item['T/C fee(USD)'] = round((float)$item['T/C fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
                        // Tính toán Other fee(VND), Other fee(USD)
                        if($item['Other fee(VND)'] == '' && $item['Other fee(USD)'] != '') {
    
                            $item['Other fee(VND)'] = round((float)$item['Other fee(USD)'] * (float)$item['Exchange rate'],$this->soThapPhan);
    
                        } elseif ($item['Other fee(VND)'] != '' && $item['Other fee(USD)'] == '') {
    
                            $item['Other fee(USD)'] = round((float)$item['Other fee(VND)'] / (float)$item['Exchange rate'],$this->soThapPhan);
    
                        }
    
                        // Tính toán Zpr0 (VND)
                        $item['Zpr0 (VND)'] = round((float)$item['excluded VAT price(VND)'] 
                        - (float)$item['Transportation fee(VND)'] 
                        - (float)$item['Small cone fee(VND)'] 
                        - (float)$item['Unload fee(VND)'] 
                        - (float)$item['Banking fee(VND)'] 
                        - (float)$item['Pallet fee(VND)'] 
                        - (float)$item['Commission fee(VND)'] 
                        - (float)$item['T/C fee(VND)'] 
                        - (float)$item['Other fee(VND)'],(int)$this->soThapPhan);
    
                        // Tính toán Zpr0 (USD)
                        $item['Zpr0 (USD)'] = round((float)$item['Excluded VAT price(USD)'] 
                        - (float)$item['Transportation fee(USD)'] 
                        - (float)$item['Small cone fee(USD)'] 
                        - (float)$item['Unload fee(USD)'] 
                        - (float)$item['Banking fee(USD)'] 
                        - (float)$item['Pallet fee(USD)'] 
                        - (float)$item['Commission fee(USD)'] 
                        - (float)$item['T/C fee(USD)'] 
                        - (float)$item['Other fee(USD)'],(int)$this->soThapPhan);
                        
                    }

                    if(gettype($item['Ship time']) == 'object')
                        $item['Ship time'] = Carbon::create($item['Ship time'])->isoFormat('DD/MM/YYYY');
    
                    return $item;
                });

            }

            $unique = $data->unique(function (array $item) {
                return $item['Spec'].$item['excluded VAT price(VND)'];
            });

            $this->dataFileExcelUnique = $unique->values()->all();

            $this->dataFileExcel = $data;
        }
    }

    public function createTTDH(){

        if($this->mailSale == ''){

            sweetalert()->addError('Chưa chọn Sale.');
            return;

        }

        if($this->dataFileExcel == ''){

            sweetalert()->addError('Chưa load file Excel.');
            return;

        }
        
        $dataFileExcel = collect($this->dataFileExcel);
        $dataFileExcelUnique = collect($this->dataFileExcelUnique);

        if($dataFileExcel != null){

            $contentMailQuyCach = '';

            $this->validFrom = Carbon::now()->isoFormat('DD.MM.YYYY');

            if(Carbon::now()->englishDayOfWeek == 'Saturday'){

                $this->validTo = Carbon::now()->addDays(2)->isoFormat('DD.MM.YYYY');

            }else{

                $this->validTo = Carbon::now()->addDays(1)->isoFormat('DD.MM.YYYY');

            }

            foreach ($dataFileExcelUnique as $item) {

                $customer = $item['Customer'];

                $cs = '<br />CS: ' . $item['CS'];

                $customerType = '<br />' . $item['Customer type'];

                if($item['excluded VAT price(VND)'] != ''){

                    $excluded = number_format($item['excluded VAT price(VND)']) . " vnd/kg => ";

                }elseif($item['Excluded VAT price(USD)'] != '' && $item['excluded VAT price(VND)'] == ''){

                    $excluded = $item['Excluded VAT price(USD)'] . " usd/kg => ";

                }

                if($item['Zpr0 (VND)'] != ''){

                    $zpr0 = "Zpr0= " . number_format($item['Zpr0 (VND)']);

                }elseif($item['Zpr0 (USD)'] != '' && $item['Zpr0 (VND)'] == ''){

                    $zpr0 = "Zpr0= " . $item['Zpr0 (USD)'];

                }

                $contentMailQuyCach = $contentMailQuyCach . "<br />" . $item['Spec'] . ' - ' . $item['Grade'] . ' Grade - ' . $item['Delivery term'] . ' ' . $excluded . $zpr0;

            }

            // Lấy Zpr0

            $uniqueZpr0 = $dataFileExcel->unique(function (array $item) {
                return $item['Zpr0 (USD)'].$item['Zpr0 (VND)'];
            });

            $ZproTemp = '';

            foreach ($uniqueZpr0 as $index => $item) {
                
                if($index == 0){

                    $ZproTemp = "<br />USD~" . $item['Zpr0 (USD)'];

                }else{

                    $ZproTemp = $ZproTemp . ', ' . $item['Zpr0 (USD)'];

                }

            }

            // Lấy Shiptime

            $uniqueShiptime = $dataFileExcel->unique('Ship time');

            $ShiptimeTemp = '';

            foreach ($uniqueShiptime as $index => $item) {
                
                if($index == 0){

                    $ShiptimeTemp = "<br />Shiptime " . $item['Ship time'];

                }else{

                    $ShiptimeTemp = $ShiptimeTemp . ' - ' . $item['Ship time'];

                }

            }

            // Lấy Stock new product

            $uniqueStockNewProduct = $dataFileExcel->unique('Stock/new product');

            $StockNewProductTemp = '';

            foreach ($uniqueStockNewProduct as $index => $item) {
                
                if($index == 0){

                    $StockNewProductTemp = "<br />" . $item['Stock/new product'];

                }else{

                    $StockNewProductTemp = $StockNewProductTemp . ' - ' . $item['Stock/new product'];

                }

            }

            // Lấy Transport fee

            $uniqueTransport = $dataFileExcel->unique(function (array $item) {
                return $item['Transportation fee(USD)'].$item['Transportation fee(VND)'];
            });

            $TransportTemp = '';

            foreach ($uniqueTransport as $index => $item) {

                if($item['Transportation fee(VND)'] != ''){

                    $tran = $item['Transportation fee(VND)'];

                }elseif($item['Transportation fee(USD)'] != '' && $item['Transportation fee(VND)'] == ''){

                    $tran = $item['Transportation fee(USD)'];

                }else{

                    $tran = '';

                }
                
                if($tran != ''){

                    if($index == 0){

                        $TransportTemp = "<br />Transportation fee: " . $tran;

                    }else{

                        $TransportTemp = $TransportTemp . ' - ' . $tran;

                    }

                }else{

                    $TransportTemp = '';

                }

            }

            // Lấy Small fee

            $uniqueSmall = $dataFileExcel->unique(function (array $item) {
                return $item['Small cone fee(USD)'].$item['Small cone fee(VND)'];
            });

            $SmallTemp = '';

            foreach ($uniqueSmall as $index => $item) {

                if($item['Small cone fee(VND)'] != ''){

                    $small = $item['Small cone fee(VND)'];

                }elseif($item['Small cone fee(USD)'] != '' && $item['Small cone fee(VND)'] == ''){

                    $small = $item['Small cone fee(USD)'];

                }else{

                    $small = '';

                }
                
                if($small != ''){

                    if($index == 0){

                        $SmallTemp = "<br />Small cone fee: " . $small;

                    }else{

                        $SmallTemp = $SmallTemp . ' - ' . $small;

                    }

                }else{

                    $SmallTemp = '';

                }

            }

            // Lấy unload fee

            $uniqueUnload = $dataFileExcel->unique(function (array $item) {
                return $item['Unload fee(USD)'].$item['Unload fee(VND)'];
            });

            $UnloadTemp = '';

            foreach ($uniqueUnload as $index => $item) {

                if($item['Unload fee(VND)'] != ''){

                    $unload = $item['Unload fee(VND)'];

                }elseif($item['Unload fee(USD)'] != '' && $item['Unload fee(VND)'] == ''){

                    $unload = $item['Unload fee(USD)'];

                }else{

                    $unload = '';

                }
                
                if($unload != ''){

                    if($index == 0){

                        $UnloadTemp = "<br />Unload fee: " . $unload;

                    }else{

                        $UnloadTemp = $UnloadTemp . ' - ' . $unload;

                    }

                }else{

                    $UnloadTemp = '';

                }

            }

            // Lấy unload fee

            $uniqueBanking = $dataFileExcel->unique(function (array $item) {
                return $item['Banking fee(USD)'].$item['Banking fee(VND)'];
            });

            $BankingTemp = '';

            foreach ($uniqueBanking as $index => $item) {

                if($item['Banking fee(VND)'] != ''){

                    $banking = $item['Banking fee(VND)'];

                }elseif($item['Banking fee(USD)'] != '' && $item['Banking fee(VND)'] == ''){

                    $banking = $item['Banking fee(USD)'];

                }else{

                    $banking = '';

                }
                
                if($banking != ''){

                    if($index == 0){

                        $BankingTemp = "<br />Banking fee: " . $banking;

                    }else{

                        $BankingTemp = $BankingTemp . ' - ' . $banking;

                    }

                }else{

                    $BankingTemp = '';

                }

            }
            
            // Lấy Pallet fee

            $uniquePallet = $dataFileExcel->unique(function (array $item) {
                return $item['Pallet fee(USD)'].$item['Pallet fee(VND)'];
            });

            $PalletTemp = '';

            foreach ($uniquePallet as $index => $item) {

                if($item['Pallet fee(VND)'] != ''){

                    $pallet = $item['Pallet fee(VND)'];

                }elseif($item['Pallet fee(USD)'] != '' && $item['Pallet fee(VND)'] == ''){

                    $pallet = $item['Pallet fee(USD)'];

                }else{

                    $pallet = '';

                }
                
                if($pallet != ''){

                    if($index == 0){

                        $PalletTemp = "<br />Pallet fee: " . $pallet;

                    }else{

                        $PalletTemp = $PalletTemp . ' - ' . $pallet;

                    }

                }else{

                    $PalletTemp = '';

                }

            }

            // Lấy Commission fee

            $uniqueCommission = $dataFileExcel->unique(function (array $item) {
                return $item['Commission fee(USD)'].$item['Commission fee(VND)'];
            });

            $CommissionTemp = '';

            foreach ($uniqueCommission as $index => $item) {

                if($item['Commission fee(VND)'] != ''){

                    $commission = $item['Commission fee(VND)'];

                }elseif($item['Commission fee(USD)'] != '' && $item['Commission fee(VND)'] == ''){

                    $commission = $item['Commission fee(USD)'];

                }else{

                    $commission = '';

                }
                
                if($commission != ''){

                    if($index == 0){

                        $CommissionTemp = "<br />Commission fee: " . $commission;

                    }else{

                        $CommissionTemp = $CommissionTemp . ' - ' . $commission;

                    }

                }else{

                    $CommissionTemp = '';

                }

            }

            // Lấy T/C fee

            $uniqueTC = $dataFileExcel->unique(function (array $item) {
                return $item['T/C fee(USD)'].$item['T/C fee(VND)'];
            });

            $TCTemp = '';

            foreach ($uniqueTC as $index => $item) {

                if($item['T/C fee(VND)'] != ''){

                    $tc = $item['T/C fee(VND)'];

                }elseif($item['T/C fee(USD)'] != '' && $item['T/C fee(VND)'] == ''){

                    $tc = $item['T/C fee(USD)'];

                }else{

                    $tc = '';

                }
                
                if($tc != ''){

                    if($index == 0){

                        $TCTemp = "<br />T/C fee: " . $tc;

                    }else{

                        $TCTemp = $CommissionTemp . ' - ' . $tc;

                    }

                }else{

                    $TCTemp = '';

                }

            }

            // Lấy Other fee

            $uniqueOther = $dataFileExcel->unique(function (array $item) {
                return $item['Other fee(USD)'].$item['Other fee(VND)'];
            });

            $OtherTemp = '';

            foreach ($uniqueOther as $index => $item) {

                if($item['Other fee(VND)'] != ''){

                    $other = $item['Other fee(VND)'];

                }elseif($item['Other fee(USD)'] != '' && $item['Other fee(VND)'] == ''){

                    $other = $item['Other fee(USD)'];

                }else{

                    $other = '';

                }
                
                if($other != ''){

                    if($index == 0){

                        $OtherTemp = "<br />Other fee: " . $other;

                    }else{

                        $OtherTemp = $OtherTemp . ' - ' . $other;

                    }

                }else{

                    $OtherTemp = '';

                }

            }

            // Lấy Stock in year

            $uniqueStockInYear = $dataFileExcel->unique('Stock in year');

            $StockInYearTemp = '';

            foreach ($uniqueStockInYear as $index => $item) {
                
                if($index == 0){

                    $StockInYearTemp = "<br />" . $item['Stock in year'];

                }else{

                    $StockInYearTemp = $StockInYearTemp . ' - ' . $item['Stock in year'];

                }

            }

            $contentMailFinish = '<span style="color: #0431B4;font-size:16px">'.'Dear Sir or Madam<br />' . "Please kindly approve " . $customer . " special price<br />" . $contentMailQuyCach
            . $ZproTemp . $ShiptimeTemp . $StockNewProductTemp . $cs . $customerType . $TransportTemp . $SmallTemp . $UnloadTemp . $BankingTemp 
            . $PalletTemp . $CommissionTemp . $TCTemp . $OtherTemp . $StockInYearTemp . $this->note
            . "<br /><br />" . "1. Buyer name: " . '<span style="color:red">' . $this->buyerName . "</span>" .
            "<br />" . "2. Consignee: " . "<span style=\"color:red\">" . $this->consignee . "</span>" .
            "<br />" . "3. Commission and agency name : " . "<span style=\"color:red\">" . $this->commission . "</span>" .
            "<br />" . "4. End use (circular knitting, warspan knitting, weaving for weft or warp yarn): " . "<span style=\"color:red\">" . $this->endUse . "</span>" .
            "<br />" . "5. Fabric construction: " . "<span style=\"color:red\">" . $this->fabricConstruction . "</span>" .
            "<br />" . "6. 1 set of yarn (# of bobbins, weight per bobbin): " . "<span style=\"color:red\">" . $this->_1setOfYarn . "</span>" .
            "<br />" . "7. Incoterms: " . "<span style=\"color:red\">" . $this->incoterms . "</span>" .
            "<br />" . "8. Payment terms: " . "<span style=\"color:red\">" . $this->paymentTerms . "</span>" .
            "<br />" . "9. Payment Date: " . "<span style=\"color:red\">" . $this->paymentDate . "</span>" .
            "<br />" . "10. Delivery Date: " . "<span style=\"color:red\">" . $this->deliveryDate . "</span>" .
            "<br />" . "11. Brand name: " . "<span style=\"color:red\">" . $this->brandName . "</span>" .
            "<br />" . "12. Packing (qty per carton, cone per weight, inc/exl pallet, incl/excl loading, incl/excl mang co, special request if any): " . "<span style=\"color:red\">" . $this->packing . "</span>". 
            "<br />" . "13. Truck fee: " . "<span style=\"color:red\">" . $this->truckFee . "</span>" .
            "<br />" . "14. T/C: " . "<span style=\"color:red\">" . $this->tc . "</span>" .
            "<br />" . "15. C/O: " . "<span style=\"color:red\">" . $this->co . "</span>" . '<br /><br />';

            $this->soPhieu = IdGenerator::generate(['table' => 'phieu_ttdh', 'field' => 'so_phieu', 'length' => '14', 'prefix' => 'TTDH-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);

            DB::transaction(function() use($dataFileExcel, $contentMailFinish) {

                foreach ($dataFileExcel as $item) {
                
                    DB::table('phieu_ttdh')->insert([

                        'so_phieu' => $this->soPhieu,
                        'customer' => $item['Customer'],
                        'customer_no' => $item['Customer No'],
                        'shiptime' => $item['Ship time'],
                        'stocknewproduct' => $item['Stock/new product'],
                        'khung_xe' => $item['address'],
                        'spec' => $item['Spec'],
                        'grade' => $item['Grade'],
                        'material' => $item['Material'],
                        'qty' => $item['Qty'],
                        'excluded_usd' => $item['Excluded VAT price(USD)'],
                        'excluded_vnd' => $item['excluded VAT price(VND)'],
                        'zpr0_usd' => $item['Zpr0 (USD)'],
                        'zpr0_vnd' => $item['Zpr0 (VND)'],
                        'product' => $item['Product hierarchy'],
                        'listprice' => $item['List price'],
                        'stran_usd' => $item['Transportation fee(USD)'],
                        'stran_vnd' => $item['Transportation fee(VND)'],
                        'small_usd' => $item['Small cone fee(USD)'],
                        'small_vnd' => $item['Small cone fee(VND)'],
                        'unload_usd' => $item['Unload fee(USD)'],
                        'unload_vnd' => $item['Unload fee(VND)'],
                        'banking_usd' => $item['Banking fee(USD)'],
                        'banking_vnd' => $item['Banking fee(VND)'],
                        'pl_usd' => $item['Pallet fee(USD)'],
                        'pl_vnd' => $item['Pallet fee(VND)'],
                        'comm_usd' => $item['Commission fee(USD)'],
                        'comm_vnd' => $item['Commission fee(VND)'],
                        'other_usd' => $item['Other fee(USD)'],
                        'other_vnd' => $item['Other fee(VND)'],
                        'payment' => $item['Payment term'],
                        'exchange' => $item['Exchange rate'],
                        'stockinyear' => $item['Stock in year'],
                        'customer_type' => $item['Customer type'],
                        'delivery_term' => $item['Delivery term'],
                        'cs' => $item['CS'],
                        'remark' => $item['Remark'],
                        'valid_from' => $this->validFrom,
                        'valid_to' => $this->validTo,
                        'new' => Auth::user()->username,
                        'new_at' => Carbon::now(),
                        'status' => 'New',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                }

                DB::table('phieu_ttdh_log')->insert([

                    'so_phieu' => $this->soPhieu,
                    'status' => 'New',
                    'status_log' => 'Created',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('phieu_ttdh_content')->insert([

                    'so_phieu' => $this->soPhieu,
                    'content' => $contentMailFinish,
                    'mail_admin' => Auth::user()->email,
                    'mail_to' => $this->mailSale,
                    'mail_cc_1' => $this->mailPhu1,
                    'mail_cc_2' => $this->mailPhu2,
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ]);

            });

            // Create file Excel

            foreach ($dataFileExcel as $index => $item) {
                
                $customerEXCEL = $item['Customer'];
                $customerNoEXCEL = $item['Customer No'];
                $shiptimeEXCEL = $item['Ship time'];
                $stockNewProductEXCEL = $item['Stock/new product'];
                $deliveryTermsEXCEL = $item['Delivery term'];
                $exchangeRateEXCEL = $item['Exchange rate'];
                $paymentTermsEXCEL = $item['Payment term'];
                $customerTypeEXCEL = $item['Customer type'];

                $tranFeeUSDEXCEL = $item['Transportation fee(USD)'];
                $tranFeeVNDEXCEL = $item['Transportation fee(VND)'];

                $smallFeeUSDEXCEL = $item['Small cone fee(USD)'];
                $smallFeeVNDEXCEL = $item['Small cone fee(VND)'];

                $unloadFeeUSDEXCEL = $item['Unload fee(USD)'];
                $unloadFeeVNDEXCEL = $item['Unload fee(VND)'];

                $bankingFeeUSDEXCEL = $item['Banking fee(USD)'];
                $bankingFeeVNDEXCEL = $item['Banking fee(VND)'];

                $palletFeeUSDEXCEL = $item['Pallet fee(USD)'];
                $palletFeeVNDEXCEL = $item['Pallet fee(VND)'];

                $commFeeUSDEXCEL = $item['Commission fee(USD)'];
                $commFeeVNDEXCEL = $item['Commission fee(VND)'];

                $tcFeeUSDEXCEL = $item['T/C fee(USD)'];
                $tcFeeVNDEXCEL = $item['T/C fee(VND)'];

                $otherFeeUSDEXCEL = $item['Other fee(USD)'];
                $otherFeeVNDEXCEL = $item['Other fee(VND)'];

                $addressEXCEL = $item['address'];

                break;

            }

            $spreadsheet = new Spreadsheet();

            $activeWorksheet = $spreadsheet->getActiveSheet();

            $activeWorksheet->setTitle($customer);
            $activeWorksheet->setCellValue('A1', 'Customer'); $activeWorksheet->setCellValue('B1', $customerEXCEL); $activeWorksheet->setCellValue('C1', $this->soPhieu);
            $activeWorksheet->setCellValue('A2', 'Customer code'); $activeWorksheet->setCellValue('B2', $customerNoEXCEL);
            $activeWorksheet->setCellValue('A3', 'Ship time'); $activeWorksheet->setCellValue('B3', $shiptimeEXCEL);
            $activeWorksheet->setCellValue('A4', 'Stock/new product'); $activeWorksheet->setCellValue('B4', $stockNewProductEXCEL);
            $activeWorksheet->setCellValue('A5', 'Incoterms'); $activeWorksheet->setCellValue('B5', $deliveryTermsEXCEL);
            $activeWorksheet->setCellValue('A6', 'Exchange rate'); $activeWorksheet->setCellValue('B6', $exchangeRateEXCEL);
            $activeWorksheet->setCellValue('A7', 'Payment terms'); $activeWorksheet->setCellValue('B7', $paymentTermsEXCEL);
            $activeWorksheet->setCellValue('A8', 'Customer type'); $activeWorksheet->setCellValue('B8', $customerTypeEXCEL);

            $activeWorksheet->setCellValue('A10', 'Spec');
            $activeWorksheet->setCellValue('A11', 'Spec');

            $activeWorksheet->setCellValue('B10', 'Grade');
            $activeWorksheet->setCellValue('B11', 'Grade');

            $activeWorksheet->setCellValue('C10', 'Material');
            $activeWorksheet->setCellValue('C11', 'Material');

            $activeWorksheet->setCellValue('D10', 'Qty');
            $activeWorksheet->setCellValue('D11', 'Qty');

            $activeWorksheet->setCellValue('E10', 'Excluded VAT price'); $activeWorksheet->setCellValue('F10', 'Excluded VAT price');
            $activeWorksheet->setCellValue('E11', 'USD'); $activeWorksheet->setCellValue('F11', 'VND');

            $activeWorksheet->setCellValue('G10', 'Excluded VAT price'); $activeWorksheet->setCellValue('H10', 'Excluded VAT price');
            $activeWorksheet->setCellValue('G11', 'USD'); $activeWorksheet->setCellValue('H11', 'VND');

            $activeWorksheet->setCellValue('I10', 'List price');
            $activeWorksheet->setCellValue('I11', 'List price');

            $activeWorksheet->setCellValue('J10', 'Remark');
            $activeWorksheet->setCellValue('J11', 'Remark');

            $row = 12;

            foreach ($dataFileExcel as $item) {

                $activeWorksheet->setCellValue('A' . $row, $item['Spec'] );
                $activeWorksheet->setCellValue('B' . $row, $item['Grade'] );
                $activeWorksheet->setCellValue('C' . $row, $item['Material'] );
                $activeWorksheet->setCellValue('D' . $row, $item['Qty']);
                $activeWorksheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $activeWorksheet->setCellValue('E' . $row, $item['Excluded VAT price(USD)'] );
                $activeWorksheet->setCellValue('F' . $row, $item['excluded VAT price(VND)'] );
                $activeWorksheet->setCellValue('G' . $row, $item['Zpr0 (USD)'] );
                $activeWorksheet->setCellValue('H' . $row, $item['Zpr0 (VND)'] );
                $activeWorksheet->setCellValue('I' . $row, $item['List price'] );
                $activeWorksheet->setCellValue('J' . $row, $item['Remark'] );

                $row = $row + 1;

            }

            $activeWorksheet->setCellValue('A' . $row, 'TOTAL:');

            $activeWorksheet->setCellValue('D' . $row, '=SUM(D12:D' . $row - 1 . ')');

            $activeWorksheet->setCellValue('A' . $row + 2,''); $activeWorksheet->setCellValue('B' . $row + 2,'USD'); $activeWorksheet->setCellValue('C' . $row + 2,'VND');
            $activeWorksheet->setCellValue('A' . $row + 3,'Total Expense'); $activeWorksheet->setCellValue('B' . $row + 3, '=SUM(B' . $row + 4 . ':B' . $row + 11 . ')'); $activeWorksheet->setCellValue('C' . $row + 3,'=SUM(C' . $row + 4 . ':C' . $row + 11 . ')');
            $activeWorksheet->setCellValue('A' . $row + 4,'Transportation fee'); $activeWorksheet->setCellValue('B' . $row + 4,$tranFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 4, $tranFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 5,'Small cone fee'); $activeWorksheet->setCellValue('B' . $row + 5,$smallFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 5,$smallFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 6,'Unload fee'); $activeWorksheet->setCellValue('B' . $row + 6,$unloadFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 6,$unloadFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 7,'Banking fee'); $activeWorksheet->setCellValue('B' . $row + 7,$bankingFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 7,$bankingFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 8,'Pallet fee'); $activeWorksheet->setCellValue('B' . $row + 8,$palletFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 8,$palletFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 9,'Commission fee'); $activeWorksheet->setCellValue('B' . $row + 9,$commFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 9,$commFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 10,'T/C fee'); $activeWorksheet->setCellValue('B' . $row + 10,$tcFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 10,$tcFeeVNDEXCEL);
            $activeWorksheet->setCellValue('A' . $row + 11,'Other fee'); $activeWorksheet->setCellValue('B' . $row + 11,$otherFeeUSDEXCEL); $activeWorksheet->setCellValue('C' . $row + 11,$otherFeeVNDEXCEL);

            $activeWorksheet->setCellValue('A' . $row + 13, 'Remark');
            $activeWorksheet->setCellValue('A' . $row + 14, $addressEXCEL);

            $activeWorksheet->setCellValue('A' . $row + 16, 'Note');
            $activeWorksheet->setCellValue('A' . $row + 17, $this->note);

            $activeWorksheet->setCellValue('A' . $row + 19, 'Buyer name:'); $activeWorksheet->setCellValue('B' . $row + 18, $this->buyerName);
            $activeWorksheet->setCellValue('A' . $row + 20, 'Consignee: '); $activeWorksheet->setCellValue('B' . $row + 19, $this->consignee);
            $activeWorksheet->setCellValue('A' . $row + 21, 'Commission and agency name:'); $activeWorksheet->setCellValue('B' . $row + 20, $this->commission);
            $activeWorksheet->setCellValue('A' . $row + 22, 'End use:'); $activeWorksheet->setCellValue('B' . $row + 21, $this->endUse);
            $activeWorksheet->setCellValue('A' . $row + 23, 'Fabric construction:'); $activeWorksheet->setCellValue('B' . $row + 22, $this->fabricConstruction);
            $activeWorksheet->setCellValue('A' . $row + 24, '1 set of yarn:'); $activeWorksheet->setCellValue('B' . $row + 23, $this->_1setOfYarn);
            $activeWorksheet->setCellValue('A' . $row + 25, 'Incoterms:'); $activeWorksheet->setCellValue('B' . $row + 24, $this->incoterms);
            $activeWorksheet->setCellValue('A' . $row + 26, 'Payment terms:'); $activeWorksheet->setCellValue('B' . $row + 25, $this->paymentTerms);
            $activeWorksheet->setCellValue('A' . $row + 27, 'Payment Date:'); $activeWorksheet->setCellValue('B' . $row + 26, $this->paymentDate);
            $activeWorksheet->setCellValue('A' . $row + 28, 'Delivery Date:'); $activeWorksheet->setCellValue('B' . $row + 27, $this->deliveryDate);
            $activeWorksheet->setCellValue('A' . $row + 29, 'Brand name:'); $activeWorksheet->setCellValue('B' . $row + 28, $this->brandName);
            $activeWorksheet->setCellValue('A' . $row + 30, 'Packing:'); $activeWorksheet->setCellValue('B' . $row + 29, $this->packing);
            $activeWorksheet->setCellValue('A' . $row + 31, 'Truck fee:'); $activeWorksheet->setCellValue('B' . $row + 30, $this->truckFee);
            $activeWorksheet->setCellValue('A' . $row + 32, 'T/C:'); $activeWorksheet->setCellValue('B' . $row + 31, $this->tc);
            $activeWorksheet->setCellValue('A' . $row + 33, 'C/O:'); $activeWorksheet->setCellValue('B' . $row + 32, $this->co);

            $activeWorksheet->setCellValue('A' . $row + 35, 'Manager Director');
            $activeWorksheet->setCellValue('C' . $row + 35, 'Sales Manager');
            $activeWorksheet->setCellValue('F' . $row + 35, 'Sales Chief');
            $activeWorksheet->setCellValue('I' . $row + 35, 'Sales Staff');

            // Format sheet 1

            $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
            $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');

            $activeWorksheet->getStyle('C' . $row + 3)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 4)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 5)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 6)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 7)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 8)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 9)->getNumberFormat()->setFormatCode('#,##0');
            $activeWorksheet->getStyle('C' . $row + 10)->getNumberFormat()->setFormatCode('#,##0');

            $activeWorksheet
            ->getStyle('A10:J' . $row - 1)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('17202A'));

            $activeWorksheet
            ->getStyle('A' . $row + 2 . ':C' . $row + 11)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('17202A'));

            $activeWorksheet
            ->getStyle('A'. $row + 35 .':K' . $row + 39)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('17202A'));

            $activeWorksheet
            ->getStyle('A10:J11')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('F9E79F');

            $activeWorksheet->getColumnDimensionByColumn(1)->setWidth('30');
            $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
            $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
            $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
            $activeWorksheet->getColumnDimensionByColumn(5)->setWidth('12');
            $activeWorksheet->getColumnDimensionByColumn(6)->setWidth('12');
            $activeWorksheet->getColumnDimensionByColumn(7)->setWidth('12');
            $activeWorksheet->getColumnDimensionByColumn(8)->setWidth('12');
            $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
            $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);

            $activeWorksheet->getStyle('A1:J' . $row)->getAlignment()->setHorizontal('center');
            $activeWorksheet->getStyle('A1:J' . $row)->getAlignment()->setVertical('center');

            $activeWorksheet->getStyle('B' . $row + 2 . ':C'  . $row + 10)->getAlignment()->setHorizontal('center');
            $activeWorksheet->getStyle('B' . $row + 2 . ':C'  . $row + 10)->getAlignment()->setVertical('center');

            $activeWorksheet->getStyle('A'. $row + 35 .':K' . $row + 35)->getAlignment()->setHorizontal('center');
            $activeWorksheet->getStyle('A'. $row + 35 .':K' . $row + 35)->getAlignment()->setVertical('center');

            $activeWorksheet->getStyle('B'. $row + 18 .':J' . $row + 32)->getAlignment()->setHorizontal('left');
            $activeWorksheet->getStyle('B'. $row + 18 .':J' . $row + 32)->getAlignment()->setVertical('left');

            $activeWorksheet->getStyle('B' . $row + 2 . ':C'  . $row + 3)->getFont()->setBold(true);
            $activeWorksheet
            ->getStyle('B' . $row + 3 . ':C'  . $row + 3)
            ->getFont()
            ->getColor()
            ->setRGB ('28B463')  ;

            $activeWorksheet->getStyle('A10:J11')->getFont()->setBold(true);
            $activeWorksheet->getStyle('A' . $row)->getFont()->setBold(true);

            $activeWorksheet->getStyle('A' . $row)->getFont()->setBold(true);
            $activeWorksheet->getStyle('D' . $row)->getFont()->setBold(true);

            $activeWorksheet->mergeCells('E10:F10');
            $activeWorksheet->mergeCells('G10:H10');
            $activeWorksheet->mergeCells('A10:A11');
            $activeWorksheet->mergeCells('B10:B11');
            $activeWorksheet->mergeCells('C10:C11');
            $activeWorksheet->mergeCells('D10:D11');
            $activeWorksheet->mergeCells('I10:I11');
            $activeWorksheet->mergeCells('J10:J11');

            $activeWorksheet->mergeCells('A'. $row + 35 .':B' . $row + 35);
            $activeWorksheet->mergeCells('C'. $row + 35 .':E' . $row + 35);
            $activeWorksheet->mergeCells('F'. $row + 35 .':H' . $row + 35);
            $activeWorksheet->mergeCells('I'. $row + 35 .':K' . $row + 35);

            $activeWorksheet->mergeCells('A'. $row + 36 .':B' . $row + 39);
            $activeWorksheet->mergeCells('C'. $row + 36 .':E' . $row + 39);
            $activeWorksheet->mergeCells('F'. $row + 36 .':H' . $row + 39);
            $activeWorksheet->mergeCells('I'. $row + 36 .':K' . $row + 39);

            // Create sheet 2

            $spreadsheet->createSheet();
            $activeWorksheet = $spreadsheet->getSheet(1);

            $activeWorksheet->setTitle('Template');
            $activeWorksheet->setCellValue('E2', 'Customer');
            $activeWorksheet->setCellValue('F2', $customerNoEXCEL);
            $activeWorksheet->setCellValue('G2', $customerEXCEL);

            $activeWorksheet->setCellValue('D4', 'Mandantory');
            $activeWorksheet->setCellValue('E4', 'Blank');
            $activeWorksheet->setCellValue('F4', 'Blank');
            $activeWorksheet->setCellValue('G4', 'Blank');
            $activeWorksheet->setCellValue('H4', 'Blank');
            $activeWorksheet->setCellValue('I4', 'Mandantory');
            $activeWorksheet->setCellValue('J4', 'Blank');
            $activeWorksheet->setCellValue('K4', 'Mandantory');
            $activeWorksheet->setCellValue('L4', 'Blank');
            $activeWorksheet->setCellValue('M4', 'Blank');
            $activeWorksheet->setCellValue('N4', 'Mandantory');
            $activeWorksheet->setCellValue('O4', 'Mandantory');

            $activeWorksheet->setCellValue('D5', 'Product hierarchy');
            $activeWorksheet->setCellValue('E5', 'Status');
            $activeWorksheet->setCellValue('F5', 'Description');
            $activeWorksheet->setCellValue('G5', 'Pro.Status');
            $activeWorksheet->setCellValue('H5', 'Amount');
            $activeWorksheet->setCellValue('I5', 'Unit');
            $activeWorksheet->setCellValue('J5', 'Per');
            $activeWorksheet->setCellValue('K5', 'UoM');
            $activeWorksheet->setCellValue('L5', 'Calculation type');
            $activeWorksheet->setCellValue('M5', 'Scale Basic');
            $activeWorksheet->setCellValue('N5', 'Valid from');
            $activeWorksheet->setCellValue('O5', 'Valid to');

            $row = 6;

            foreach ($dataFileExcel as $item) {

                $activeWorksheet->setCellValue('D' . $row, $item['Product hierarchy'] );

                if($item['Zpr0 (VND)'] != ''){

                    $activeWorksheet->setCellValue('H' . $row, $item['Zpr0 (VND)'] );
                    $activeWorksheet->setCellValue('I' . $row, 'VND' );
                    $activeWorksheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');

                }elseif($item['Zpr0 (USD)'] != '' && $item['Zpr0 (VND)'] == ''){

                    $activeWorksheet->setCellValue('H' . $row, $item['Zpr0 (USD)'] );
                    $activeWorksheet->setCellValue('I' . $row, 'USD' );

                }

                $activeWorksheet->setCellValue('K' . $row, 'KG' );

                $activeWorksheet->setCellValue('N' . $row, $this->validFrom );
                $activeWorksheet->setCellValue('O' . $row, $this->validTo );

                $row = $row + 1;
            }

            $activeWorksheet->setCellValue('D' . $row + 1, 'Note:' );
            $activeWorksheet->setCellValue('E' . $row + 2, '1. Mr CEO need to copy all line item ( Item data only ,Not include Title)' );
            $activeWorksheet->setCellValue('E' . $row + 3, '2. Mandantory : Sales employee must input data' );
            $activeWorksheet->setCellValue('E' . $row + 4, '3. Blank: These cell must be blanked' );
            $activeWorksheet->setCellValue('E' . $row + 5, '4. Distribution Channel: ' . $customerTypeEXCEL );

            // Format sheet 2

            $activeWorksheet
            ->getStyle('C1:P' . $row + 8)
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CECDFF');

            $activeWorksheet
            ->getStyle('E2')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('F2')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('17202A'));

            $activeWorksheet->getColumnDimensionByColumn(4)->setWidth('20');
            $activeWorksheet->getColumnDimensionByColumn(14)->setWidth('15');
            $activeWorksheet->getColumnDimensionByColumn(15)->setWidth('15');

            $activeWorksheet
            ->getStyle('D4:O' . $row - 1)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('17202A'));

            $activeWorksheet
            ->getStyle('D5')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('D5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF00');

            $activeWorksheet
            ->getStyle('I5')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('I5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF00');

            $activeWorksheet
            ->getStyle('K5')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('K5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF00');

            $activeWorksheet
            ->getStyle('N5')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('N5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF00');

            $activeWorksheet
            ->getStyle('O5')
            ->getFont()
            ->getColor()
            ->setRGB ('FF0000');

            $activeWorksheet
            ->getStyle('O5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF00');

            $activeWorksheet->getStyle('D5:O5')->getFont()->setBold(true);

            $activeWorksheet
            ->getStyle('E4:H' . $row - 1)
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('F7DC6F');

            $activeWorksheet
            ->getStyle('L4:M' . $row - 1)
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('F7DC6F');

            $spreadsheet->setActiveSheetIndex(0);

            $writer = new Xlsx($spreadsheet);

            ob_start();
            $writer->save('php://output');
            $content = ob_get_contents();
            ob_end_clean();

            Storage::disk('ftp')->put('TTDH/' . $this->soPhieu . ".xlsx", $content); 

            $ccMail = [];

            $ccMail = array_merge($ccMail, [Auth::user()->email]);
            
            $ccMail = array_merge($ccMail, [$this->mailSale]);

            if($this->mailPhu1 != ''){

                $ccMail = array_merge($ccMail, [$this->mailPhu1]);

            }

            if($this->mailPhu2 != ''){

                $ccMail = array_merge($ccMail, [$this->mailPhu2]);

            }

            $user = User::permission('approve_1_ttdh')->first();

            Mail::to($user->email)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Approve 1', $customer, $contentMailFinish, Carbon::now()));

            flash()->addSuccess('Tạo TTĐH thành công.');

            $this->resetInputField();

            $this->emit('createTTDHModal');


        }else{

            flash()->addFlash('error', 'Vui lòng bấm "Check" kiểm tra dữ liệu','Thông báo');
            return;

        }

    }

    public function duyetWebModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $phieuTTDH = DB::table('phieu_ttdh')
        ->where('so_phieu', $this->soPhieu)
        ->first();

        $this->khachHang = $phieuTTDH->customer;

    }

    public function duyetWeb(){

        $phieuTTDH = DB::table('phieu_ttdh')
                ->where('so_phieu', $this->soPhieu)
                ->first();

        if($phieuTTDH->status == 'New'){

            if(!Auth::user()->hasPermissionTo('approve_1_ttdh')){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('duyetWebModal');
                $this->resetInputField();
                return;

            }

        }elseif($phieuTTDH->status == 'Approve 1'){

            if(!Auth::user()->hasPermissionTo('approve_2_ttdh')){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('duyetWebModal');
                $this->resetInputField();
                return;

            }

        }elseif($phieuTTDH->status == 'Approve 2'){

            if(!Auth::user()->hasPermissionTo('approve_3_ttdh')){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('duyetWebModal');
                $this->resetInputField();
                return;

            }

        }
        
        if($phieuTTDH->status == 'New'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'approved_1' => Auth::user()->username,
                'approved_1_at' => Carbon::now(),

                'status' => 'Approve 1',

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Approve 1',
                'status_log' => 'Approved',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin, $content->mail_to]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            $user = User::permission('approve_2_ttdh')->first();

            Mail::to($user->email)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Approve 2', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('duyetWebModal');

        }elseif($phieuTTDH->status == 'Approve 1'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'approved_2' => Auth::user()->username,
                'approved_2_at' => Carbon::now(),

                'status' => 'Approve 2',

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Approve 2',
                'status_log' => 'Approved',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin, $content->mail_to]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            $user = User::permission('approve_3_ttdh')->first();

            Mail::to($user->email)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Approve 3', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('duyetWebModal');

        }elseif($phieuTTDH->status == 'Approve 2'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'approved_3' => Auth::user()->username,
                'approved_3_at' => Carbon::now(),

                'status' => 'Finish',

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Finish',
                'status_log' => 'Approved',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $danhsachfile = Storage::disk('ftp')->allFiles('TTDH/' . $this->soPhieu);

            if(count($danhsachfile) > 0){

                $file_ftp = Storage::disk('ftp')->get('TTDH/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx');

                Storage::disk('public')->put('TTDH/' . $this->soPhieu . '.xlsx', $file_ftp);

                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(Storage::disk('public')->path('TTDH/' . $this->soPhieu . '.xlsx'));

                $TTDH = DB::table('phieu_ttdh')
                ->where('so_phieu', $this->soPhieu)
                ->get();

                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A' . count($TTDH) + 34, $TTDH[0]->approved_1_at);
                $sheet->setCellValue('C' . count($TTDH) + 34, $TTDH[0]->approved_2_at);
                $sheet->setCellValue('E' . count($TTDH) + 34, $TTDH[0]->approved_3_at);

                $user1 = User::where('username', $TTDH[0]->approved_1)->first();

                $sheet->setCellValue('C' . count($TTDH) + 35, $user1->name);

                $user2 = User::where('username', $TTDH[0]->approved_2)->first();

                $sheet->setCellValue('C' . count($TTDH) + 35, $user2->name);

                $user3 = User::where('username', $TTDH[0]->approved_3)->first();

                $sheet->setCellValue('E' . count($TTDH) + 35, $user3->name);
        
                $writer = new Xlsx($spreadsheet);
        
                ob_start();
                $writer->save('php://output');
                $content = ob_get_contents();
                ob_end_clean();
        
                Storage::disk('ftp')->put('TTDH/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx', $content);
        
                Storage::disk('public')->delete('TTDH/' . $this->soPhieu . '.xlsx');

            }

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            Mail::to($content->mail_to)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Finish', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('duyetWebModal');

        }else{

            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
            $this->emit('duyetWebModal');

        }
    }

    public function rejectModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $phieuTTDH = DB::table('phieu_ttdh')
        ->where('so_phieu', $this->soPhieu)
        ->first();

        $this->khachHang = $phieuTTDH->customer;

    }

    public function reject(){

        $phieuTTDH = DB::table('phieu_ttdh')
                ->where('so_phieu', $this->soPhieu)
                ->first();
        
        if($phieuTTDH->status == 'New'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'reject' => Auth::user()->username,
                'reject_at' => Carbon::now(),

                'status' => 'Reject 1',
                'reason_for_reject' => $this->reject,

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Reject 1',
                'status_log' => 'Rejected',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            Mail::to($content->mail_to)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Reject', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('rejectModal');

        }elseif($phieuTTDH->status == 'Approve 1'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'reject' => Auth::user()->username,
                'reject_at' => Carbon::now(),

                'status' => 'Reject 2',
                'reason_for_reject' => $this->reject,

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Reject 2',
                'status_log' => 'Rejected',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            Mail::to($content->mail_to)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Reject', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('rejectModal');

        }elseif($phieuTTDH->status == 'Approve 2'){

            DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'reject' => Auth::user()->username,
                'reject_at' => Carbon::now(),

                'status' => 'Reject 3',
                'reason_for_reject' => $this->reject,

                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            DB::table('phieu_ttdh_log')->insert([

                'so_phieu' => $phieuTTDH->so_phieu,
                'status' => 'Reject 3',
                'status_log' => 'Rejected',

                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $content = DB::table('phieu_ttdh_content')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_admin]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            if($content->mail_cc_2 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

            }

            Mail::to($content->mail_to)
            ->cc($ccMail)
            ->send(new TTDHMail($this->soPhieu, 'Reject', $phieuTTDH->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
            $this->emit('rejectModal');

        }else{

            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
            $this->emit('duyetWebModal');

        }
    }

    public function detailModal($soPhieu){

        $content = DB::table('phieu_ttdh_content')
        ->where('so_phieu', $soPhieu)
        ->first();

        $this->detail = $content->content;

        $this->log = DB::table('phieu_ttdh_log')
        ->where('so_phieu', $soPhieu)
        ->get();

    }

    public function downloadFile($soPhieu){

        return Storage::disk('ftp')->download('TTDH/' . $soPhieu . '/' . $soPhieu. '.xlsx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function render()
    {
        if($this->state == 'create'){

            if($this->danhSachMailSale == null)
                $this->danhSachMailSale =  User::role(['sale_admin', 'pho_phong_sale'])->get();

            if($this->danhSachMailSaleAll == null)
                $this->danhSachMailSaleAll = User::role(['sale', 'sale_admin', 'pho_phong_sale'])->get();

            $this->listThongTinDongGoi = DB::table('thong_tin_dong_goi')->get();

        }

        $this->danhSachMailSale =  User::role(['sale_admin', 'pho_phong_sale'])->get();

        $this->danhSachMailSaleAll = User::role(['sale', 'sale_admin', 'pho_phong_sale'])->get();

        $search_fields = [
            'so_phieu',
            'customer',
            'created_user',
            'status',
        ];

        $search_terms = explode(',', $this->search);

        $danhSachTTDH = DB::table('phieu_ttdh')

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
        
        ->where('is_delete', null)

        ->where( function ($query){

            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);
    
            }elseif($this->tuNgay != null && $this->denNgay != null){
    
                $query->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }elseif($this->tuNgay == null && $this->denNgay != null){
    
                $query->whereBetween('created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }
            elseif($this->tuNgay != null && $this->denNgay == null){
    
                $query->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);
    
            }

        })

        ->where(function ($query){

            if($this->canhan_tatca == 'phieuDoiDuyet'){

                if(Auth::user()->hasPermissionTo('approve_1_ttdh')){

                    $query->orWhere(function($query){

                        $query->where('status', 'New');

                    }); 

                }
                if(Auth::user()->hasPermissionTo('approve_2_ttdh')){

                    $query->orWhere(function($query){

                        $query->where('status', 'Approve 1');

                    });

                }
                if(Auth::user()->hasPermissionTo('approve_3_ttdh')){

                    $query->orWhere(function($query){

                        $query->where('status', 'Approve 2');

                    });

                }

                if(Auth::user()->hasPermissionTo('create_ttdh')){

                    $query->orWhere(function($query){

                        $query->whereNotIn('phieu_ttdh.status', ['Finish', 'Reject 1', 'Reject 2', 'Reject 3', 'Reject 4']);

                        $query->where('phieu_ttdh.created_user', Auth::user()->username);

                    });

                }

            }elseif($this->canhan_tatca == 'phieuDaDuyet'){
                
                $query->where(function($query){

                    $query->orWhere(function($query){

                        $query->where('new', Auth::user()->username);
                        $query->where('status', 'Finish');

                    });
                    $query->orWhere('approved_1', Auth::user()->username);
                    $query->orWhere('approved_2', Auth::user()->username);
                    $query->orWhere('approved_3', Auth::user()->username);

                });
            }

        });

        $danhSachTTDH->select('so_phieu', 'customer', 'valid_from', 'valid_to', 'created_user', 'status')->distinct('so_phieu');
                
        $result = $danhSachTTDH->paginate($this->paginate);

        return view('livewire.t-t-d-h', compact('result'));
    }
}
