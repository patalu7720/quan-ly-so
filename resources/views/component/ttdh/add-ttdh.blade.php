<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="createTTDHModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo TTDH</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="shadow-sm p-3 mb-4 bg-body-tertiary rounded">
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
                        <select class="form-select" wire:model.defer="soThapPhan">
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
                <div class="row">
                    <div class="col-12">
                        <h5>Thông tin đính kèm</h5>
                        <hr>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Buyer name</label>
                            <input type="text" class="form-control" placeholder="Buyer name" wire:model.defer="buyerName">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Consignee</label>
                            <input type="text" class="form-control" placeholder="Consignee" wire:model.defer="consignee">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Commission and agency name</label>
                            <input type="text" class="form-control" placeholder="Commission and agency name" wire:model.defer="commission">
                        </div>
                    </div>
                    {{-- <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">End use</label>
                            <input type="text" class="form-control" placeholder="End use" wire:model.defer="endUse">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Fabric 
                                construction</label>
                            <input type="text" class="form-control" placeholder="Fabric construction" wire:model.defer="fabricConstruction">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">1 set of yarn</label>
                            <input type="text" class="form-control" placeholder="1 set of yarn" wire:model.defer="_1setOfYarn">
                        </div>
                    </div> --}}
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Incoterms</label>
                            <input type="text" class="form-control" placeholder="Incoterms" wire:model.defer="incoterms">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Payment terms</label>
                            <input type="text" class="form-control" placeholder="Payment terms" wire:model.defer="paymentTerms">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="text" class="form-control" placeholder="Payment Date" wire:model.defer="paymentDate">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Delivery Date</label>
                            <input type="text" class="form-control" placeholder="Delivery Date" wire:model.defer="deliveryDate">
                        </div>
                    </div>
                    {{-- <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Brand name</label>
                            <input type="text" class="form-control" placeholder="Brand name" wire:model.defer="brandName">
                        </div>
                    </div> --}}
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Packing</label>
                            <input type="text" class="form-control" placeholder="Packing" wire:model.defer="packing">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Truck fee</label>
                            <input type="text" class="form-control" placeholder="Truck fee" wire:model.defer="truckFee">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">T/C</label>
                            <input type="text" class="form-control" placeholder="T/C" wire:model.defer="tc">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">C/O</label>
                            <input type="text" class="form-control" placeholder="C/O" wire:model.defer="co">
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                <form wire:submit.prevent="loadFileExcel">
                    <div class="row mb-4 g-4 align-items-center">
                        <div class="col-12 col-md-6">
                            <input class="form-control" type="file" wire:model="fileExcel" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <button type="submit" class="btn btn-outline-primary">Load Excel</button>
                        </div>
                    </div>
                </form>
                @if ($dataFileExcel!=null)
                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive" style="width:5500px">
                                        <thead>
                                            <tr>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Customer No</th>
                                            <th scope="col">Ship time</th>
                                            <th scope="col">Stock/new product</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Spec</th>
                                            <th scope="col">Grade</th>
                                            <th scope="col">Material</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Excluded VAT price(USD)</th>
                                            <th scope="col">Excluded VAT price(VND)</th>
                                            <th scope="col">Zpr0 (USD)</th>
                                            <th scope="col">Zpr0 (VND)</th>
                                            <th scope="col">List price</th>
                                            <th scope="col">Product hierarchy</th>
                                            <th scope="col">Transportation fee(USD)</th>
                                            <th scope="col">Transportation fee(VND)</th>
                                            <th scope="col">Small cone fee(USD)</th>
                                            <th scope="col">Small cone fee(VND)</th>
                                            <th scope="col">Unload fee(USD)</th>
                                            <th scope="col">Unload fee(VND)</th>
                                            <th scope="col">Banking fee(USD)</th>
                                            <th scope="col">Banking fee(VND)</th>
                                            <th scope="col">Pallet fee(USD)</th>
                                            <th scope="col">Pallet fee(VND)</th>
                                            <th scope="col">Commission fee(USD)</th>
                                            <th scope="col">Commission fee(VND)</th>
                                            <th scope="col">T/C fee(USD)</th>
                                            <th scope="col">T/C fee(VND)</th>
                                            <th scope="col">Other fee(USD)</th>
                                            <th scope="col">Other fee(VND)</th>
                                            <th scope="col">Payment term</th>
                                            <th scope="col">Exchange rate</th>
                                            <th scope="col">Stock in year</th>
                                            <th scope="col">Customer type</th>
                                            <th scope="col">Remark</th>
                                            <th scope="col">Delivery term</th>
                                            <th scope="col">CS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataFileExcel as $item)
                                                <tr>
                                                    <td>{{ $item['Customer'] }}</td>
                                                    <td>{{ $item['Customer No'] }}</td>
                                                    <td>{{ $item['Ship time'] }}</td>
                                                    <td>{{ $item['Stock/new product'] }}</td>
                                                    <td>{{ $item['address'] }}</td>
                                                    <td>{{ $item['Spec'] }}</td>
                                                    <td>{{ $item['Grade'] }}</td>
                                                    <td>{{ $item['Material'] }}</td>
                                                    <td>{{ $item['Qty'] }}</td>
                                                    <td>{{ $item['Excluded VAT price(USD)'] }}</td>
                                                    <td>{{ $item['excluded VAT price(VND)'] }}</td>
                                                    <td>{{ $item['Zpr0 (USD)'] }}</td>
                                                    <td>{{ $item['Zpr0 (VND)'] }}</td>
                                                    <td>{{ $item['List price'] }}</td>
                                                    <td>{{ $item['Product hierarchy'] }}</td>
                                                    <td>{{ $item['Transportation fee(USD)'] }}</td>
                                                    <td>{{ $item['Transportation fee(VND)'] }}</td>
                                                    <td>{{ $item['Small cone fee(USD)'] }}</td>
                                                    <td>{{ $item['Small cone fee(VND)'] }}</td>
                                                    <td>{{ $item['Unload fee(USD)'] }}</td>
                                                    <td>{{ $item['Unload fee(VND)'] }}</td>
                                                    <td>{{ $item['Banking fee(USD)'] }}</td>
                                                    <td>{{ $item['Banking fee(VND)'] }}</td>
                                                    <td>{{ $item['Pallet fee(USD)'] }}</td>
                                                    <td>{{ $item['Pallet fee(VND)'] }}</td>
                                                    <td>{{ $item['Commission fee(USD)'] }}</td>
                                                    <td>{{ $item['Commission fee(VND)'] }}</td>
                                                    <td>{{ $item['T/C fee(USD)'] }}</td>
                                                    <td>{{ $item['T/C fee(VND)'] }}</td>
                                                    <td>{{ $item['Other fee(USD)'] }}</td>
                                                    <td>{{ $item['Other fee(VND)'] }}</td>
                                                    <td>{{ $item['Payment term'] }}</td>
                                                    <td>{{ $item['Exchange rate'] }}</td>
                                                    <td>{{ $item['Stock in year'] }}</td>
                                                    <td>{{ $item['Customer type'] }}</td>
                                                    <td>{{ $item['Remark'] }}</td>
                                                    <td>{{ $item['Delivery term'] }}</td>
                                                    <td>{{ $item['CS'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row g-4 mb-3">
                    <div class="col-12 col-lg-6">
                        <label for="" class="form-label">Sale</label>
                        <select class="form-select" aria-label="Default select example" wire:model.defer="mailSale">
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
                                <select class="form-select" aria-label="Default select example" wire:model.defer="mailPhu1">
                                    <option value="" selected>Chọn mail</option>
                                    @foreach ($danhSachMailSaleAll as $item)
                                        <option value="{{ $item->email }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <select class="form-select" aria-label="Default select example" wire:model.defer="mailPhu2">
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
                        <textarea class="form-control" placeholder="Ghi chú" rows="3" wire:model.defer="note"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-primary" wire:click="createTTDH">Thực hiện</button>
        </div>
      </div>
    </div>
</div>