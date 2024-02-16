<form wire:submit.prevent="addNewUser">
    <div wire:ignore.self class="modal" id="addNewUserModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prvent="resetInput"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.defer="name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" wire:model.defer="username" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                            <input type="email" class="form-control" wire:model.defer="email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                            <input type="password" class="form-control" wire:model.defer="password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Confirm assword</label>
                            <div class="col-sm-8">
                            <input type="password" class="form-control" wire:model.defer="confirmPassword" required>
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