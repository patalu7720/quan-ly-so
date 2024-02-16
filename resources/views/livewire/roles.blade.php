<div class="container" style="margin-top: 20px">
    <style>
        table {
            counter-reset: tableCount;     
        }
        .counterCell:before {              
            content: counter(tableCount); 
            counter-increment: tableCount; 
        }
    </style>

    @include('component.roles.add-new-roles-modal')
    @include('component.roles.detail-roles-modal')
    @include('component.roles.edit-roles-modal')
    @include('component.roles.delete-roles-modal')

    <div class="row mb-3 mt-5">
        <div class="col">
            <h3>Roles</h3>
        </div>
        <div class="col">
            <div class="input-group mb-3 float-start">
                <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." wire:keydown.enter="search" wire:model.defer="search">
            </div>
        </div>
        <div class="col">
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewRolesModal">+ Thêm mới</button>
        </div>
    </div>
    <div class="row">
        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Roles</th>
                        <th scope="col" style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listRoles as $item)
                        <tr>
                            <th class="counterCell"></th>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="" wire:click.prevent="detailRolesModal('{{ $item->name }}')" data-bs-toggle="modal" data-bs-target="#detailRolesModal" class="p-1"><i class="fa-regular fa-eye"></i></a>
                                <a href="" wire:click.prevent="editRolesModal('{{ $item->name }}')" data-bs-toggle="modal" data-bs-target="#editRolesModal" class="p-1"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="" wire:click.prevent="deleteRoleModal('{{ $item->name }}')" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" class="p-1"><i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="float-start">
                <select class="form-select" wire:model="paginate">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                </select>
            </div>
            <div class="float-end">
                {{ $listRoles->links() }}
            </div>
        </div>
    </div>
</div>

