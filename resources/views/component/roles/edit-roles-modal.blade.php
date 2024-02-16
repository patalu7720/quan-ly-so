<form wire:submit.prevent="editRoles">
    <div wire:ignore.self class="modal" id="editRolesModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prvent="resetInput"></button>
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
                                <h5>Báo giá</h5>
                                @foreach ($baoGiaPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Xác nhận đơn hàng</h5>
                                @foreach ($xacNhanDonHangPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>TTDH</h5>
                                @foreach ($ttdhPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>TDG</h5>
                                @foreach ($tdgPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Contracts</h5>
                                @foreach ($contractsPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Phiếu XXĐH</h5>
                                @foreach ($pxxdhsPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Phiếu TKSX</h5>
                                @foreach ($ptksxPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Mô phỏng</h5>
                                @foreach ($moPhongPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Cacel Revised SO</h5>
                                @foreach ($cancelRevisedSOPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Tiêu chuẩn khách hàng</h5>
                                @foreach ($tckhPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>Theo dõi thử mẫu</h5>
                                @foreach ($tdtmPermission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->name }}" wire:model.defer="{{ $item->name }}">
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prvent="resetInput">Đóng</button>
            <button type="submit" class="btn btn-primary">Thực hiện</button>
            </div>
        </div>
        </div>
    </div>
</form>