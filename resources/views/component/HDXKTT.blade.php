<!-- Modal HĐXKTCTA -->
<form wire:submit.prevent="{{$this->formSubmit}}">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static"  id="ModalXKTT" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-sharp fa-solid fa-folder-plus" style="color:forestgreen"></i>{{ $this->formSubmit ==  'storeHopDongXuatKhauTrucTiep' ? '    Tạo HĐ - Xuất khẩu trực tiếp' : '    Sửa HĐ - Xuất khẩu trực tiếp' }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Bên A</h5>
                            <div class="card-body">
                                {{-- <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="soTDGRadio" wire:model.defer="soTDGsoTTDH">
                                            <label class="form-check-label" for="inlineRadio1">TDG</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="soTTDHRadio" wire:model.defer="soTDGsoTTDH">
                                            <label class="form-check-label" for="inlineRadio2">TTĐH</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label">Số TDG/TTĐH</label>
                                        <input type="text" class="form-control" placeholder="Nhập số TDG" wire:model.defer="soTDG">
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="inputNgayLapHopDong" class="form-label">Ngày lập HĐ</label>
                                        <input type="date" class="form-control mb-3" id="inputNgayLapHopDong" name="inputNgayLapHopDong" placeholder="Thời gian giao hàng" wire:model.defer="ngaylaphd" required>                    
                                    </div>
                                    <div class="col-12">
                                        <label for="selectBenA" class="form-label">Công ty - chi nhánh</label>
                                        <select id="selectBenA" name="selectBenA" class="form-select" aria-label="Default select example" wire:model="bena">
                                            <option value="">{{ __('Chọn bên A') }}</option>
                                            @foreach ($danhsachbena as $item)
                                                <option value="{{ $item->id }}">{{ $item->ten_tv }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="selectDaiDienBenA" class="form-label">Đại diện</label>
                                        <select id="selectDaiDienBenA" name="selectDaiDienBenA" class="form-select" aria-label="Default select example" wire:model.defer='daidienbena' required>
                                            <option value=""></option>
                                            @foreach ($danhsachdaidienbena as $item)
                                                <option value="{{ $item->id }}">{{ $item->dai_dien_tv }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Bên B</h5>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="exampleDataList" class="form-label">Khách hàng</label>
                                        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Nhập tên khách hàng" wire:model.defer = "benb" wire:change="{{ $this->formSubmit == 'updateHopDongXuatKhauTrucTiep' ? 'timthongtinbenbEdit()' : 'timthongtinbenb()' }}" required>
                                        <datalist id="datalistOptions">
                                            @foreach ($danhsachbenb as $item)
                                                <option value="{{ $item->ten_tv }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Tên khách hàng tiếng anh" wire:model.defer="benb_ta" required>
                                    </div>
                                    <div class="col-12">
                                        <input type="hidden" wire:model.defer = "makhachhangbenb">
                                        <label class="form-label">Địa chỉ</label>
                                        <textarea class="form-control" cols="30" rows="2" placeholder="Địa chỉ" wire:model.defer="diachibenb_ta" required></textarea>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="inputDienThoaiKhachHang" class="form-label">Điện thoại</label>
                                        <input type="text" class="form-control" id="inputDienThoaiKhachHang" placeholder="Số điện thoại" wire:model.defer="sdtbenb">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="inputFaxKhachHang" class="form-label">Fax</label>
                                        <input type="text" class="form-control" id="inputFaxKhachHang" placeholder="Fax" wire:model.defer="faxbenb">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="inputDaiDienBenB" class="form-label">Đại Diện</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" wire:model.defer="check_dai_dien_ben_b">
                                            </div>
                                            <input type="text" class="form-control" placeholder="Đại diện khách hàng" wire:model.defer='daidienbenb'>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="inputChucVuDaiDienBenB" class="form-label">Chức vụ</label>
                                        <input type="text" class="form-control" id="inputChucVuDaiDienBenB" name="inputChucVuDaiDienBenB" placeholder="Chức vụ" wire:model.defer='chucvudaidienbenb'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="cbBenNhan" wire:model="cbBenNhan">
                            <label class="form-check-label" for="cbBenNhan">
                                Bên nhận
                            </label>
                        </div>
                        <div class="card text-bg-light mb-3" {{ $cbBenNhan == '1' ? '' : 'hidden' }}>
                            <h5 class="card-header">Bên Nhận</h5>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="" class="form-label">Tên TA</label>
                                        <input type="text" placeholder="Nhập tên bên nhận TA" class="form-control" opla wire:model.defer="benNhanTA">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Tên TV</label>
                                        <input type="text" placeholder="Nhập tên bên nhận TV" class="form-control" opla wire:model.defer="benNhanTV">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Địa chỉ</label>
                                        <input type="text" placeholder="Nhập địa chỉ bên nhận" class="form-control" wire:model.defer="diaChiBenNhan">
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <label class="form-label">Điện thoại</label>
                                        <input type="text" class="form-control" id="inputDienThoaiKhachHang" placeholder="Số điện thoại" wire:model.defer="sdtBenNhan">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">Đại Diện</label>
                                        <input type="text" class="form-control" placeholder="Đại diện" wire:model.defer='daiDienBenNhan'>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">Chức vụ</label>
                                        <input type="text" class="form-control" placeholder="Chức vụ" wire:model.defer='chucVuDaiDienBenNhan'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-bg-light mb-3" {{ $this->benb == 'LEAR CORPORATION' ? '' : 'hidden' }}>
                            <h5 class="card-header">Plant</h5>
                            <div class="card-body">
                                <button class="btn btn-primary btn-sm mb-3" wire:click.prevent="add({{ $i }})"><i class="fa-solid fa-plus fa-xl"></i>Thêm</button>
                                @foreach($inputs as $key => $value)
                                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">WK</label>
                                                <input type="text" class="form-control" placeholder="WK" wire:model.defer='wk.{{ $value }}'>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">Container</label>
                                                <input type="text" class="form-control" placeholder="Container" wire:model.defer='container.{{ $value }}'>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" class="form-control" placeholder="Quantity" wire:model.defer='quantity.{{ $value }}'>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">Unit price (USD/KG)</label>
                                                <input type="text" class="form-control" placeholder="Unit price" wire:model.defer='unitPrice.{{ $value }}'>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">Amount</label>
                                                <input type="text" class="form-control" placeholder="Amount" wire:model.defer='amount.{{ $value }}'>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <button class="btn btn-outline-danger btn-sm" style="margin-top: 30px" wire:click.prevent="remove({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Sản Phẩm</h5>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Chất lượng</label>
                                            <textarea class="form-control" cols="30" rows="5" wire:model.defer="chatluong_ta" placeholder="Nhập chất lượng"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <input type="{{ $chatluong_ta == 'Khác' ? 'text' : 'hidden' }}" class="form-control" placeholder="Chất lượng khác" wire:model.defer="chatluongkhac_ta" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Đóng gói</label>
                                            <select class="form-select" wire:model="donggoi_ta" required>
                                                <option value="">--- Chọn đóng gói ---</option>
                                                @foreach ($listdonggoi as $item)
                                                    <option value="{{ $item->donggoi_ta }}">{{ $item->donggoi_ta }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <input type="{{ $donggoi_ta == 'Khác' ? 'text' : 'hidden' }}" class="form-control"  placeholder="Đóng gói khác" wire:model.defer="donggoikhac_ta" required>
                                        </div>
                                    </div>
                                    @for ($i = 1; $i < 16; $i++)
                                        <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <label for="inputQuyCach{{ $i }}" class="form-label">Quy cách</label>
                                                    <textarea class="form-control" rows="3" id="inputQuyCach{{ $i }}" name="inputQuyCach{{ $i }}" placeholder="Quy cách" wire:model.defer="quycach{{ $i }}" @if($i == 1){{ 'required' }}@endif></textarea>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="inputSoLuong{{ $i }}" class="form-label">Số Lượng</label>
                                                    <input type="number" step=any class="form-control" id="inputSoLuong{{ $i }}" name="inputSoLuong{{ $i }}" placeholder="Số Lượng" wire:model.defer="soluong{{ $i }}"  @if($i == 1){{ 'required' }}@endif>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="inputDonGia{{ $i }}" class="form-label">Đơn giá</label>
                                                    <input type="number" step=any class="form-control" id="inputDonGia{{ $i }}" name="inputDonGia{{ $i }}" placeholder="Đơn giá" wire:model.defer="dongia{{ $i }}"  @if($i == 1){{ 'required' }}@endif>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Thông tin chi tiết</h5>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label">PO</label>
                                        <input type="text" class="form-control" placeholder="PO" wire:model.defer='po'>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Incoterm</label>
                                        <input type="text" class="form-control" placeholder="CPT" wire:model.defer='cpt' required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputDiaDiemGiaoHang" class="form-label">Trung chuyển</label>
                                        <input type="text" class="form-control" placeholder="Trung chuyển" wire:model.defer="trungchuyen">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputDiaDiemGiaoHang" class="form-label">Loading Port</label>
                                        <input type="text" class="form-control" placeholder="Cảng bốc hàng" wire:model.defer="loadingport">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputDiaDiemGiaoHang" class="form-label">Discharging Port</label>
                                        <input type="text" class="form-control" placeholder="Discharging Port" wire:model.defer="dischargport">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputThoiGianGiaoHang" class="form-label">Thời gian giao hàng</label>
                                        <input type="date" class="form-control" id="inputThoiGianGiaoHang" name="inputThoiGianGiaoHang" placeholder="Thời gian giao hàng" wire:model.defer="thoigiangiaohang" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phương thức thanh toán</label>
                                        <textarea class="form-control" cols="30" rows="5" placeholder="Phương thức thanh toán" wire:model.defer="phuongthucthanhtoan_ta" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="selectGiaoHangTungPhan" class="form-label">Giao hàng từng phần (không bắt buộc)</label>
                                        <select name="selectGiaoHangTungPhan" id="selectGiaoHangTungPhan" class="form-select" wire:model.defer='giaohangtungphan'>
                                            <option value="">Chọn loại giao hàng</option>
                                            <option value="1">Cho phép</option>
                                            <option value="2">Không cho phép</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="selectSoBanInBenA" class="form-label">S.lượng bản in</label>
                                        <select class="form-select" wire:model.defer='soluongbanin' required>
                                            <option value="">Chọn s.lượng bản in</option>
                                            <option value="2">2</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng <i class="fa-sharp fa-regular fa-circle-xmark"></i></button>
              <button class="btn btn-primary" id="btn1" type="submit">Thực hiện <i class="fa-regular fa-circle-check"></i></button>
            </div>
          </div>
        </div>
    </div>
</form>