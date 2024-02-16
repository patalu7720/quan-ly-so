<div wire:ignore.self class="modal" id="detailRolesModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Role name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model.defer="roleName" readonly>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Permissions</legend>
                        <div class="col">
                            <h5>Contracts</h5>
                            @foreach ($contractsPermission as $item)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}" disabled>
                                    <label class="form-check-label" for="{{ $item->name }}">
                                        {{ $item->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">User</legend>
                        <div class="col-4">
                            @if ($getAllUsersOfRole != null)
                                <table class="table">
                                    @foreach ($getAllUsersOfRole as $item)
                                        <tr>
                                            <td>{{ $item->username }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
    </div>
    </div>
</div>