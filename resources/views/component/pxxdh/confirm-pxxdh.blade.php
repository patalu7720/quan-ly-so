<div wire:ignore.self class="modal" id="xacNhanPhieuXXDHModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xác nhận phân bổ phiếu XXĐH</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
        </div>
        <div class="modal-body">
            <p>Số Phiếu : {{ $soPhieu }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-primary" wire:click="xacNhanPhieuXXDH">Thực hiện</button>
        </div>
      </div>
    </div>
</div>