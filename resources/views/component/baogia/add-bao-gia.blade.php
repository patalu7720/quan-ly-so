<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="addBaoGia">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="addBaoGiaModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tạo phiếu Báo Giá</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="nd" wire:model.defer="loaiBaoGia">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Nội địa
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="xk" wire:model.defer="loaiBaoGia">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Xuất khẩu
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <label class="form-label">Ngày</label>
                            <input type="date" class="form-control" wire:model.defer = "ngay">
                        </div>
                        <div class="col-12">
                            <label class="form-label">To</label>
                            <input type="text" class="form-control" placeholder="Nhập khách hàng" wire:model.defer = "to">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <button class="btn btn-primary btn-sm" wire:click.prevent="add({{ $i }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm item / {{ count($inputs) + 1 . ' item' }}</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Yarn Type</h5>
                                        <div class="row mb-2 g-2">
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType1.0" required>
                                                    <option value="">--- No item select ---</option>
                                                    <option value="DTY">DTY</option>
                                                    <option value="FDY">FDY</option>
                                                    <option value="POY">POY</option>
                                                    <option value="OEM">OEM</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType2.0">
                                                    <option>--- No select ---</option>
                                                    <option value="SD">SD</option>
                                                    <option value="FD">FD</option>
                                                    <option value="Bright">Bright</option>
                                                    <option value="CD">CD</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Nhập Denier" wire:model.defer="yarnType3.0">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Filament" wire:model.defer="yarnType4.0">
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType5.0">
                                                    <option>--- No select ---</option>
                                                    <option value="Round">Round</option>
                                                    <option value="Cross">Cross</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType6.0">
                                                    <option>--- No select ---</option>
                                                    <option value="Virgin">Virgin</option>
                                                    <option value="Recycle">Recycle</option>
                                                    <option value="50% Virgin - 50% Recycle">50% Virgin - 50% Recycle</option>
                                                    <option value="5% Recycle - 5% Recycle">5% Recycle - 5% Recycle</option>
                                                    <option value="5% Virgin - 5% Virgin">5% Virgin - 5% Virgin</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">OEM (nếu có)</label>
                                                <input type="text" class="form-control" placeholder="Nhập OEM (nếu có)" wire:model.defer="oem.0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" class="form-control" placeholder="Nhập Quantity" required wire:model.defer="quantity.0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Bobbin Weight</label>
                                                <input type="text" class="form-control" placeholder="Nhập Bobbin Weight" required wire:model.defer="bobbinWeight.0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Yarn Price</label>
                                                <input type="text" class="form-control" placeholder="Nhập Yarn Price" required wire:model.defer="yarnPrice.0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Grade</label>
                                                {{-- <select class="form-select" aria-label="Default select example" wire:model.defer="grade.0">
                                                    <option>--- No select ---</option>
                                                    <option value="AAA">AAA</option>
                                                    <option value="AA">AA</option>
                                                    <option value="AA+A">AA+A</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select> --}}
                                                <input type="text" class="form-control" placeholder="Nhập Grade" required wire:model.defer="grade.0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($inputs as $key => $value)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Yarn Type</h5>
                                        <div class="row mb-2 g-2">
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType1.{{ $value }}" required>
                                                    <option value="">--- No item select ---</option>
                                                    <option value="DTY">DTY</option>
                                                    <option value="FDY">FDY</option>
                                                    <option value="POY">POY</option>
                                                    <option value="OEM">OEM</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType2.{{ $value }}">
                                                    <option>--- No select ---</option>
                                                    <option value="SD">SD</option>
                                                    <option value="FD">FD</option>
                                                    <option value="Bright">Bright</option>
                                                    <option value="CD">CD</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Nhập Denier" wire:model.defer="yarnType3.{{ $value }}">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Filament" wire:model.defer="yarnType4.{{ $value }}">
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType5.{{ $value }}">
                                                    <option>--- No select ---</option>
                                                    <option value="Round">Round</option>
                                                    <option value="Cross">Cross</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select" aria-label="Default select example" wire:model.defer="yarnType6.{{ $value }}">
                                                    <option>--- No select ---</option>
                                                    <option value="Virgin">Virgin</option>
                                                    <option value="Recycle">Recycle</option>
                                                    <option value="50% Virgin - 50% Recycle">50% Virgin - 50% Recycle</option>
                                                    <option value="5% Recycle - 5% Recycle">5% Recycle - 5% Recycle</option>
                                                    <option value="5% Virgin - 5% Virgin">5% Virgin - 5% Virgin</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">OEM (nếu có)</label>
                                                <input type="text" class="form-control" placeholder="Nhập OEM (nếu có)" wire:model.defer="oem.{{ $value }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" class="form-control" placeholder="Nhập Quantity" required wire:model.defer="quantity.{{ $value }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Bobbin Weight</label>
                                                <input type="text" class="form-control" placeholder="Nhập Bobbin Weight" required wire:model.defer="bobbinWeight.{{ $value }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Yarn Price</label>
                                                <input type="text" class="form-control" placeholder="Nhập Yarn Price" required wire:model.defer="yarnPrice.{{ $value }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Grade</label>
                                                <input type="text" class="form-control" placeholder="Nhập Grade" required wire:model.defer="grade.{{ $value }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-1">
                                        <button class="btn btn-outline-danger btn-sm float-end"  style="margin-top: 3px" wire:click.prevent="remove({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Remark</label>
                            <textarea name="" id="" cols="30" rows="5" class="form-control" placeholder="Nhập Remark" wire:model.defer = "remark"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Payment terms</label>
                            <input type="text" class="form-control" placeholder="Nhập Payment terms" wire:model.defer = "paymentTerms">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Exchange rate</label>
                            <input type="text" class="form-control" placeholder="Nhập Exchange rate" wire:model.defer = "exchangeRate">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Valid date</label>
                            <input type="text" class="form-control" placeholder="Nhập Valid date" wire:model.defer = "validDate">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </form>