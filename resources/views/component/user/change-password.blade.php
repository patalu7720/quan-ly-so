<form wire:submit.prevent="changePassword">
    <div wire:ignore.self class="modal" id="changePasswordModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prvent="resetInput"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model.defer = "username">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">New password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" wire:model.defer = "newPassword" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Confirm</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model.defer = "newPasswordConfirmation" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
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