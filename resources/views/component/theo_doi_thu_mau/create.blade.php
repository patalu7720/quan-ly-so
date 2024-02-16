<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="store">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="createModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tạo theo dõi mẫu</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'create')
                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Ngày</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.ngay">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Tên khách hàng</label>
                                <input class="form-control form-control-sm" list="datalistOptions" placeholder="Nhập tên khách hàng" wire:model.defer = "theoDoiThuMauModel.ma_khach_hang" required>
                                <datalist id="datalistOptions">
                                    @foreach ($danhSachKhachHang as $item)
                                        <option value="{{ $item->ma_khach_hang }}">{{ $item->ten_tv }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.dia_chi">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Item</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.loai_soi">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Lot No</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.lot">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Quantity</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.so_luong">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Delivery date</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.ngay_giao">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Customer products</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.san_pham_cua_khach_hang">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Customer Category</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.phan_loai_khach_hang">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Textile machine</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.may_det">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Textile Structure</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.cau_truc_det">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Sample for free/selling</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.trang_thai">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Potential Bulk Qty</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.so_luong_tiem_nang">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Forecast Season/Month for bulk order </label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.du_kien">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kinh Doanh kiến nghị</label>
                                <textarea name="" id="" cols="30" rows="5" class="form-control form-control-sm" placeholder="Nhập kinh doanh kiến nghị" wire:model.defer="theoDoiThuMauModel.sale_kien_nghi"></textarea>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Ngày giao hàng</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.ngay_giao_hang">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Ngày nhận vải mẫu</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.ngay_nhan_vai_mau">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Kết quả thử mẫu</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.ket_qua_thu_mau">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Đơn hàng thực tế</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="theoDoiThuMauModel.don_hang_thuc_te">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phản hồi của KH</label>
                                <textarea name="" id="" cols="30" rows="5" class="form-control form-control-sm" placeholder="Nhập phản hồi của KH" wire:model.defer="theoDoiThuMauModel.phan_hoi_khach_hang"></textarea>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif
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