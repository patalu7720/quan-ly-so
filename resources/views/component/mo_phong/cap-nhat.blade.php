<form wire:submit.prevent="capNhat">
    <div class="row">
        <div class="col">
            <div wire:ignore.self class="modal" id="capNhatModal" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Cập nhật mô phỏng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
                        </div>
                        <div class="modal-body">
                            @if ($state == 'capNhat')
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="" class="form-label">Số lưu kho</label>
                                        <input type="text" placeholder="Nhập số lưu kho" class="form-control" wire:model.defer="soLuuKho" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Mã hàng</label>
                                        <input type="text" class="form-control" placeholder="Mã hàng" wire:model.defer="maHang" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Quy cách</label>
                                        <input type="text" class="form-control" placeholder="Quy cách" wire:model.defer="quyCach" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Máy</label>
                                        <input type="text" placeholder="Nhập sô máy" class="form-control" wire:model.defer="may">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Plant</label>
                                        <input type="text" placeholder="Nhập plant" class="form-control" wire:model.defer="plant">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Ngày sản xuất</label>
                                        <input type="date" class="form-control" wire:model.defer="ngaySanXuat">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Lần xuống giàn</label>
                                        <input type="text" placeholder="Nhập lần xuống giàn" class="form-control" wire:model.defer="lanXuongGian">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Ngày trên TKSX</label>
                                        <input type="date" placeholder="Nhập lần xuống giàn" class="form-control" wire:model.defer="ngayTrenTKSX" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Ngày dệt</label>
                                        <input type="date" class="form-control" wire:model.defer="ngayDet">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Kết quả nhuộm</label>
                                        <input type="text" placeholder="Nhập kết quả nhuộm" class="form-control" wire:model.defer="ketQuaNhuom">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField">Close</button>
                            <button type="submit" class="btn btn-primary">Thực hiện</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>