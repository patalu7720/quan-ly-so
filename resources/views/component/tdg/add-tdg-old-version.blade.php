<form action="" wire:submit.prevent="createTDGOldVersion">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="createTDGOldVersionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo TDG - Upload File</h1>
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
                                <label class="form-label">Validity of Payment</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Validity of Payment" wire:model.defer="validityOfPayment">
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
                                <input type="number" placeholder="Small cone fee(USD)" class="form-control form-control-sm" wire:model.defer="smallConeUSD" step="any">
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
                                <input type="number" placeholder="Unload fee(USD)" class="form-control form-control-sm" wire:model.defer="unloadUSD" step="any">
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
                                <input type="number" placeholder="Banking fee(USD)" class="form-control form-control-sm" wire:model.defer="bankingUSD" step="any">
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
                                <input type="number" placeholder="Pallet fee(USD)" class="form-control form-control-sm" wire:model.defer="palletUSD" step="any">
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
                                <input type="number" placeholder="Commission fee(USD)" class="form-control form-control-sm" wire:model.defer="commissionUSD" step="any">
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
                                <input type="number" placeholder="Mang co fee(USD)" class="form-control form-control-sm" wire:model.defer="mangCoUSD" step="any">
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
                                <input type="number" placeholder="Claim fee(USD)" class="form-control form-control-sm" wire:model.defer="claimUSD" step="any">
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
                                <input type="number" placeholder="TC fee(USD)" class="form-control form-control-sm" wire:model.defer="tcUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxTC == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">TC fee(VND)</label>
                                <input type="number" placeholder="TC fee(VND)" class="form-control form-control-sm" wire:model.defer="tcVND"  step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxOther == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Other fee(USD)</label>
                                <input type="number" placeholder="Other fee(USD)" class="form-control form-control-sm" wire:model.defer="otherUSD" step="any">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6" {{ $checkBoxOther == '1' ? '' : 'hidden'}}>
                            <div class="mb-3">
                                <label for="" class="form-label">Other fee(VND)</label>
                                <input type="number" placeholder="Other fee(VND)" class="form-control form-control-sm" wire:model.defer="otherVND"  step="any">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                    <form wire:submit.prevent="loadFileExcelOld">
                        <div class="row mb-4 g-4 align-items-center">
                            <div class="col-12 col-md-6">
                                <input class="form-control" type="file" wire:model="fileExcel" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn btn-outline-primary">Load Excel</button>
                            </div>
                        </div>
                    </form>
                    <div class="row g-4 mb-3">
                        <div class="col-12 col-lg-6">
                            <label for="" class="form-label">Admin</label>
                            <select class="form-select form-select-sm" aria-label="Default select example" wire:model.defer="mailSale">
                                <option value="" selected>Chọn sale</option>
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