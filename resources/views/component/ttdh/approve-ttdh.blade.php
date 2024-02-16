<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="duyetWebModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Duyệt TTDH</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
          </div>
          <div class="modal-body">
                <div class="shadow-sm p-3 mb-4 bg-body-tertiary rounded">
                    <p>Số TTDH : {{ $soPhieu }}</p>
                    <p>Khách hàng : {{ $khachHang }}</p>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
            <button type="button" class="btn btn-primary" wire:click="duyetWeb">Thực hiện</button>
          </div>
        </div>
      </div>
</div>