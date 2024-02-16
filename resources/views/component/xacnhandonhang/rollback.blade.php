<form wire:submit.prevent="rollbackXNDH">
    <div wire:ignore.self class="modal" id="rollbackXNDHModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Roll back</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
          </div>
          <div class="modal-body">
              <p>Số phiếu : {{ $soPhieu }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
            <button type="submit" class="btn btn-primary">Thực hiện</button>
          </div>
        </div>
      </div>
    </div>
  </form>