<div class="container">
    <div class="row p-3 d-flex justify-content-center">
        <div class="col-5">
            <div class="row g-2">
                <div class="col-12">
                    <label for="" class="form-label">Số TDG</label>
                    <input type="text" class="form-control" placeholder="Nhập sô TDG" wire:model.defer="soTDG">
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Cấp duyệt</label>
                    <select name="" id="" class="form-select" wire:model.defer="capDuyet">
                        <option value="">Chọn cấp duyệt</option>
                        <option value="1">1 - Cấp duyệt 1</option>
                        <option value="2">2 - Cấp duyệt 2</option>
                        <option value="3">3 - Cấp duyệt 3</option>
                        <option value="4">4 - Cấp duyệt 4</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-primary" wire:click="submit">Thực hiện</button>
                </div>
            </div>
        </div>
    </div>
</div>
