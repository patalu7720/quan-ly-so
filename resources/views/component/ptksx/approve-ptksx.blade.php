<form wire:submit.prevent="approvePhieuMHDTY">
    <div wire:ignore.self class="modal" id="approvePhieuMHDTYModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Duyệt Phiếu TKSX DTY - {{ $soPhieu }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                @if (empty($sale))
                    <div class="row mb-3">
                        <div class="col-1"></div>
                        <div class="col">
                            <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                                <div class="row mb-2 g-3">
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số Phiếu : </p>
                                        <p class="card-text d-inline">{{ $soPhieu }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số Máy : </p>
                                        <p class="card-text d-inline">{{ $soMay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                        <p class="card-text d-inline">{{ $quyCach }}</p>&emsp;&emsp;
                                        <p class="card-text d-inline">{{ $maHang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ngày : </p>
                                        <p class="card-text d-inline">{{ $ngay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                        <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="col-1"></div>
                        <div class="col">
                            <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                                <div class="row mb-2 g-3">
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số Phiếu : </p>
                                        <p class="card-text d-inline">{{ $soPhieu }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số SO : </p>
                                        <p class="card-text d-inline">{{ $soSO }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số Máy : </p>
                                        <p class="card-text d-inline">{{ $soMay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                        <p class="card-text d-inline">{{ $quyCach }}</p>&emsp;&emsp;
                                        <p class="card-text d-inline">{{ $maHang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ngày : </p>
                                        <p class="card-text d-inline">{{ $ngay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                        <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Màu ống : </p>
                                        <p class="card-text d-inline">{{ $mauOng }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Sợi (Đơn/Chập) : </p>
                                        <p class="card-text d-inline">{{ $soi }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã cũ - mới : </p>
                                        <p class="card-text d-inline">{{ $maCuMoi }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Quy cách POY : </p>
                                        <p class="card-text d-inline">{{ $quyCachPOY }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Mã POY : </p>
                                        <p class="card-text d-inline">{{ $maPOY }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Quy cách DTY : </p>
                                        <p class="card-text d-inline">{{ $quyCachDTY }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Mã DTY : </p>
                                        <p class="card-text d-inline">{{ $maDTY }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Khách hàng : </p>
                                        <p class="card-text d-inline">{{ $tenCongTy }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Loại hàng : </p>
                                        <p class="card-text d-inline">{{ $loaiHang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số lượng đơn hàng : </p>
                                        <p class="card-text d-inline">{{ $soLuongDonHang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ghi chú số lượng : </p>
                                        <p class="card-text d-inline">{{ $ghiChuSoLuong }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Điều kiện của khách hàng : </p>
                                        <p class="card-text d-inline">{{ $dieuKienKhachHang }}</p>
                                    </div>
                                    @if ($qaKienNghi != '')
                                        <div class="col-12">
                                            <p class="fw-semibold d-inline">QA kiến nghị : </p>
                                            <p class="card-text d-inline">{{ $qaKienNghi }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    @if ($status == 'KHST APPROVED')
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="mb-3">
                                    <label class="form-label">QA kiến nghị</label>
                                    <textarea name="" id="" cols="30" rows="3" class="form-control" placeholder="Nhập QA kiến nghị" wire:model="qaKienNghi"></textarea>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
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