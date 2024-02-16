<form wire:submit.prevent="uploadHopDongCoFileSan()">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="ModalUploadHopDongCoFileSan" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Upload File HĐ có sẵn </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="selectBenA" class="form-label">Công ty - chi nhánh</label>
                            <select id="selectBenA" name="selectBenA" class="form-select" aria-label="Default select example" wire:model="bena">
                                <option value="">{{ __('Chọn bên A') }}</option>
                                @foreach ($danhsachbena as $item)
                                    <option value="{{ $item->id }}">{{ $item->ten_tv }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="hidden" wire:model.defer = "makhachhangbenb">
                            <label for="exampleDataList" class="form-label">Khách hàng</label>
                            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Nhập tên khách hàng" wire:model = "benb" required>
                            <datalist id="datalistOptions">
                                @foreach ($danhsachbenb as $item)
                                    <option value="{{ $item->ten_tv }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="file" class="form-control @error('filehdcosan') is-invalid @enderror" wire:model.defer="filehdcosan" required>
                            @error('filehdcosan')
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