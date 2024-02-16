<form wire:submit.prevent="rollBack()">
    <div wire:ignore.self class="modal" id="rollBackPhieuTKSXModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Roll back phiếu {{ $soPhieu }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
          </div>
          <div class="modal-body">
              <div class="row mb-3">
                  <select class="form-select" aria-label="Default select example" wire:model.defer="capRollBack" required>
  
                      <option value="">Chọn cấp cần roll back</option>
  
                      @if ($status == 'KHST APPROVED')
                        <option value="new">NV KHST</option>
  
                      @elseif ($status == 'QA APPROVED')
                        <option value="new">NV KHST</option>
  
                      @elseif ($status == 'Sale APPROVED')
                        <option value="new">NV KHST</option>
                        <option value="qa">QA</option>
                      @elseif ($status == 'Finish')
                        <option value="new">NV KHST</option>
                        <option value="qa">QA</option>
                      @endif
                  </select>
              </div>
              <div class="row g-2">
                <div class="col-12">
                  <label for="">Lý do</label>
                  <textarea cols="30" rows="3" class="form-control" wire:model.defer="lyDoRollback"></textarea>
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