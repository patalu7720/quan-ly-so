<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Reject TDG</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
          </div>
          <div class="modal-body">
                <div class="shadow-sm p-3 mb-4 bg-body-tertiary rounded">
                    <p>Số TDG : {{ $soPhieu }}</p>
                    <p>Khách hàng : {{ $khachHang }}</p>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <textarea class="form-control" cols="30" rows="5" wire:model.defer="reject" placeholder="Reason for reject"></textarea>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
            <button type="button" class="btn btn-primary" wire:click="reject">Thực hiện</button>
          </div>
        </div>
      </div>
</div>