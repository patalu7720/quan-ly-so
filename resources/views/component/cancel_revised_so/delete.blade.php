<div wire:ignore.self class="modal" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Cancel - Revised SO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField()"></button>
        </div>
        <div class="modal-body">
            <p>Số phiếu : {{ $cancelRevisedSO['so_phieu'] }}</p>
            <p>Tên Khách Hàng : {{ $cancelRevisedSO['ten_khach_hang'] }}</p>
            <p>Mã Khách Hàng : {{ $cancelRevisedSO['ma_khach_hang'] }}</p>
            <p>SO : {{ $cancelRevisedSO['so'] }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-danger" wire:click="delete">Thực hiện</button>
        </div>
      </div>
    </div>
</div>