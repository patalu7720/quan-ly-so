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

    @include('component.permission.add-new-permission-modal')
    @include('component.permission.delete-permission-modal')

    <div class="row mb-3 mt-5">
        <div class="col">
            <h3>Permission</h3>
        </div>
        <div class="col">
            <div class="input-group mb-3 float-start">
                <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." wire:keydown.enter="search" wire:model.defer="search">
            </div>
        </div>
        <div class="col">
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewPermissionModal">+ Thêm mới</button>
        </div>
    </div>
    <div class="row">
        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Permission</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listPermission as $item)
                        <tr>
                            <th class="counterCell"></th>
                            <td>{{ $item->name }}</td>
                            <td><a href="" wire:click.prevent="deletePermissionModal('{{ $item->name }}')" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" class="p-1"><i class="fa-regular fa-trash-can"></i></a></td>
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
                {{ $listPermission->links() }}
            </div>
        </div>
    </div>
</div>

