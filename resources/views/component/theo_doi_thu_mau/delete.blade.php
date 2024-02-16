<div wire:ignore.self class="modal" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xóa phiếu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField()"></button>
        </div>
        <div class="modal-body">
            @if ($state == 'delete')
                <p>Số phiếu : {{ $theoDoiThuMauModel['so_phieu'] }}</p>
                <p>Tên Khách Hàng : {{ $theoDoiThuMauModel['ten_khach_hang'] }}</p>
                <p>Mã Khách Hàng : {{ $theoDoiThuMauModel['ma_khach_hang'] }}</p>
            @else
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-danger" wire:click="destroy">Thực hiện</button>
        </div>
      </div>
    </div>
</div>