<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="addPhieuXXDH">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="addPhieuXXDHModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tạo phiếu xem xét đơn hàng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="dht" wire:model.defer="loaiDonHang">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Đơn hàng thường
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="dhm" wire:model.defer="loaiDonHang">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Đơn hàng mẫu
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="donHangGRS" wire:model.defer="donHangGRS">
                                            <label class="form-check-label" for="donHangGRS">
                                                Đơn hàng GRS
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="donHangNonGRS" wire:model.defer="donHangNonGRS">
                                            <label class="form-check-label" for="donHangNonGRS">
                                                Đơn hàng Non GRS
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="donHangSXMoi" wire:model.defer="donHangSXMoi">
                                            <label class="form-check-label" for="donHangSXMoi">
                                                Đơn hàng SX mới 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="donHangLapLai" wire:model.defer="donHangLapLai">
                                            <label class="form-check-label" for="donHangLapLai">
                                                Đơn hàng lặp lại 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="donHangTonKho" wire:model.defer="donHangTonKho">
                                            <label class="form-check-label" for="donHangTonKho">
                                                Đơn hàng tồn kho
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="date" class="col-sm-1 col-form-label">Date</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="date" required wire:model.defer="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Số SO</label>
                                        <input class="form-control" wire:model.defer="soSO" placeholder="Nhập SO..." required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Số HĐ</label>
                                        <input class="form-control" wire:model.defer="soHD" placeholder="Nhập HĐ...">
                                    </div>
                                    <div class="col-12">
                                        <label for="tenCongTy" class="form-label">Tên công ty</label>
                                        <input type="text" class="form-control" id="tenCongTy" placeholder="Tên công ty" required wire:model.defer="tenCongTy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label">Mail chính</label>
                                        <select class="form-select" aria-label="Default select example" wire:model.defer="mailChinh" required>
                                            <option value="">Chọn mail chính</option>
                                            @foreach ($danhSachMail as $item)
                                                <option value="{{ $item->email }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Mail phụ 1</label>
                                        <select class="form-select" aria-label="Default select example" wire:model.defer="mailPhu1">
                                            <option value="">Chọn mail phụ</option>
                                            @foreach ($danhSachMail as $item)
                                                <option value="{{ $item->email }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Mail phụ 2</label>
                                        <select class="form-select" aria-label="Default select example" wire:model.defer="mailPhu2">
                                            <option value="">Chọn mail phụ</option>
                                            @foreach ($danhSachMail as $item)
                                                <option value="{{ $item->email }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row mb-3">
                                    <div class="col">
                                        <button class="btn btn-primary btn-sm" wire:click.prevent="add({{ $i }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
                                    </div>
                                </div>
                                <div class="row mb-2 g-2">
                                    <div class="col-8">
                                        <label class="form-label">Quy cách</label>
                                        <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachSuDung.0">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Số lượng (kg)</label>
                                        <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuong.0">
                                    </div>
                                </div>
                                @foreach($inputs as $key => $value)
                                    <hr>
                                    <div class="row mb-2 g-2">
                                        <div class="col-8">
                                            <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachSuDung.{{ $value }}">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuong.{{ $value }}">
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-outline-danger btn-sm"  style="margin-top: 3px" wire:click.prevent="remove({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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