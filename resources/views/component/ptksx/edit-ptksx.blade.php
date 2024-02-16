<form wire:submit.prevent="updatePhieuMHDTY">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="editPhieuMHDTYModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Sửa phiếu thông báo thay đổi mã hàng DTY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            @if ($status == 'New')
                                @if (empty($sale))
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="quyCach" class="form-label">Mã hàng đang chạy</label>
                                                <input type="text" class="form-control" id="quyCach" placeholder="Quy cách" required wire:model.defer="quyCach">
                                            </div>
                                            <div class="col-6">
                                                <label for="maHang" class="form-label" style="color:white">|</label>
                                                <input type="text" class="form-control" id="maHang" placeholder="Mã" required wire:model.defer="maHang">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="ngay" class="form-label">Ngày</label>
                                                <input type="date" class="form-control" wire:model.defer="ngay" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label">Thông tin đổi mã</label>
                                                <input type="text" class="form-control" placeholder="Thông tin đổi mã" wire:model.defer="thongTinDoiMa">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="quyCach" class="form-label">Mã hàng đang chạy</label>
                                                <input type="text" class="form-control" id="quyCach" placeholder="Quy cách" required wire:model.defer="quyCach">
                                            </div>
                                            <div class="col-6">
                                                <label for="maHang" class="form-label" style="color:white">|</label>
                                                <input type="text" class="form-control" id="maHang" placeholder="Mã" required wire:model.defer="maHang">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="ngay" class="form-label">Ngày</label>
                                                <input type="date" class="form-control" wire:model.defer="ngay" required>
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
                                                <label class="form-label">Màu ống</label>
                                                <input type="text" class="form-control" placeholder="Màu ống" wire:model.defer="mauOng">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label">Sợi (Đơn/Chập)</label>
                                                <input type="text" class="form-control" placeholder="Sợi (Đơn/Chập)" wire:model.defer="soi">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label">Mã cũ - mới</label>
                                                <input type="text" class="form-control" placeholder="Mã cũ - mới" wire:model.defer="maCuMoi">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5">
                                                <label for="quyCachPOY" class="form-label">Quy cách POY</label>
                                                <input type="text" class="form-control" id="quyCachPOY" placeholder="Quy cách POY" required wire:model.defer="quyCachPOY">
                                            </div>
                                            <div class="col-7">
                                                <label for="maPOY" class="form-label">Mã POY</label>
                                                <input type="text" class="form-control" id="maPOY" placeholder="Mã POY" required wire:model.defer="maPOY">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5">
                                                <label for="quyCachDTY" class="form-label">Quy cách DTY</label>
                                                <input type="text" class="form-control" id="quyCachDTY" placeholder="Quy cách DTY" required wire:model.defer="quyCachDTY">
                                            </div>
                                            <div class="col-7">
                                                <label for="maDTY" class="form-label">Mã DTY</label>
                                                <input type="text" class="form-control" id="maDTY" placeholder="Mã DTY" required wire:model.defer="maDTY">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="tenCongTy" class="form-label">Khách hàng</label>
                                                <input type="text" class="form-control" id="tenCongTy" placeholder="Tên công ty" wire:model.defer="tenCongTy">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="loaiHang" class="form-label">Loại hàng</label>
                                                <input type="text" class="form-control" id="loaiHang" placeholder="Loại hàng" required wire:model.defer="loaiHang">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="soLuongDonHang" class="form-label">Số lượng đơn hàng</label>
                                                <input type="text" class="form-control" id="soLuongDonHang" placeholder ="Số lượng đơn hàng" required wire:model.defer="soLuongDonHang">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="ghiChuSoLuong" class="form-label">Ghi chú số lượng</label>
                                                <input type="text" class="form-control" id="ghiChuSoLuong" placeholder ="Ghi chú" required wire:model.defer="ghiChuSoLuong">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="dieuKienKhachHang" class="form-label">Điều kiện của khách hàng</label>
                                                <textarea class="form-control" id="dieuKienKhachHang" placeholder ="Điều kiện của khách hàng" required wire:model.defer="dieuKienKhachHang" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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