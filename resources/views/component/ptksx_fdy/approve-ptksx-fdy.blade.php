<form wire:submit.prevent="approvePhieuTKSXFDY">
    <div wire:ignore.self class="modal" id="approvePhieuTKSXFDYModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Duyệt Phiếu TKSX FDY</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-1"></div>
                    <div class="col">
                        <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                            <div class="row mb-3 g-3">
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Số Phiếu : </p>
                                    <p class="card-text d-inline">{{ $soPhieu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Số SO : </p>
                                    <p class="card-text d-inline">{{ $soSO }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Line : </p>
                                    <p class="card-text d-inline">{{ $line }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                    <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Ngày dự định thay đổi : </p>
                                    <p class="card-text d-inline">{{ $ngayDuDinhThayDoi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Quy cách cũ : </p>
                                    <p class="card-text d-inline">{{ $quyCachCu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Quy cách mới : </p>
                                    <p class="card-text d-inline">{{ $quyCachMoi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Lot cũ : </p>
                                    <p class="card-text d-inline">{{ $lotCu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Lot mới : </p>
                                    <p class="card-text d-inline">{{ $lotMoi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Trọng Lượng : </p>
                                    <p class="card-text d-inline">{{ $trongLuong1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Trọng Lượng : </p>
                                    <p class="card-text d-inline">{{ $trongLuong2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Màu ống : </p>
                                    <p class="card-text d-inline">{{ $mauOng1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Màu ống : </p>
                                    <p class="card-text d-inline">{{ $mauOng2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Chip : </p>
                                    <p class="card-text d-inline">{{ $chip1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Chip : </p>
                                    <p class="card-text d-inline">{{ $chip2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Dầu : </p>
                                    <p class="card-text d-inline">{{ $dau1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Dầu : </p>
                                    <p class="card-text d-inline">{{ $dau2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Đoạn : </p>
                                    <p class="card-text d-inline">{{ $doan1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Đoạn : </p>
                                    <p class="card-text d-inline">{{ $doan2 }}</p>
                                </div>
        
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Thông tin khác : </p>
                                    <p class="card-text d-inline">{{ $thongTinKhac }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Khách hàng : </p>
                                    <p class="card-text d-inline">{{ $khachHang }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Số lượng : </p>
                                    <p class="card-text d-inline">{{ $soLuong }}</p>
                                </div>
        
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Ghi chú : </p>
                                    <p class="card-text d-inline">{{ $ghiChu }}</p>
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
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Duyệt</button>
            </div>
          </div>
        </div>
    </div>
</form>