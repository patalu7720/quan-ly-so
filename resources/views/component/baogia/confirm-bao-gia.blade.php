<form wire:submit.prevent="confirmBaoGia">
    <div wire:ignore.self class="modal" id="confirmBaoGiaModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Xác nhận phiếu Báo Giá</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                <p>Số Phiếu : {{ $soPhieu }}</p>
                <div class="row">
                    <div class="col-12">
                        <label for="" class="form-label">Thông tin xác nhận</label>
                        <textarea name="" id="" cols="30" rows="3" class="form-control" wire:model.defer="thongTinXacNhan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
              <button type="submit" class="btn btn-primary">Thực hiện</button>
            </div>
          </div>
        </div>
    </div>
</form>