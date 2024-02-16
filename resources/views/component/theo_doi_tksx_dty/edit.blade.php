<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="update">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="updateModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Cập nhật phiếu theo dõi TKSX DTY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'edit')
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="" class="form-label">Ngày sx chính thức</label>
                                <input type="date" class="form-control" wire:model.defer="ngaySXChinhThuc">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Ngày kiểm tra TSKT</label>
                                <input type="date" class="form-control" wire:model.defer="ngayKiemTraTSKT">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Ngày QC kiểm TSKT</label>
                                <input type="date" class="form-control" wire:model.defer="ngayQCKiemTSKT">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Kết quả</label>
                                <select name="" id="" class="form-select" wire:model.defer="ketQua">
                                    <option value="">***</option>
                                    <option value="Đạt">Đạt</option>
                                    <option value="Không đạt">Không đạt</option>
                                    <option value="Lot cũ">Lot cũ</option>
                                    <option value="Không SX">Không SX</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Đính kèm file</label>
                                <input type="file" class="form-control" wire:model.defer="fileDinhKem">
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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </form>