<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="updatePhieuXXDH">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="editPhieuXXDHModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Sửa phiếu xem xét đơn hàng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    @if ($status == 'New')
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
                                                <input class="form-check-input" type="checkbox" id="donHangGRS" wire:model.defer="donHangGRS">
                                                <label class="form-check-label" for="donHangGRS">
                                                    Đơn hàng GRS
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangNonGRS" wire:model.defer="donHangNonGRS">
                                                <label class="form-check-label" for="donHangNonGRS">
                                                    Đơn hàng Non GRS
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangSXMoi" wire:model.defer="donHangSXMoi">
                                                <label class="form-check-label" for="donHangSXMoi">
                                                    Đơn hàng SX mới 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangLapLai" wire:model.defer="donHangLapLai">
                                                <label class="form-check-label" for="donHangLapLai">
                                                    Đơn hàng lặp lại 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangTonKho" wire:model.defer="donHangTonKho">
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
                        <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row mb-2">
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
                        <div class="row">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="card text-bg-light">
                                                <h5 class="card-header">Quy cách</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                <th scope="col" style="width:30px">#</th>
                                                                <th scope="col" style="width:250px">Quy cách</th>
                                                                <th scope="col" style="width:150px">Số lượng (kg)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($quyCachPhieuXXDH != null)
                                                                    @foreach ($quyCachPhieuXXDH as $item)
                                                                        <tr>
                                                                            <th class="counterCell"></td>
                                                                            <td><input type="text" class="form-control form-control-sm" wire:model.defer="quyCachSuDungEdit.{{ $item->id }}" required></td>
                                                                            <td><input type="text" class="form-control form-control-sm" wire:model.defer="soLuongEdit.{{ $item->id }}" required></td>
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
                                    <div class="row mb-3">
                                        <div class="col">
                                            <button class="btn btn-primary btn-sm" wire:click.prevent="add({{ $i }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
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
                    @elseif ($status == 'Sale APPROVED')
                        <div class="row mb-2">
                            <div class="col">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab_{{ $item->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <p>Quy cách : {{ $item->quy_cach }}</p>
                                                        <p>Số lượng : {{ $item->so_luong }}</p>
                                                        <div>
                                                            @if ($donHangSXMoi == 1)
                                                                <div class="row mb-2">
                                                                    <div class="col-6">
                                                                        <label for="" class="form-label">Lịch dự kiến</label>
                                                                        <select name="" id="" class="form-select" wire:model.defer="lichDuKienEdit.{{ $item->id }}" required>
                                                                            <option value="">----------------</option>
                                                                            <option value="1">Đã có lịch dự kiến</option>
                                                                            <option value="0">Chưa có lịch dự kiến</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label class="form-label">Kiểu máy dệt</label>
                                                                    <select class="form-select" wire:model.defer="kieuMayDetEdit.{{ $item->id }}" required>
                                                                        <option value="">***</option>
                                                                        @if ($danhSachLoaiMayDet != null)
                                                                            @foreach ($danhSachLoaiMayDet as $itemLoaiMayDet)
                                                                                <option value='{{ $itemLoaiMayDet->loai_may_det }}'>{{ $itemLoaiMayDet->loai_may_det }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Lot</label>
                                                                    <input type="text" class="form-control" placeholder="Nhập lot" wire:model.defer="lotEdit.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="soCone" class="form-label">Số cone</label>
                                                                    <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soConeEdit.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="soKgCone" class="form-label">Số kg/cone</label>
                                                                    <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgConeEdit.{{ $item->id }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                                                                    <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="LineEdit.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="May" class="form-label">Máy</label>
                                                                    <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="MayEdit.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng</label>
                                                                    <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHangEdit.{{ $item->id }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)</label>
                                                                    <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiaoEdit.{{ $item->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col">
                                                                    <label class="form-label">Thông tin đóng gói</label>
                                                                    <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoiEdit.{{ $item->id }}">
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
                                                                    <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "palletEdit.{{ $item->id }}">
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
                                                                    <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycleEdit.{{ $item->id }}">
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
                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                                <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang" required></textarea>
                            </div>
                        </div>
                    @endif

                    @if ($donHangSXMoi == 1)
                        @if ($status == 'QA REQUESTED')
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="form-label" style="color:darkgreen">QA kiến nghị</label>
                                    <textarea class="form-control" cols="30" rows="3" placeholder="QA kiến nghị" wire:model.defer="qaKienNghi" required></textarea>
                                </div>
                            </div> 
                        @elseif ($status == 'KHST APPROVED')
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <label for="">Phân bổ</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_cc" wire:model.defer="cbCC" readonly>
                                            <label class="form-check-label" for="cb_cc">CC</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_tb2" wire:model.defer="cbTB2" readonly>
                                            <label class="form-check-label" for="cb_tb2">TB2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_tb3" wire:model.defer="cbTB3" readonly>
                                            <label class="form-check-label" for="cb_tb3">TB3</label>
                                        </div>
                                    </div> 
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
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="quyCachSuDungKHSTEdit.{{ $item->id }}" required></td>
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="soLuongKHSTEdit.{{ $item->id }}" required></td>
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="lotKHSTEdit.{{ $item->id }}" required></td>
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
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm" wire:click.prevent="addKHST({{ $i_khst }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
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
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="phanHoiKHST" class="form-label" style="color:darkgreen">Phản hồi của KHST</label>
                                    <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" required></textarea>
                                </div>
                            </div>
                        @elseif ($status == 'QA APPROVED')
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="phanHoiQA" class="form-label" style="color:darkgreen">Phản hồi của QA</label>
                                    <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" required></textarea>
                                </div>
                            </div>
                        @endif
                    @else
                        @if ($status == 'QA APPROVED')
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="phanHoiQA" class="form-label" style="color:darkgreen">Phản hồi của QA</label>
                                    <textarea class="form-control" id="phanHoiQA" cols="30" rows="3" placeholder="Phản hồi của QA" wire:model.defer="phanHoiQA" required></textarea>
                                </div>
                            </div>
                        @elseif ($status == 'KHST APPROVED')
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <label for="">Phân bổ</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_cc" wire:model.defer="cbCC" readonly>
                                            <label class="form-check-label" for="cb_cc">CC</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_tb2" wire:model.defer="cbTB2" readonly>
                                            <label class="form-check-label" for="cb_tb2">TB2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cb_tb3" wire:model.defer="cbTB3" readonly>
                                            <label class="form-check-label" for="cb_tb3">TB3</label>
                                        </div>
                                    </div> 
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
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="quyCachSuDungKHSTEdit.{{ $item->id }}" required></td>
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="soLuongKHSTEdit.{{ $item->id }}" required></td>
                                                                    <td><input type="text" class="form-control form-control-sm" wire:model.defer="lotKHSTEdit.{{ $item->id }}" required></td>
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
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm" wire:click.prevent="addKHST({{ $i_khst }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
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
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="phanHoiKHST" class="form-label" style="color:darkgreen">Phản hồi của KHST</label>
                                    <textarea class="form-control" id="phanHoiKHST" cols="30" rows="3" placeholder="Phản hồi của KHST" wire:model.defer="phanHoiKHST" required></textarea>
                                </div>
                            </div>
                        @endif
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