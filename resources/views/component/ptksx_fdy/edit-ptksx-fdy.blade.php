<form wire:submit.prevent="updatePhieuTKSXFDY">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="editPhieuTKSXFDYModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Sửa phiếu thông báo thay đổi mã hàng FDY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            @if ($status == 'New')
                                <div class="shadow p-3 bg-body-tertiary rounded">
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
                            @elseif ($status == 'QA APPROVED')
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="form-label">QA kiến nghị</label>
                                            <input type="text" class="form-control" placeholder="Nhập kiến nghị" wire:model.defer="qaKienNghi" required>
                                        </div>
                                    </div>
                                </div>
                            @endif
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