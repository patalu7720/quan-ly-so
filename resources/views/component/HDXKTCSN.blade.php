<!-- Modal HĐNĐSN -->
<form wire:submit.prevent="{{$this->formSubmit}}">
    <div>
        <div wire:ignore.self class="modal fade" data-bs-backdrop="static"  id="ModalXKTCSNTV" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-sharp fa-solid fa-folder-plus" style="color:forestgreen"></i>{{ $this->formSubmit ==  'storeHopDongXuatKhauTaiChoSongNgu' ? '    Tạo HĐ - XK Tại Chỗ Song Ngữ - Tiếng Việt' : '    Sửa HĐ - XK Tại Chỗ Song Ngữ - Tiếng Việt' }}</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
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
                                            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Nhập tên khách hàng" wire:model.defer = "benb" wire:change="{{ $this->formSubmit == 'updateHopDongXuatKhauTaiChoSongNgu' ? 'timthongtinbenbEdit()' : 'timthongtinbenb()' }}" required>
                                            <datalist id="datalistOptions">
                                                @foreach ($danhsachbenb as $item)
                                                    <option value="{{ $item->ten_tv }}"></option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" wire:model.defer = "makhachhangbenb">
                                            <label class="form-label">Địa chỉ</label>
                                            <textarea class="form-control" cols="30" rows="2" placeholder="Tiếng Việt" wire:model.defer="diachibenb" required></textarea>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <label for="inputMaSoThueKhachHang" class="form-label">Mã số thuế</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                  <input class="form-check-input mt-0" type="checkbox" aria-label="Checkbox for following text input" wire:model.defer="check_ma_so_thue_ben_b">
                                                </div>
                                                <input type="text" class="form-control" id="inputMaSoThueKhachHang" placeholder="Mã số thuế" wire:model.defer="masothuebenb">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="inputDienThoaiKhachHang" class="form-label">Điện thoại</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                  <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" wire:model.defer="check_sdt_ben_b">
                                                </div>
                                                <input type="text" class="form-control" id="inputDienThoaiKhachHang" placeholder="Số điện thoại" wire:model.defer="sdtbenb">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="inputFaxKhachHang" class="form-label">Fax</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                  <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" wire:model.defer="check_fax_ben_b">
                                                </div>
                                                <input type="text" class="form-control" id="inputFaxKhachHang" placeholder="Fax" wire:model.defer="faxbenb">
                                            </div> 
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
                                        <div class="col-12 col-lg-6">
                                            <label for="inputUyQuyenDaiDienBenB" class="form-label">Giấy ủy quyền</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                  <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" wire:model.defer='check_uyquyen_ben_b'>
                                                </div>
                                                <input type="text" class="form-control" id="inputUyQuyenDaiDienBenB" name="inputUyQuyenDaiDienBenB" placeholder="Số uỷ quyền" wire:model.defer='uyquyendaidienbenb'>
                                            </div>
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
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card text-bg-light mb-3">
                                <div class="card-header">Sản Phẩm</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="inputChatLuong" class="form-label">Tỉ giá</label>
                                                        <input type="number" class="form-control" placeholder="Tỉ giá" wire:model.defer="tygia" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="inputChatLuong" class="form-label">Chất lượng</label>
                                                        <textarea class="form-control" cols="30" rows="5" placeholder="Nhập chất lượng" wire:model.defer="chatluong" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-12">
                                                        <label class="form-label">Đóng gói</label>
                                                        <select class="form-select" wire:model="donggoi" required>
                                                            <option value="">--- Chọn đóng gói ---</option>
                                                            @foreach ($listdonggoi as $item)
                                                                <option value="{{ $item->donggoi }}">{{ $item->donggoi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <input type="{{ $donggoi == 'Khác' ? 'text' : 'hidden' }}" class="form-control"  placeholder="Đóng gói khác" wire:model.defer="donggoikhac" required>
                                                    </div>
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
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card text-bg-light mb-3">
                                <h5 class="card-header">Thông tin chi tiết</h5>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label for="inputThoiHanThanhToan" class="form-label">Thời hạn thanh toán</label>
                                            <input type="text" class="form-control" id="inputThoiHanThanhToan" name="inputThoiHanThanhToan" placeholder="Thời hạn thanh toán" wire:model.defer="thoigianthanhtoan" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPhuongThucThanhToan" class="form-label">Phương thức thanh toán</label>
                                            <textarea rows="5" class="form-control" id="inputPhuongThucThanhToan" name="inputPhuongThucThanhToan" placeholder="Phương thức thanh toán" wire:model.defer="phuongthucthanhtoan"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputDiaDiemGiaoHang" class="form-label">Địa điểm giao hàng</label>
                                            <input type="text" class="form-control" placeholder="Nơi giao hàng" wire:model.defer="diadiemgiaohang" required>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" placeholder="Địa chỉ nơi giao hàng" wire:model.defer="diachi_diadiemgiaohang">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputThoiGianGiaoHang" class="form-label">Thời gian giao hàng</label>
                                            <input type="date" class="form-control" id="inputThoiGianGiaoHang" name="inputThoiGianGiaoHang" placeholder="Thời gian giao hàng" wire:model.defer="thoigiangiaohang" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPhuongThucGiaoHang" class="form-label">Phương thức giao hàng</label>
                                            <select class="form-select" wire:model="phuongthucgiaohang" required>
                                                <option value="">--- Chọn phương thức giao hàng ---</option>
                                                @foreach ($listphuongthucgiaohang as $item)
                                                    <option value="{{ $item->phuongthucgiaohang }}">{{ $item->phuongthucgiaohang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <input type="{{ $phuongthucgiaohang == 'Khác' ? 'text' : 'hidden' }}" class="form-control"  placeholder="Phương thức giao hàng khác" wire:model.defer="phuongthucgiaohangkhac" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="selectGiaoHangTungPhan" class="form-label">Giao hàng từng phần (không bắt buộc)</label>
                                            <select name="selectGiaoHangTungPhan" id="selectGiaoHangTungPhan" class="form-select" wire:model.defer='giaohangtungphan'>
                                                <option value="">Chọn loại giao hàng</option>
                                                <option value="1">Cho phép</option>
                                                <option value="2">Không cho phép</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPhiVanChuyen" class="form-label">Phí Vận Chuyển</label>
                                            <input type="text" class="form-control" id="inputPhiVanChuyen" name="inputPhiVanChuyen" placeholder="Phí Vận Chuyển" wire:model.defer="phivanchuyen" required>
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
                  <button class="btn btn-primary" data-bs-target="#ModalXKTCSNTA" wire:click.prevent = "" data-bs-toggle="modal">Tiếp tục <i class="fa-sharp fa-solid fa-arrow-right"></i></button>
                </div>
              </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="ModalXKTCSNTA" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Tiếng Anh</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                            <div class="row g-2">
                                <div class="col-12">
                                    <h4>Bên B</h3>
                                    <hr width="50%">
                                </div>
                                <div class="col-12">
                                    <label for="exampleDataList" class="form-label">Khách hàng</label>
                                    <input type="text" class="form-control" placeholder="Tên khách hàng - Tiếng Anh" wire:model.defer = "benb_ta">
                                </div>
                                <div class="col-12">
                                    <input type="hidden" wire:model.defer = "makhachhangbenb">
                                    <label class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" cols="30" rows="2" placeholder="Địa chỉ - Tiếng Anh" wire:model.defer="diachibenb_ta" required></textarea>
                                </div>
                                {{-- <div class="col-12 col-lg-6">
                                    <label for="inputDaiDienBenB" class="form-label">Đại diện</label>
                                    <input type="text" class="form-control" placeholder="Đại diện - Tiếng Anh" wire:model.defer='daidienbenb_ta' required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="inputChucVuDaiDienBenB" class="form-label">Chức vụ</label>
                                    <input type="text" class="form-control" id="inputChucVuDaiDienBenB" name="inputChucVuDaiDienBenB" placeholder="Chức vụ - Tiếng Anh" wire:model.defer='chucvudaidienbenb_ta' required>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                            <div class="row g-2">
                                <div class="col-12">
                                    <h4>Thông tin chi tiết</h3>
                                    <hr width="50%">
                                </div>
                                <div class="col-12">
                                    <label for="inputThoiHanThanhToan" class="form-label">Chất lượng</label>
                                    <div class="col">
                                        <textarea class="form-control" cols="30" rows="5" placeholder="Nhập chất lượng" wire:model.defer="chatluong_ta" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Đóng gói</label>
                                    <select class="form-select" wire:model="donggoi_ta" required>
                                        <option value="">--- Chọn đóng gói ---</option>
                                        @foreach ($listdonggoi as $item)
                                            <option value="{{ $item->donggoi_ta }}">{{ $item->donggoi_ta }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="{{ $donggoi_ta == 'Other' ? 'text' : 'hidden' }}" class="form-control"  placeholder="Đóng gói khác" wire:model.defer="donggoikhac_ta" required>
                                </div>
                                <div class="col-12">
                                    <label for="inputThoiHanThanhToan" class="form-label">Thời hạn thanh toán</label>
                                    <input type="text" class="form-control" placeholder="Thời hạn thanh toán - Tiếng Anh" wire:model.defer="thoigianthanhtoan_ta" required>
                                </div>
                                <div class="col-12">
                                    <label for="inputPhuongThucThanhToan" class="form-label">Phương thức thanh toán</label>
                                    <textarea rows="5" class="form-control" placeholder="Phương thức thanh toán - Tiếng Anh" wire:model.defer="phuongthucthanhtoan_ta"></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="inputDiaDiemGiaoHang" class="form-label">Địa điểm giao hàng</label>
                                    <input type="text" class="form-control" placeholder="Nơi giao hàng - Tiếng Anh" wire:model.defer="diadiemgiaohang_ta" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="Địa chỉ nơi giao hàng - Tiếng Anh" wire:model.defer="diachi_diadiemgiaohang_ta">
                                </div>
                                <div class="col-12">
                                    <label for="inputPhuongThucGiaoHang" class="form-label">Phương thức giao hàng</label>
                                    <select class="form-select" wire:model="phuongthucgiaohang_ta" required>
                                        <option value="">--- Chọn phương thức giao hàng ---</option>
                                        @foreach ($listphuongthucgiaohang as $item)
                                            <option value="{{ $item->phuongthucgiaohang_ta }}">{{ $item->phuongthucgiaohang_ta }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <input type="{{ $phuongthucgiaohang_ta == 'Other' ? 'text' : 'hidden' }}" class="form-control"  placeholder="Phương thức giao hàng khác" wire:model.defer="phuongthucgiaohangkhac_ta" required>
                                </div>
                                <div class="col-12">
                                    <label for="inputPhiVanChuyen" class="form-label">Phí Vận Chuyển</label>
                                    <input type="text" class="form-control" id="inputPhiVanChuyen" name="inputPhiVanChuyen" placeholder="Phí Vận Chuyển - Tiếng Anh" wire:model.defer="phivanchuyen_ta" required>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-target="#ModalXKTCSNTV" wire:click.prevent = "" data-bs-toggle="modal">Quay lại <i class="fa-solid fa-arrow-left-long"></i></button>
                  <button class="btn btn-primary" type="submit">Thực hiện <i class="fa-regular fa-circle-check"></i></button>
                </div>
              </div>
            </div>
        </div>
    </div>
</form>