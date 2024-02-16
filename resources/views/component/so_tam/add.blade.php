<form wire:submit.prevent="store">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="createModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">TẠO SO TẠM</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'create')
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Mã khách hàng</label>
                                <input class="form-control" list="datalistOptions" placeholder="Nhập tên khách hàng" wire:model.defer = "maKhachHang" required>
                                <datalist id="datalistOptions">
                                    @foreach ($danhSachKhachHang as $item)
                                        <option value="{{ $item->ma_khach_hang }}">{{ $item->ten_tv }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </form>