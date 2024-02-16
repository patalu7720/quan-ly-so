<form wire:submit.prevent="rollBack()">
    <div wire:ignore.self class="modal" id="rollBackBaoGiaModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Roll back phiếu {{ $soPhieu }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <select class="form-select" aria-label="Default select example" wire:model.defer="capRollBack" required>
                      <option value="">Chọn cấp cần roll back</option>
                      <option value="New">Sale</option>
                  </select>
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