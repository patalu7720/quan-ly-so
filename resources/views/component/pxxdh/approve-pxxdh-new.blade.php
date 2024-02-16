<style>
    label{
        font-weight:600;
    }
    input[type='checkbox'][readonly]{
    pointer-events: none;}
    input[type='radio'][readonly]{
    pointer-events: none;}
</style>
@php
    use Carbon\Carbon;
@endphp
<form wire:submit.prevent="approvePhieuXXDHNew">
    <div wire:ignore.self class="modal" id="approvePhieuXXDHModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Duyệt Phiếu XXĐH</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="shadow p-3 bg-body-tertiary rounded">
                            <div class="row">
                                <div class="col">
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="dht" wire:model.defer="loaiDonHang" readonly>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Đơn hàng thường
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="dhm" wire:model.defer="loaiDonHang" readonly>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Đơn hàng mẫu
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <div class="shadow p-3 bg-body-tertiary rounded">
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="donHangGRS" wire:model.defer="donHangGRS" readonly>
                                        @if ($checkPhieuXXDHHasRollback != '' && $donHangGRS != $donHangGRSLog)
                                            <label class="form-check-label" for="donHangGRS" style="color:red">
                                                Đơn hàng GRS
                                            </label>
                                        @else
                                            <label class="form-check-label" for="donHangGRS">
                                                Đơn hàng GRS
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="donHangNonGRS" wire:model.defer="donHangNonGRS" readonly>
                                        @if ($checkPhieuXXDHHasRollback != '' && $donHangNonGRS != $donHangNonGRSLog)
                                            <label class="form-check-label" for="donHangNonGRS" style="color:red">
                                                Đơn hàng Non GRS
                                            </label>
                                        @else
                                            <label class="form-check-label" for="donHangNonGRS">
                                                Đơn hàng Non GRS
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="donHangSXMoi" wire:model.defer="donHangSXMoi" readonly>
                                        @if ($checkPhieuXXDHHasRollback != '' && $donHangSXMoi != $donHangSXMoiLog)
                                            <label class="form-check-label" for="donHangSXMoi" style="color:red">
                                                Đơn hàng SX mới 
                                            </label>
                                        @else
                                            <label class="form-check-label" for="donHangSXMoi">
                                                Đơn hàng SX mới 
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="donHangLapLai" wire:model.defer="donHangLapLai" readonly>
                                        @if ($checkPhieuXXDHHasRollback != '' && $donHangLapLai != $donHangLapLaiLog)
                                            <label class="form-check-label" for="donHangLapLai" style="color:red">
                                                Đơn hàng lặp lại 
                                            </label>
                                        @else
                                            <label class="form-check-label" for="donHangLapLai">
                                                Đơn hàng lặp lại 
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="donHangTonKho" wire:model.defer="donHangTonKho" readonly>
                                        @if ($checkPhieuXXDHHasRollback != '' && $donHangTonKho != $donHangTonKhoLog)
                                            <label class="form-check-label" for="donHangTonKho" style="color:red">
                                                Đơn hàng tồn kho
                                            </label>
                                        @else
                                            <label class="form-check-label" for="donHangTonKho">
                                                Đơn hàng tồn kho
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($checkPhieuXXDHHasRollback != '' && $date != $dateLog)
                                    <label for="date" class="col-sm-1 col-form-label" style="color:red">Date :</label>
                                @else
                                    <label for="date" class="col-sm-1 col-form-label">Date :</label>
                                @endif
                                @if ($date != '')
                                    <label class="col-sm-5 col-form-label">{{ Carbon::create($date)->isoFormat('DD-MM-YYYY') }}</label> 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="shadow p-3 bg-body-tertiary rounded">
                            <div class="row g-2">
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Tên công ty : </p>
                                    <p class="card-text d-inline" {{ $tenCongTy != $tenCongTyLog ? 'style="color:orangered"' : '' }}>{{ $tenCongTy }}</p>
                                </div>
                                <div class="col-6">
                                    @if ($checkPhieuXXDHHasRollback != '' && $soSO != $soSOLog)
                                        <p class="fw-semibold d-inline" style="color:red">Số SO : </p>
                                    @else
                                        <p class="fw-semibold d-inline">Số SO : </p>
                                    @endif
                                    <p class="card-text d-inline">{{ $soSO }}</p>
                                </div>
                                <div class="col-12">
                                    @if ($checkPhieuXXDHHasRollback != '' && $soHD != $soHDLog)
                                        <p class="fw-semibold d-inline" style="color:red">Số HĐ : </p>
                                    @else
                                        <p class="fw-semibold d-inline">Số HĐ : </p>
                                    @endif
                                    <label class="form-label">Số HĐ</label>
                                    <p class="card-text d-inline">{{ $soHD }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if ($donHangSXMoi == 1)
                    @if ($status == 'New')
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-6">
                                                                        <label for="" class="form-label">Lịch dự kiến</label>
                                                                        <select name="" id="" class="form-select" wire:model.defer="lichDuKien" required>
                                                                            <option value="">----------------</option>
                                                                            <option value="1">Đã có lịch dự kiến</option>
                                                                            <option value="0">Chưa có lịch dự kiến</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label  class="form-label">Kiểu máy dệt</label>
                                                                    <select class="form-select" wire:model.defer="kieuMayDet.{{ $item->id }}" required>
                                                                        <option value="">***</option>
                                                                        {{-- <option value='Dệt nước_ngang'>Dệt nước_ngang</option>
                                                                        <option value='Dệt nước_dọc_Có hồ sợi'>Dệt nước_dọc_Có hồ sợi</option>
                                                                        <option value='Dệt nước_dọc_Không hồ sợi'>Dệt nước_dọc_Không hồ sợi</option>
                                                                        <option value='Chập spandex'>Chập spandex</option>
                                                                        <option value='Dệt kim tròn'>Dệt kim tròn</option>
                                                                        <option value='Dệt kim bằng'>Dệt kim bằng</option>
                                                                        <option value='Dệt kim bằng (Jacquard)'>Dệt kim bằng (Jacquard)</option>
                                                                        <option value='Dệt khí_ngang'>Dệt khí_ngang</option>
                                                                        <option value='Dệt khí_dọc'>Dệt khí_dọc</option>
                                                                        <option value='Dệt bao tay'>Dệt bao tay</option>
                                                                        <option value='Dệt dây'>Dệt dây</option>
                                                                        <option value='Dệt nhãn'>Dệt nhãn</option>
                                                                        <option value='Dệt thoi'>Dệt thoi</option>
                                                                        <option value='Dệt thoi sợi ngang'>Dệt thoi sợi ngang</option>
                                                                        <option value='Dệt thoi sợi dọc- có hồ'>Dệt thoi sợi dọc- có hồ</option>
                                                                        <option value='Dệt thoi sợi dọc - không hồ'>Dệt thoi sợi dọc - không hồ</option>
                                                                        <option value='Se chỉ'>Se chỉ</option>
                                                                        <option value='Làm bùi nhùi rửa chén'>Làm bùi nhùi rửa chén</option> --}}
                                                                        @if ($danhSachLoaiMayDet != null)
                                                                            @foreach ($danhSachLoaiMayDet as $itemLoaiMayDet)
                                                                                <option value='{{ $itemLoaiMayDet->loai_may_det }}'>{{ $itemLoaiMayDet->loai_may_det }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot</label>
                                                                    <input type="text" class="form-control" placeholder="Nhập lot" wire:model.defer="lot.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone</label>
                                                                    <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone</label>
                                                                    <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                                                    <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy</label>
                                                                    <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                                                    <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                                                    <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói</label>
                                                                    <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet</label>
                                                                    <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle</label>
                                                                    <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                                <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng</label>
                                <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'Sale APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        @if (strlen($soSO) != 12)
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="form-label" >QA kiến nghị</label>
                                    <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" required></textarea>
                                </div>
                            </div>
                        @endif
                    @elseif ($status == 'SM APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        {{-- <div class="table-responsive">
                                            <table class="table" style="width:1200px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:30px">#</th>
                                                        <th scope="col" style="width:250px">Quy cách</th>
                                                        <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                        <th scope="col">Kiểu máy dệt, điều kiện đặc biệt của KH</th>
                                                        <th scope="col" style="width:170px">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDH!=null)
                                                        @foreach ($quyCachPhieuXXDH as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->kieu_may_det }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'QA REQUESTED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        {{-- <div class="table-responsive">
                                            <table class="table" style="width:1200px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:30px">#</th>
                                                        <th scope="col" style="width:250px">Quy cách</th>
                                                        <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                        <th scope="col">Kiểu máy dệt, điều kiện đặc biệt của KH</th>
                                                        <th scope="col" style="width:170px">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDH!=null)
                                                        @foreach ($quyCachPhieuXXDH as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->kieu_may_det }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <button class="btn btn-primary btn-sm" wire:click.prevent="addKHST({{ $i_khst }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
                                            </div>
                                        </div>
                                        <div class="row mb-2 g-2">
                                            <div class="col-5">
                                                <label class="form-label">Quy cách</label>
                                                @if ($loaiDonHang == 'dht')
                                                    <input type="text" class="form-control" placeholder="Quy cách" wire:model.defer="quyCachSuDungKHST.0">
                                                @else
                                                    <input type="text" class="form-control" placeholder="Quy cách"  required wire:model.defer="quyCachSuDungKHST.0">
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Số lượng (kg)</label>
                                                @if ($loaiDonHang == 'dht')
                                                    <input type="text" class="form-control" placeholder="Số lượng" wire:model.defer="soLuongKHST.0">
                                                @else
                                                    <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuongKHST.0">
                                                @endif                                                
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Line</label>
                                                @if ($loaiDonHang == 'dht')
                                                    <input type="text" class="form-control" placeholder="Line" wire:model.defer="lotKHST.0">
                                                @else
                                                    <input type="text" class="form-control" placeholder="Line" required wire:model.defer="lotKHST.0">
                                                @endif
                                            </div>
                                        </div>
                                        @foreach($inputs_khst as $key => $value)
                                            <hr>
                                            <div class="row mb-2 g-2">
                                                <div class="col-5">
                                                    <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachSuDungKHST.{{ $value }}">
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuongKHST.{{ $value }}">
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" class="form-control" placeholder="Line" required wire:model.defer="lotKHST.{{ $value }}">
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-danger btn-sm"  style="margin-top: 3px" wire:click.prevent="removeKHST({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <label for="">Phân bổ</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_cc" wire:model.defer="cbCC">
                                        <label class="form-check-label" for="cb_cc">CC</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb2" wire:model.defer="cbTB2">
                                        <label class="form-check-label" for="cb_tb2">TB2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb3" wire:model.defer="cbTB3">
                                        <label class="form-check-label" for="cb_tb3">TB3</label>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label" >Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'KHST APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="width:30px">#</th>
                                                    <th scope="col">Quy cách</th>
                                                    <th scope="col">Số lượng (kg)</th>
                                                    <th scope="col">Line</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDHKHST != null)
                                                        @foreach ($quyCachPhieuXXDHKHST as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                            </div>
                        </div>
                        @if (strlen($soSO) == 12)
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Nhập SO</label>
                                    <input type="text" class="form-control" wire:model="soChinhThuc">
                                </div>
                            </div>
                        @else
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="form-label" >Phản hồi của QA</label>
                                    <textarea class="form-control" cols="30" rows="5" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA"></textarea>
                                </div>
                            </div>
                        @endif
                    @elseif ($status == 'ADMIN APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        {{-- <div class="table-responsive">
                                            <table class="table" style="width:1200px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:30px">#</th>
                                                        <th scope="col" style="width:250px">Quy cách</th>
                                                        <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                        <th scope="col">Kiểu máy dệt, điều kiện đặc biệt của KH</th>
                                                        <th scope="col" style="width:170px">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDH!=null)
                                                        @foreach ($quyCachPhieuXXDH as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->kieu_may_det }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="width:30px">#</th>
                                                    <th scope="col">Quy cách</th>
                                                    <th scope="col">Số lượng (kg)</th>
                                                    <th scope="col">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDHKHST != null)
                                                        @foreach ($quyCachPhieuXXDHKHST as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @include('component.pxxdh.detail-pxxdh-approve') --}}
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiQA" class="form-label" >Phản hồi của QA</label>
                                <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'QA APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        {{-- <div class="table-responsive">
                                            <table class="table" style="width:1200px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:30px">#</th>
                                                        <th scope="col" style="width:250px">Quy cách</th>
                                                        <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                        <th scope="col">Kiểu máy dệt, điều kiện đặc biệt của KH</th>
                                                        <th scope="col" style="width:170px">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDH!=null)
                                                        @foreach ($quyCachPhieuXXDH as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->kieu_may_det }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="width:30px">#</th>
                                                    <th scope="col">Quy cách</th>
                                                    <th scope="col">Số lượng (kg)</th>
                                                    <th scope="col">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDHKHST != null)
                                                        @foreach ($quyCachPhieuXXDHKHST as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @include('component.pxxdh.detail-pxxdh-approve') --}}
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiQA" class="form-label">Phản hồi của QA</label>
                                <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" readonly></textarea>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row mb-2">
                                        <div class="col-8">
                                            <label for="soCone" class="form-label">Số cone</label>
                                            <input type="text" class="form-control" id="soCone" placeholder="Số cone" required wire:model.defer="soCone" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label for="soKgCone" class="form-label">Số kg/cone</label>
                                            <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" required wire:model.defer="soKgCone" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">QA kiến nghị</label>
                                            <input type="text" class="form-control" id="soKgCone" required wire:model.defer="QA kiến nghị" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                            <input type="text" class="form-control" id="Line" placeholder="Line" required wire:model.defer="Line" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="May" class="form-label">Máy</label>
                                            <input type="text" class="form-control" id="May" placeholder="Máy" required wire:model.defer="May" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="ngayGiaoHang" required wire:model.defer="ngayGiaoHang" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                            <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                                            <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" required wire:model.defer="thanhPhamCuaKhachHang" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                                            <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Thông tin đóng gói</label>
                                            <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label" >QA kiến nghị</label>
                                            <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                            <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanHoiQA" class="form-label">Phản hồi của QA</label>
                                            <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    @endif
                @else
                    @if ($status == 'New')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-6">
                                                                        <label for="" class="form-label">Lịch dự kiến</label>
                                                                        <select name="" id="" class="form-select" wire:model.defer="lichDuKien" required>
                                                                            <option value="">----------------</option>
                                                                            <option value="1">Đã có lịch dự kiến</option>
                                                                            <option value="0">Chưa có lịch dự kiến</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="exampleDataList" class="form-label">Kiểu máy dệt</label>
                                                                    <select class="form-select" wire:model.defer="kieuMayDet.{{ $item->id }}" required>
                                                                        <option value="">***</option>
                                                                        @if ($danhSachLoaiMayDet != null)
                                                                            @foreach ($danhSachLoaiMayDet as $itemLoaiMayDet)
                                                                                <option value='{{ $itemLoaiMayDet->loai_may_det }}'>{{ $itemLoaiMayDet->loai_may_det }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                        {{-- <option value='Dệt nước_ngang'>Dệt nước_ngang</option>
                                                                        <option value='Dệt nước_dọc_Có hồ sợi'>Dệt nước_dọc_Có hồ sợi</option>
                                                                        <option value='Dệt nước_dọc_Không hồ sợi'>Dệt nước_dọc_Không hồ sợi</option>
                                                                        <option value='Chập spandex'>Chập spandex</option>
                                                                        <option value='Dệt kim tròn'>Dệt kim tròn</option>
                                                                        <option value='Dệt kim bằng'>Dệt kim bằng</option>
                                                                        <option value='Dệt kim bằng (Jacquard)'>Dệt kim bằng (Jacquard)</option>
                                                                        <option value='Dệt khí_ngang'>Dệt khí_ngang</option>
                                                                        <option value='Dệt khí_dọc'>Dệt khí_dọc</option>
                                                                        <option value='Dệt bao tay'>Dệt bao tay</option>
                                                                        <option value='Dệt dây'>Dệt dây</option>
                                                                        <option value='Dệt nhãn'>Dệt nhãn</option>
                                                                        <option value='Dệt thoi'>Dệt thoi</option>
                                                                        <option value='Dệt thoi sợi ngang'>Dệt thoi sợi ngang</option>
                                                                        <option value='Dệt thoi sợi dọc- có hồ'>Dệt thoi sợi dọc- có hồ</option>
                                                                        <option value='Dệt thoi sợi dọc - không hồ'>Dệt thoi sợi dọc - không hồ</option>
                                                                        <option value='Se chỉ'>Se chỉ</option>
                                                                        <option value='Làm bùi nhùi rửa chén'>Làm bùi nhùi rửa chén</option> --}}
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot</label>
                                                                    <input type="text" class="form-control" placeholder="Nhập lot" wire:model.defer="lot.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone</label>
                                                                    <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone</label>
                                                                    <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                                                    <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy</label>
                                                                    <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                                                    <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                                                    <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- @foreach ($quyCachPhieuXXDH as $item)
                                            <tr>
                                                <th class="counterCell"></td>
                                                <td><label style="font-weight: 500">{{ $item->quy_cach }}</label></td>
                                                <td><label style="font-weight: 500">{{ $item->so_luong }}</label></td>
                                                <td><input type="text" class="form-control form-control-sm" wire:model.defer="kieuMayDet.{{ $item->id }}" required></td>
                                                <td><input type="text" class="form-control form-control-sm" wire:model.defer="lot.{{ $item->id }}" required></td>
                                            </tr>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                                <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng</label>
                                <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'Sale APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        {{-- <div class="table-responsive">
                                            <table class="table" style="width:1200px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:30px">#</th>
                                                        <th scope="col" style="width:250px">Quy cách</th>
                                                        <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                        <th scope="col">Kiểu máy dệt, điều kiện đặc biệt của KH</th>
                                                        <th scope="col" style="width:170px">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDH!=null)
                                                        @foreach ($quyCachPhieuXXDH as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->kieu_may_det }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                    {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        {{-- <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row mb-2">
                                        <div class="col-8">
                                            <label for="soCone" class="form-label">Số cone</label>
                                            <input type="text" class="form-control" id="soCone" placeholder="Số cone" required wire:model.defer="soCone" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label for="soKgCone" class="form-label">Số kg/cone</label>
                                            <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" required wire:model.defer="soKgCone" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                            <input type="text" class="form-control" id="Line" placeholder="Line" required wire:model.defer="Line" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="May" class="form-label">Máy</label>
                                            <input type="text" class="form-control" id="May" placeholder="Máy" required wire:model.defer="May" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="ngayGiaoHang" required wire:model.defer="ngayGiaoHang" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                            <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                                            <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" required wire:model.defer="thanhPhamCuaKhachHang" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                                            <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Thông tin đóng gói</label>
                                            <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiQA" class="form-label" >Phản hồi của QA</label>
                                <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'QA APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <button class="btn btn-primary btn-sm" wire:click.prevent="addKHST({{ $i_khst }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
                                            </div>
                                        </div>
                                        <div class="row mb-2 g-2">
                                            <div class="col-5">
                                                <label class="form-label">Quy cách</label>
                                                <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachSuDungKHST.0">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Số lượng (kg)</label>
                                                <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuongKHST.0">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Line</label>
                                                <input type="text" class="form-control" placeholder="Lot" required wire:model.defer="lotKHST.0">
                                            </div>
                                        </div>
                                        @foreach($inputs_khst as $key => $value)
                                            <hr>
                                            <div class="row mb-2 g-2">
                                                <div class="col-5">
                                                    <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachSuDungKHST.{{ $value }}">
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuongKHST.{{ $value }}">
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" class="form-control" placeholder="Lot" required wire:model.defer="lotKHST.{{ $value }}">
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-danger btn-sm"  style="margin-top: 3px" wire:click.prevent="removeKHST({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <label for="">Phân bổ</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_cc" wire:model.defer="cbCC">
                                        <label class="form-check-label" for="cb_cc">CC</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb2" wire:model.defer="cbTB2">
                                        <label class="form-check-label" for="cb_tb2">TB2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb3" wire:model.defer="cbTB3">
                                        <label class="form-check-label" for="cb_tb3">TB3</label>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label" >Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" required></textarea>
                            </div>
                        </div>
                    @elseif ($status == 'KHST APPROVED')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab0_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab0_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab0_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab0_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab0_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                    {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                    {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                    {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                    <datalist id="datalistThongTinDongGoi">
                                                                        @if ($listThongTinDongGoi != null)
                                                                            @foreach ($listThongTinDongGoi as $item1)
                                                                                <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                    <datalist id="datalistPallet">
                                                                        @if ($listPallet != null)
                                                                            @foreach ($listPallet as $item2)
                                                                                <option value="{{ $item2->pallet }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                    {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                    {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                    <datalist id="datalistRecycle">
                                                                        @if ($listRecycle != null)
                                                                            @foreach ($listRecycle as $item3)
                                                                                <option value="{{ $item3->recycle }}"></option>
                                                                            @endforeach
                                                                        @endif
                                                                    </datalist> --}}
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $thanhPhamCuaKhachHang }}</label>
                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $phanAnhCuaKhachHang }}</label>
                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="width:30px">#</th>
                                                    <th scope="col">Quy cách</th>
                                                    <th scope="col">Số lượng (kg)</th>
                                                    <th scope="col">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDHKHST != null)
                                                        @foreach ($quyCachPhieuXXDHKHST as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @include('component.pxxdh.detail-pxxdh-approve') --}}
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" >QA kiến nghị</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="phanHoiQA" class="form-label">Phản hồi của QA</label>
                                <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" readonly></textarea>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row mb-2">
                                        <div class="col-8">
                                            <label for="soCone" class="form-label">Số cone</label>
                                            <input type="text" class="form-control" id="soCone" placeholder="Số cone" required wire:model.defer="soCone" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label for="soKgCone" class="form-label">Số kg/cone</label>
                                            <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" required wire:model.defer="soKgCone" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">QA kiến nghị</label>
                                            <input type="text" class="form-control" id="soKgCone" required wire:model.defer="QA kiến nghị" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                            <input type="text" class="form-control" id="Line" placeholder="Line" required wire:model.defer="Line" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="May" class="form-label">Máy</label>
                                            <input type="text" class="form-control" id="May" placeholder="Máy" required wire:model.defer="May" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="ngayGiaoHang" required wire:model.defer="ngayGiaoHang" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                            <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                                            <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" required wire:model.defer="thanhPhamCuaKhachHang" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                                            <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Thông tin đóng gói</label>
                                            <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label" >QA kiến nghị</label>
                                            <textarea class="form-control" cols="30" rows="5" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanHoiKHST" class="form-label">Phản hồi của KHST</label>
                                            <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="phanHoiQA" class="form-label">Phản hồi của QA</label>
                                            <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
                <button type="submit" class="btn btn-primary">Duyệt</button>
            </div>
          </div>
        </div>
    </div>
</form>