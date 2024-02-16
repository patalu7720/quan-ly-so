<form wire:submit.prevent="addPhieuTKSXFDY">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="addPhieuTKSXFDYModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tạo phiếu thông báo thay đổi mã hàng FDY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioTheoDon" value="phieuTheoDon" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadioTheoDon">Theo đơn</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioDuKien" value="phieuDukien" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadioDuKien">Dự kiến</label>
                                        </div>
                                        {{-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioDungMay" value="phieuDungMay" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadioDungMay">Stop máy</label>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label" {{ $theodon_dukien == 'phieuTheoDon' ? 'required' : 'hidden' }}>Số SO</label>
                                        <input type="text" placeholder="Nhập số SO" class="form-control" wire:model="soSO" {{ $theodon_dukien == 'phieuTheoDon' ? 'required' : 'hidden' }}>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="soMay" class="form-label">Line</label>
                                        <select class="form-select" id="soMay" wire:model.defer="line" required>
                                            <option value=''>Chọn line</option>
                                            <option value='14'>14</option>
                                            <option value='15'>15</option>
                                            <option value='16'>16</option>
                                            <option value='17'>17</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="ngay" class="form-label">Sale</label>
                                        <select class="form-select" wire:model.defer="sale" required>
                                            <option value="">Chọn sale</option>
                                            @if ($danhSachMail != null)
                                                @foreach ($danhSachMail as $item)
                                                    <option value="{{ $item->email }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label">Thông tin đổi mã</label>
                                        <input type="text" class="form-control" placeholder="Thông tin đổi mã" wire:model.defer="thongTinDoiMa">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="ngay" class="form-label">Ngày dự định thay đổi</label>
                                        <input type="date" class="form-control" wire:model.defer="ngayDuDinhThayDoi">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Quy cách cũ</label>
                                        <input type="text" class="form-control" placeholder="Quy cách cũ" wire:model.defer="quyCachCu">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Quy cách mới</label>
                                        <input type="text" class="form-control" placeholder="Quy cách mới" wire:model.defer="quyCachMoi">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Lot cũ</label>
                                        <input type="text" class="form-control" placeholder="Lot cũ" wire:model.defer="lotCu">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Lot mới</label>
                                        <input type="text" class="form-control" placeholder="Lot mới" wire:model.defer="lotMoi">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Trọng lượng (kg)</label>
                                        <input type="text" class="form-control" placeholder="Trọng lượng" wire:model.defer="trongLuong1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Trọng lượng (kg)</label>
                                        <input type="text" class="form-control" placeholder="Trọng lượng" wire:model.defer="trongLuong2">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Màu ống</label>
                                        <input type="text" class="form-control" placeholder="Màu ống" wire:model.defer="mauOng1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Màu ống</label>
                                        <input type="text" class="form-control" placeholder="Màu ống" wire:model.defer="mauOng2">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Chip</label>
                                        <input type="text" class="form-control" placeholder="Chip" wire:model.defer="chip1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Chip</label>
                                        <input type="text" class="form-control" placeholder="Chip" wire:model.defer="chip2">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Dầu</label>
                                        <input type="text" class="form-control" placeholder="Dầu" wire:model.defer="dau1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Dầu</label>
                                        <input type="text" class="form-control" placeholder="Dầu" wire:model.defer="dau2">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Đoạn</label>
                                        <input type="text" class="form-control" placeholder="Đoạn" wire:model.defer="doan1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Đoạn</label>
                                        <input type="text" class="form-control" placeholder="Đoạn" wire:model.defer="doan2">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label">Thông tin khác</label>
                                        <input type="text" class="form-control" placeholder="Thông tin khác" wire:model.defer="thongTinKhac">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Khách hàng</label>
                                        <input type="text" class="form-control" placeholder="Khách hàng" wire:model.defer="khachHang">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Số lượng</label>
                                        <input type="text" class="form-control" placeholder="Số lượng" wire:model.defer="soLuong">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label">Ghi chú</label>
                                        <textarea name="" id="" cols="30" rows="3" class="form-control" placeholder="Ghi chú" wire:model.defer="ghiChu"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </form>