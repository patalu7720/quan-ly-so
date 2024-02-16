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
                  <h5 class="modal-title">Tạo tiêu chuẩn khách hàng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'create')
                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Tên khách hàng</label>
                                <input class="form-control form-control-sm" list="datalistOptions" placeholder="Nhập tên khách hàng" wire:model.defer = "tieuChuanKhachHangModel.ma_khach_hang" required>
                                <datalist id="datalistOptions">
                                    @foreach ($danhSachKhachHang as $item)
                                        <option value="{{ $item->ma_khach_hang }}">{{ $item->ten_tv }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Loại máy dệt</label>
                                <select name="" id="" class="form-select form-select-sm" wire:model.defer="tieuChuanKhachHangModel.loai_may_det" required>
                                    <option value="">***</option>
                                    @foreach ($danhSachLoaiMayDet as $itemLoaiMayDet)
                                        <option value='{{ $itemLoaiMayDet->loai_may_det }}'>{{ $itemLoaiMayDet->loai_may_det }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Quy cách sợi</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập quy cách sợi" wire:model.defer="tieuChuanKhachHangModel.quy_cach_soi" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chủng loại sợi</label>
                                <select name="" id="" class="form-select form-select-sm" wire:model.defer="tieuChuanKhachHangModel.chung_loai_soi" required>
                                    <option value="">***</option>
                                    <option value='SET1'>SET1</option>
                                    <option value='SET9'>SET9</option>
                                    <option value='SET10'>SET10</option>
                                    <option value='SY'>SY</option>
                                    <option value='MSY'>MSY</option>
                                    <option value='NSY'>NSY</option>
                                    <option value='NNSY'>NNSY</option>
                                    <option value='AS'>AS</option>
                                    <option value='SY HCR'>SY HCR</option>
                                    <option value='WL'>WL</option>
                                    <option value='By pass'>By pass</option>
                                    <option value='Thick&Thin'>Thick&Thin</option>
                                    <option value='SD'>SD</option>
                                    <option value='FD'>FD</option>
                                    <option value='CD'>CD</option>
                                    <option value='RE'>RE</option>
                                    <option value='DD'>DD</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chip của lot DTY/FDY tham chiếu</label>
                                <select name="" id="" class="form-select form-select-sm" wire:model.defer="tieuChuanKhachHangModel.chip" required>
                                    <option value="">***</option>
                                    <option value='Tainan-602'>Tainan-602</option>
                                    <option value='Tainan-308'>Tainan-308</option>
                                    <option value='Billion'>Billion</option>
                                    <option value='Chori-R007'>Chori-R007</option>
                                    <option value='Utsumi-UK31'>Utsumi-UK31</option>
                                    <option value='China UZ'>China UZ</option>
                                    <option value='China US'>China US</option>
                                    <option value='Malaysia-UJ'>Malaysia-UJ</option>
                                    <option value='Toray CD'>Toray CD</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Khách hàng chỉ định Chip</label>
                                <select name="" id="" class="form-select form-select-sm" wire:model.defer="tieuChuanKhachHangModel.khach_hang_chi_dinh_chip" required>
                                    <option value="">***</option>
                                    <option value='Tainan-602'>Tainan-602</option>
                                    <option value='Tainan-308'>Tainan-308</option>
                                    <option value='Billion'>Billion</option>
                                    <option value='Chori-R007'>Chori-R007</option>
                                    <option value='Utsumi-UK31'>Utsumi-UK31</option>
                                    <option value='China UZ'>China UZ</option>
                                    <option value='China US'>China US</option>
                                    <option value='Malaysia-UJ'>Malaysia-UJ</option>
                                    <option value='Toray CD'>Toray CD</option>
                                    <option value='Không chỉ định Chip'>Không chỉ định Chip</option>
                                    <option value='Chỉ định chip trắng'>Chỉ định chip trắng</option>
                                    <option value='Chỉ định chip ăn màu đậm'>Chỉ định chip ăn màu đậm</option>                                    
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Lot tham chiếu TKSX</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập lot tham chiếu TKSX" wire:model.defer="tieuChuanKhachHangModel.lot" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Twist</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Twist" wire:model.defer="tieuChuanKhachHangModel.twist" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Denier</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Denier" wire:model.defer="tieuChuanKhachHangModel.denier" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Tenacity (g/d)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Tenacity (g/d)" wire:model.defer="tieuChuanKhachHangModel.tenacity" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Elongation (%)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Elongation (%)" wire:model.defer="tieuChuanKhachHangModel.elongation" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">DTY-BWS (%)/FDY-Oil pick %</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập DTY-BWS (%)/FDY-Oil pick %" wire:model.defer="tieuChuanKhachHangModel.dty_bws" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">DTY-CR (%)/FDY-U%</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập DTY-CR (%)/FDY-U%" wire:model.defer="tieuChuanKhachHangModel.dty_cr" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">DTY-CC(%)/FDY-BWS (%)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập DTY-CC(%)/FDY-BWS (%)" wire:model.defer="tieuChuanKhachHangModel.dty_cc" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">DTY-Oil pick %/FDY-Knots/m</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập DTY-Oil pick %/FDY-Knots/m" wire:model.defer="tieuChuanKhachHangModel.dty_oil_pick" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">DTY-Knots/m/FDY-Ti02</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập DTY-Knots/m/FDY-Ti02" wire:model.defer="tieuChuanKhachHangModel.dty_knots" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Stability(%)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Stability(%)" wire:model.defer="tieuChuanKhachHangModel.stability" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Ti02/Masterbatch</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Ti02/Masterbatch" wire:model.defer="tieuChuanKhachHangModel.ti02" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Times (torque/ meter) (s)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Times (torque/ meter) (s)" wire:model.defer="tieuChuanKhachHangModel.times" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Torque/ meter</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Torque/ meter" wire:model.defer="tieuChuanKhachHangModel.torque" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Yêu cầu tem, đóng gói</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập yêu cầu tem, đóng gói" wire:model.defer="tieuChuanKhachHangModel.yeu_cau_tem">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Thông tin khác</label>
                                <textarea name="" id="" cols="30" rows="5" class="form-control form-control-sm" placeholder="Nhập thông tin khác" wire:model.defer="tieuChuanKhachHangModel.thong_tin_khac"></textarea>
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