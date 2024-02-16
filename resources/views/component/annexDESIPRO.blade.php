<!-- Modal HĐXKTCTA -->
<form wire:submit.prevent="storeAnnexDESIPRO">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static"  id="ModalAnnexDESIPRO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-sharp fa-solid fa-folder-plus" style="color:forestgreen"></i>{{ ' Annex DESIPRO' }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Số Annex</label>
                        <input type="text" class="form-control" placeholder="Nhập số Annex" wire:model.defer="soAnnex">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Bên A</h5>
                            <div class="card-body">
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
                                        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Nhập tên khách hàng" wire:model.defer = "benb" wire:change="{{ $this->formSubmit == 'updateHopDongXuatKhauTaiChoTiengAnh' ? 'timthongtinbenbEdit()' : 'timthongtinbenb()' }}" required>
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
                                        <textarea class="form-control" cols="30" rows="2" placeholder="Tiếng Việt" wire:model.defer="diachibenb_ta" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-bg-light mb-3">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="" class="form-label">The Notify Party</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="The Notify Party" wire:model.defer="benNhan1">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Address" wire:model.defer="diaChiBenNhan1">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Represented by</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Represented by" wire:model.defer="daiDienBenNhan1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-bg-light mb-3">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="" class="form-label">On  Behalf OF  DESIPRO Pte. Ltd. receive good</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="On  Behalf OF  DESIPRO Pte. Ltd. receive good" wire:model.defer="benNhan2">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Address" wire:model.defer="diaChiBenNhan2">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Represented by</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Represented by" wire:model.defer="daiDienBenNhan2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Sản phẩm</h5>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Chất lượng</label>
                                        <textarea class="form-control" cols="30" rows="5" wire:model.defer="chatluong_ta" placeholder="Nhập chất lượng"></textarea>
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
                    <div class="col-12 col-lg-4">
                        <div class="card text-bg-light mb-3">
                            <h5 class="card-header">Thông tin chi tiết</h5>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label">Incoterm</label>
                                        <input type="text" class="form-control" placeholder="CPT" wire:model.defer='cpt' required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputPhuongThucThanhToan" class="form-label">Phương thức thanh toán</label>
                                        <textarea rows="5" class="form-control" id="inputPhuongThucThanhToan" name="inputPhuongThucThanhToan" placeholder="Phương thức thanh toán" wire:model.defer="phuongthucthanhtoan_ta"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputDiaDiemGiaoHang" class="form-label">Địa điểm giao hàng</label>
                                        <input type="text" class="form-control" id="inputDiaDiemGiaoHang" name="inputDiaDiemGiaoHang" placeholder="Nơi giao hàng" wire:model.defer="diadiemgiaohang_ta" required>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Địa chỉ nơi giao hàng" wire:model.defer="diachi_diadiemgiaohang_ta">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputThoiGianGiaoHang" class="form-label">Thời gian giao hàng</label>
                                        <input type="date" class="form-control" id="inputThoiGianGiaoHang" name="inputThoiGianGiaoHang" placeholder="Thời gian giao hàng" wire:model.defer="thoigiangiaohang" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="selectGiaoHangTungPhan" class="form-label">Giao hàng từng phần (không bắt buộc)</label>
                                        <select name="selectGiaoHangTungPhan" id="selectGiaoHangTungPhan" class="form-select" wire:model.defer='giaohangtungphan'>
                                            <option value="">Chọn loại giao hàng</option>
                                            <option value="1">Cho phép</option>
                                            <option value="2">Không cho phép</option>
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