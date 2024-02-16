@if ($capDuyet != '4')
    <form wire:submit.prevent="duyetOutlook">
        <div class="row" style="padding-top: 120px">
            <div class="d-flex justify-content-center">
                <div class="col-11 col-lg-5">
                    <p class="fs-2 fw-bold">TDG Duyệt cấp {{ $capDuyet }}</p>
                    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                        <div class="row mb-3">
                            <label class="col-3 col-lg-2 col-form-label">Username</label>
                            <div class="col-9 col-lg-10">
                                <input type="text" class="form-control" wire:model.defer="username" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-3 col-lg-2 col-form-label">Password</label>
                            <div class="col-9 col-lg-10">
                                <input type="password" class="form-control" wire:model.defer="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
