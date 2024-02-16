<form action="" wire:submit.prevent="createTTDHNewVersion">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="createTTDHNewVersionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo TTDH</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField"></button>
            </div>
            <div class="modal-body">
                <div class="shadow-sm p-2 mb-4 bg-body-tertiary rounded">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" wire:model.defer="uncheckData">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Uncheck data
                                </label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Số thập phân</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" wire:model.defer="soThapPhan">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Order Information</h5>
                            <hr>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Buyer</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Buyer" wire:model.defer="buyer" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Buyer type / Buyer code</label>
                                <div class="input-group mb-3">
                                    <select name="" id="" class="form-select form-select-sm" wire:model.defer="buyerType">
                                        <option value="local">Local</option>
                                        <option value="export">Export</option>
                                        <option value="localexport">Local Export</option>
                                    </select>
                                    <input type="number" class="form-control form-control-sm" placeholder="Buyer code" wire:model.defer="buyerCode">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Consignee</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Consignee" wire:model.defer="consignee">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Agency</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Agency" wire:model.defer="agency">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Brand" wire:model.defer="brand">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">GRS T/C</label>
                                <input type="text" class="form-control form-control-sm" placeholder="GRS T/C" wire:model.defer="tc">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">C/O</label>
                                <input type="text" class="form-control form-control-sm" placeholder="C/O" wire:model.defer="co">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Incoterms 2010</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Incoterms 2010" wire:model.defer="incoterms">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Payment terms</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Payment terms" wire:model.defer="paymentTerms">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Validity of Delivery</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Validity of Delivery" wire:model.defer="validityOfDelivery">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Contract Expiration Date</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contract Expiration Date" wire:model.defer="validityOfPayment">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Application</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Application" wire:model.defer="application">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Cone/set</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Cone/set" wire:model.defer="coneSet">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kg/cone</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Kg/conet" wire:model.defer="kgCone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Packing</label>
                            <input class="form-control form-control-sm" list="datalistThongTinDongGoi" placeholder="Packing" wire:model.defer = "packing">
                            <datalist id="datalistThongTinDongGoi">
                                @if ($listThongTinDongGoi != null)
                                    @foreach ($listThongTinDongGoi as $item)
                                        <option value="{{ $item->thong_tin_dong_goi }}"></option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Exchange rate</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Exchange rate" wire:model.defer="exchangeRate" required>
                                <input type="text" class="form-control form-control-sm" placeholder="ACCORDING TO VCB BANK - USD SELLING RATE ON 26/04/2023 13:00" wire:model.defer="exchangeRateDay" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hangChanHangLeName" id="inlineRadioHangChan" value="hangChan" wire:model="hangChanHangLe">
                                <label class="form-check-label" for="inlineRadioHangChan">Hàng chẵn</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hangChanHangLeName" id="inlineRadioHangLe" value="hangLe" wire:model="hangChanHangLe">
                                <label class="form-check-label" for="inlineRadioHangLe">Hàng lẻ</label>
                            </div>
                        </div>
                    </div>
                    {{-- FORM Quy cách --}}
                    @if ($hangChanHangLe == 'hangLe')
                        <div class="row mb-3 align-items-center">
                            <div class="col-12 col-md-6">
                                <input class="form-control form-control-sm" type="file" wire:model.defer="fileExcel" required multiple>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-12 col-lg-5">
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" wire:click.prevent="add({{ $i }})">+ Thêm quy cách</button>
                            </div>
                        </div>
                        @if ($hangChanHangLe == 'hangChan')
                            <div class="col-12 col-lg-7">
                                <div class="row g-2 mb-3 align-items-center">
                                    <div class="col-12 col-md-10">
                                        <input class="form-control form-control-sm float-end" type="file" wire:model.defer="fileExcel">
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="button" class="btn btn-outline-success btn-sm float-end" wire:click.prevent = "loadFileExcelNew">Load Excel</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach ($inputs as $key => $value)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link{{ $key == array_key_last($inputs) ? ' active' : '' }}" id="tab{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $key }}-tab-pane" type="button" role="tab" aria-controls="tab{{ $key }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$key + 1 }}</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @foreach ($inputs as $key => $value)
                                            <div class="tab-pane fade{{ $key == array_key_last($inputs) ? ' show active' : '' }}" id="tab{{ $key }}-tab-pane" role="tabpanel" aria-labelledby="tab{{ $key }}-tab" tabindex="0">
                                                <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Spec</label>
                                                                <input type="text" placeholder="Spec" class="form-control form-control-sm" wire:model.defer="spec.{{ $value }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Grade</label>
                                                                <input type="text" placeholder="Grade" class="form-control form-control-sm" wire:model.defer="grade.{{ $value }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Lot Number</label>
                                                                <input type="text" placeholder="Matetial" class="form-control form-control-sm" wire:model.defer="material.{{ $value }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Qty (kg)</label>
                                                                <input type="number" placeholder="Quantity" class="form-control form-control-sm" wire:model.defer="quantity.{{ $value }}" step="any" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <label for="" class="form-label">Excluded VAT</label>
                                                            <div class="input-group mb-3">
                                                                <input type="number" class="form-control form-control-sm" placeholder="USD" wire:model.defer="excludedVatUSD.{{ $value }}" step="any" required>
                                                                <input type="number" class="form-control form-control-sm" placeholder="VND" wire:model.defer="excludedVatVND.{{ $value }}" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <label for="" class="form-label">Zpr0</label>
                                                            <div class="input-group mb-3">
                                                                <input type="number" class="form-control form-control-sm" placeholder="USD" wire:model.defer="zpr0USD.{{ $value }}" step="any">
                                                                <input type="number" class="form-control form-control-sm" placeholder="VND" wire:model.defer="zpr0VND.{{ $value }}" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">List price</label>
                                                                <input type="number" placeholder="List price" class="form-control form-control-sm" wire:model.defer="listPrice.{{ $value }}" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Stock year</label>
                                                                <input type="text" placeholder="Stock in year" class="form-control form-control-sm" wire:model.defer="stockInYear.{{ $value }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($key != 0)
                                                        <div class="row">
                                                            <div class="col">
                                                                <button class="btn btn-outline-danger btn-sm float-end"  style="margin-top: 3px" wire:click.prevent="remove({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- FORM Hàng lẻ --}}
                    {{-- @if ($hangChanHangLe == 'hangLe')
                        <div class="row mb-3">
                            <div class="row mb-4 align-items-center">
                                <div class="col-12 col-md-6">
                                    <input class="form-control form-control-sm" type="file" wire:model.defer="fileExcel" required multiple>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" wire:click="addHangLe({{ $iHangLe }})">+ Thêm quy cách</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($inputsHangLe as $key => $value)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $key == array_key_last($inputsHangLe) ? ' active' : '' }}" id="tab{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $key }}-tab-pane" type="button" role="tab" aria-controls="tab{{ $key }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$key + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($inputsHangLe as $key => $value)
                                                <div class="tab-pane fade{{ $key == array_key_last($inputsHangLe) ? ' show active' : '' }}" id="tab{{ $key }}-tab-pane" role="tabpanel" aria-labelledby="tab{{ $key }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Spec</label>
                                                                    <input type="text" placeholder="Spec" class="form-control form-control-sm" wire:model.defer="specHangLe.{{ $value }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Matetial</label>
                                                                    <input type="text" placeholder="Matetial" class="form-control form-control-sm" wire:model.defer="materialHangLe.{{ $value }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Grade</label>
                                                                    <input type="text" placeholder="Grade" class="form-control form-control-sm" wire:model.defer="gradeHangLe.{{ $value }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Quantity</label>
                                                                    <input type="text" placeholder="Quantity" class="form-control form-control-sm" wire:model.defer="quantityHangLe.{{ $value }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Excluded VAT</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="number" class="form-control form-control-sm" placeholder="USD" wire:model.defer="excludedVatUSDHangLe.{{ $value }}" step="any" required>
                                                                    <input type="number" class="form-control form-control-sm" placeholder="VND" wire:model.defer="excludedVatVNDHangLe.{{ $value }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Zpr0</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="number" class="form-control form-control-sm" placeholder="USD" wire:model.defer="zpr0USDHangLe.{{ $value }}" step="any">
                                                                    <input type="number" class="form-control form-control-sm" placeholder="VND" wire:model.defer="zpr0VNDHangLe.{{ $value }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">List price</label>
                                                                    <input type="text" placeholder="List price" class="form-control form-control-sm" wire:model.defer="listPriceHangLe.{{ $value }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Stock year</label>
                                                                    <input type="text" placeholder="Stock in year" class="form-control form-control-sm" wire:model.defer="stockInYearHangLe.{{ $value }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>

                {{-- FORM Fee --}}
                <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxTransportation" wire:model="checkBoxTransportation" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxTransportation">
                            Transportation fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxSmallCone" wire:model="checkBoxSmallCone" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxSmallCone">
                            Small cone fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxUnload" wire:model="checkBoxUnload" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxUnload">
                            Unload fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxBanking" wire:model="checkBoxBanking" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxBanking">
                            Banking fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxPallet" wire:model="checkBoxPallet" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxPallet">
                            Pallet fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxCommission" wire:model="checkBoxCommission" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxCommission">
                            Commission fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxMangCo" wire:model="checkBoxMangCo" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxMangCo">
                            Mang co fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxClaim" wire:model="checkBoxClaim" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxClaim">
                            Claim fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxTC" wire:model="checkBoxTC" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxTC">
                            TC fee
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" id="checkBoxOther" wire:model="checkBoxOther" wire:click="checkBoxClick">
                        <label class="form-check-label" for="checkBoxOther">
                            Other fee
                        </label>
                    </div>
                    <div class="row py-2">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6" {{ $checkBoxTransportation == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Transportation fee(USD)</label>
                                <input type="number" placeholder="Transportation fee(USD)" class="form-control form-control-sm" wire:model.defer="tranFeeUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxTransportation == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Transportation fee(VND)</label>
                                <input type="number" placeholder="Transportation fee(VND)" class="form-control form-control-sm" wire:model.defer="tranFeeVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxSmallCone == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Small cone fee(USD)</label>
                                <input type="number" placeholder="Small cone fee(VND)" class="form-control form-control-sm" wire:model.defer="smallConeUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxSmallCone == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Small cone fee(VND)</label>
                                <input type="number" placeholder="Small cone fee(VND)" class="form-control form-control-sm" wire:model.defer="smallConeVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxUnload == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Unload fee(USD)</label>
                                <input type="number" placeholder="Unload fee(VND)" class="form-control form-control-sm" wire:model.defer="unloadUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxUnload == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Unload fee(VND)</label>
                                <input type="number" placeholder="Unload fee(VND)" class="form-control form-control-sm" wire:model.defer="unloadVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxBanking == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Banking fee(USD)</label>
                                <input type="number" placeholder="Banking fee(VND)" class="form-control form-control-sm" wire:model.defer="bankingUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxBanking == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Banking fee(VND)</label>
                                <input type="number" placeholder="Banking fee(VND)" class="form-control form-control-sm" wire:model.defer="bankingVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxPallet == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Pallet fee(USD)</label>
                                <input type="number" placeholder="Pallet fee(VND)" class="form-control form-control-sm" wire:model.defer="palletUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxPallet == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Pallet fee(VND)</label>
                                <input type="number" placeholder="Pallet fee(VND)" class="form-control form-control-sm" wire:model.defer="palletVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxCommission == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Commission fee(USD)</label>
                                <input type="number" placeholder="Commission fee(VND)" class="form-control form-control-sm" wire:model.defer="commissionUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxCommission == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Commission fee(VND)</label>
                                <input type="number" placeholder="Commission fee(VND)" class="form-control form-control-sm" wire:model.defer="commissionVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxMangCo == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Mang co fee(USD)</label>
                                <input type="number" placeholder="Mang co fee(VND)" class="form-control form-control-sm" wire:model.defer="mangCoUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxMangCo == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Mang co fee(VND)</label>
                                <input type="number" placeholder="Mang co fee(VND)" class="form-control form-control-sm" wire:model.defer="mangCoVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxClaim == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Claim fee(USD)</label>
                                <input type="number" placeholder="Claim fee(VND)" class="form-control form-control-sm" wire:model.defer="claimUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxClaim == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Claim fee(VND)</label>
                                <input type="number" placeholder="Claim fee(VND)" class="form-control form-control-sm" wire:model.defer="claimVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxTC == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">TC fee(USD)</label>
                                <input type="number" placeholder="TC fee(VND)" class="form-control form-control-sm" wire:model.defer="tcUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxTC == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">TC fee(VND)</label>
                                <input type="number" placeholder="TC fee(VND)" class="form-control form-control-sm" wire:model.defer="tcVND" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4" {{ $checkBoxOther == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Enter the fee name</label>
                                <input type="text" placeholder="Enter the fee name (e.g : BPA fee)" class="form-control form-control-sm" wire:model.defer="nameOtherFee"  {{ $checkBoxOther == '1' ? 'required' : ''}}>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4" {{ $checkBoxOther == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">USD</label>
                                <input type="number" placeholder="USD" class="form-control form-control-sm" wire:model.defer="otherUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4" {{ $checkBoxOther == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">VND</label>
                                <input type="number" placeholder="VND" class="form-control form-control-sm" wire:model.defer="otherVND"  step="any">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                    <div class="row g-4 mb-3">
                        <div class="col-12 col-lg-6">
                            <label for="" class="form-label">Admin</label>
                            <select class="form-select form-select-sm" aria-label="Default select example" wire:model.defer="mailSale">
                                <option value="" selected>Chọn Sale Admin</option>
                                @foreach ($danhSachMailSale as $item)
                                    <option value="{{ $item->email }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="" class="form-label">Mail phụ</label>
                                    <select class="form-select form-select-sm" aria-label="Default select example" wire:model.defer="mailPhu1">
                                        <option value="" selected>Chọn mail</option>
                                        @foreach ($danhSachMailSaleAll as $item)
                                            <option value="{{ $item->email }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <select class="form-select form-select-sm" aria-label="Default select example" wire:model.defer="mailPhu2">
                                        <option value="" selected>Chọn mail</option>
                                        @foreach ($danhSachMailSaleAll as $item)
                                            <option value="{{ $item->email }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Ghi chú</label>
                            <textarea class="form-control form-control-sm" placeholder="Ghi chú" rows="3" wire:model.defer="note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField">Đóng</button>
            <button type="submit" class="btn btn-primary">Thực hiện</button>
            </div>
        </div>
        </div>
    </div>
</form>