<div wire:ignore.self class="modal" id="rejectModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" for="">Lý do Từ Chối</label>
              <textarea name="" id="" cols="30" rows="5" class="form-control" wire:model.defer="noteReject" placeholder="Lý do từ chối"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-primary" wire:click="reject">Thực hiện</button>
        </div>
      </div>
    </div>
</div>