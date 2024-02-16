<div class="container">
    <form action="" wire:submit.prevent="download">
        <div class="row g-2" style="margin-top: 20px">
            <div class="col-12 col-lg-3">
                <label for="" class="form-label">Từ ngày</label>
                <input type="date" class="form-control" wire:model.defer="tuNgay" required>
            </div>
            <div class="col-12 col-lg-3">
                <label for="" class="form-label">Đến ngày</label>
                <input type="date" class="form-control" wire:model.defer="denNgay" required>
            </div>
            <div class="col-12 col-lg-3" style="margin-top: 35px">
                <button class="btn btn-primary">Tải xuống</button>
            </div>
        </div>
    </form>
</div>

