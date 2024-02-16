<form wire:submit.prevent="addPermission">
    <div wire:ignore.self class="modal" id="addPermissionModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prvent="resetInput"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $username }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Quyền trực tiếp</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model.defer="quyen_truc_tiep">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($getAllPermission != null)
                        @foreach ($getAllPermission as $item)
                            <p>{{ $item }}</p>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prvent="resetInput">Đóng</button>
            <button type="submit" class="btn btn-primary">Thực hiện</button>
            </div>
        </div>
        </div>
    </div>
</form>