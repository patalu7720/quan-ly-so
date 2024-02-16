<div class="container">
    <style>
        table {
            counter-reset: tableCount;     
        }
        .counterCell:before {              
            content: counter(tableCount); 
            counter-increment: tableCount; 
        }
    </style>

    @include('component.user.add-roles-to-user')
    @include('component.user.edit-user')
    @include('component.user.change-password')
    @include('component.user.add-new-user')
    @include('component.user.add-permission')

    <div class="row mb-3 mt-5">
        <div class="col">
            <h3>List User</h3>
        </div>
        <div class="col">
            <div class="input-group mb-3 float-start">
                <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." wire:keydown.enter="search" wire:model.defer="search">
            </div>
        </div>
        <div class="col">
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewUserModal">+ Thêm mới</button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 100px">#</th>
                            <th scope="col" style="width: 400px">Họ tên</th>
                            <th scope="col" style="width: 200px">Tài khoản</th>
                            <th scope="col" style="width: 200px">Mail</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($danhSachTaiKhoan as $item)
                            <tr>
                                <td class="counterCell"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <div class="btn-group float-end">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" wire:click="addRolesToUserModal('{{ $item->username }}')" data-bs-toggle="modal" data-bs-target="#addRolesToUserModal" ><i class="fa-solid fa-users-gear"></i> Quyền Role</a></li>
                                            <li><a class="dropdown-item" wire:click="addPermissionModal('{{ $item->username }}')" data-bs-toggle="modal" data-bs-target="#addPermissionModal" ><i class="fa-solid fa-users-gear"></i> Quyền trực tiếp</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" wire:click="editUserModal('{{ $item->username }}')" data-bs-toggle="modal" data-bs-target="#editUserModal" ><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                            <li><a class="dropdown-item" wire:click="changePasswordModal('{{ $item->username }}')" data-bs-toggle="modal" data-bs-target="#changePasswordModal" ><i class="fa-solid fa-key"></i> Đổi mật khẩu</a></li>
                                            
                                            @if ($item->isLock == 0)
                                                <li><a class="dropdown-item" wire:click="lockUser('{{ $item->username }}')"><i class="fa-solid fa-lock"></i> Khóa</a></li>
                                            @elseif ($item->isLock == 1)
                                                <li><a class="dropdown-item" wire:click="unLockUser('{{ $item->username }}')"><i class="fa-solid fa-lock-open"></i> Mở khóa</a></li>
                                            @endif    
                                            
                                            <li><a class="dropdown-item" wire:click="deleteUser('{{ $item->username }}')"><i class="fa-solid fa-trash-can"></i> Xóa</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
