<div wire:ignore.self class="modal" id="ModalXoa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xóa HĐ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
        </div>
        <div class="modal-body">

          @if ($this->loaihopdong == '1' || $this->loaihopdong == '2')
              
            <p>Xóa hợp đồng : {{ substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4) }}</p>

          @else

            <p>Xóa hợp đồng : {{ str_replace('_', '/',$this->shd) }}</p>
              
          @endif
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-primary" wire:click="delete">Thực hiện</button>
        </div>
      </div>
    </div>
</div>