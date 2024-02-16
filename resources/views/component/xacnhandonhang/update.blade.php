<form wire:submit.prevent="updateXNDH">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="updateXNDHModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update phiếu XNĐH</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'update')
                        <div class="row mb-3">
                            <div class="col">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="nd" wire:model.defer="loai">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Nội địa
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="xk" wire:model.defer="loai">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Xuất khẩu
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Ngày</label>
                                    <input type="date" class="form-control" wire:model.defer="ngay">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bên A</label>
                                    <select class="form-select" wire:model.defer="benA" required>
                                        <option value="" selected>Chọn Bên A</option>
                                        <option value="congTy">CÔNG TY CỔ PHẦN SỢI THẾ KỶ</option>
                                        <option value="chiNhanh">Chi Nhánh CÔNG TY CỔ PHẦN SỢI THẾ KỶ</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bên B</label>
                                    <input class="form-control" list="datalistOptions" placeholder="Nhập Bên B" wire:model.defer = "benB" required>
                                    <datalist id="datalistOptions">
                                        @foreach ($danhSachBenB as $item)
                                            <option value="{{ $item->ten_tv }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ bên B</label>
                                    <input type="text" class="form-control" placeholder="Địa chỉ bên B" wire:model.defer = "diaChiBenB" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Incoterm</label>
                                <input type="text" class="form-control" placeholder="Nhập Incoterm" wire:model.defer = "incoterm">
                            </div>
                        </div>
                        <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm" wire:click.prevent="addQuyCach({{ $i }})"><i class="fa-solid fa-plus fa-xl"></i> Thêm 1 quy cách</button>
                                </div>
                            </div>
                            @foreach ($XNDHQuyCach as $item)
                                <div class="row mb-2 g-2">
                                    <div class="col-7">
                                        <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCachEdit.{{ $item->id ?? $item['id'] }}" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuongEdit.{{ $item->id ?? $item['id'] }}" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Đơn giá" required wire:model.defer="donGiaEdit.{{ $item->id ?? $item['id'] }}" required>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($inputs as $key => $value)
                                <hr>
                                <div class="row mb-2 g-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="Quy cách" required wire:model.defer="quyCach.{{ $value }}" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Số lượng" required wire:model.defer="soLuong.{{ $value }}" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Đơn giá" required wire:model.defer="donGia.{{ $value }}" required>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-outline-danger btn-sm"  style="margin-top: 3px" wire:click.prevent="removeQuyCach({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Thời gian giao hàng</label>
                                <input type="text" class="form-control" placeholder="Nhập thời gian giao hàng" wire:model.defer="thoiGianGiaoHang">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xuất xứ</label>
                                <input type="text" class="form-control" placeholder="Nhập xuất xứ" wire:model.defer="xuatXu">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Đóng gói</label>
                                <input type="text" class="form-control" placeholder="Nhập đóng gói" wire:model.defer="dongGoi">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình thức thanh toán</label>
                                <input type="text" class="form-control" placeholder="Nhập hình thức thanh toán" wire:model.defer="hinhThucThanhToan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thời gian thanh toán</label>
                                <input type="text" class="form-control" placeholder="Nhập thời gian thanh toán" wire:model.defer="thoiGianThanhToan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa điểm giao hàng</label>
                                <input type="text" class="form-control" placeholder="Nhập địa điểm giao hàng" wire:model.defer="diaDiemGiaoHang">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi chú</label>
                                <textarea name="" id="" cols="30" rows="3" class="form-control" placeholder="Nhập ghi chú" wire:model="ghiChu"></textarea>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField">Đóng</button>
                <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
            </div>
        </div>
    </div>
</form>
