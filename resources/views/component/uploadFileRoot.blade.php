<form wire:submit.prevent="uploadFileRoot()">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="ModalUpFileRoot" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Upload hợp đồng bản gốc</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="file" class="form-control @error('fileroot') is-invalid @enderror" wire:model.defer="fileroot" required>
                            @error('fileroot')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
      </div>
    </div>
  </form>