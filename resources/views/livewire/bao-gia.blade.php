<div class="container" style="margin-top: 10px">
    <style>
        #tableMain th:last-child td:last-child
        {
            position:sticky;
            right:0px;
        }
    </style>
    @include('component.baogia.add-bao-gia')
    @include('component.baogia.edit-bao-gia')
    @include('component.baogia.view-bao-gia')
    @include('component.baogia.approve-bao-gia')
    @include('component.baogia.delete-bao-gia')
    @include('component.baogia.rollback-bao-gia')
    @include('component.baogia.confirm-bao-gia')
    <div class="row">
        <div class="col">
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control" placeholder="Nhập từ khóa (vd: Số PXXDH, Username...)" wire:model.debounce.500ms="search" wire:model.defer="search">
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="date" class="form-control" wire:model.debounce.500ms="tuNgay">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="date" class="form-control" wire:model.debounce.500ms="denNgay">
                    </div>
                    @can('create_bao_gia')
                        <div class="col-12 col-lg-3">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addBaoGiaModal">+ Thêm mới</button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="shadow p-3 mb-2 bg-body-tertiary rounded">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="phieuDoiDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio1">Phiếu đợi duyệt</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="phieuDaDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio2">Phiếu đã duyệt</label>
                        </div>
                        @can('create_bao_gia')
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="phieuChoXacNhan" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio3">Phiếu chờ xác nhận</label>
                            </div>
                        @endcan
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="tatca" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio4">Tất cả</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="tableMain" class="table text-center table-striped table-hover caption-top" style="width:1300px">
                                <caption>Danh sách phiếu báo giá</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Số phiếu</th>
                                        <th scope="col">Loại</th>
                                        <th scope="col">Ngày</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col" style="width: 150px">Trạng thái</th>
                                        <th scope="col" style="width: 90px"></th>
                                        <th scope="col" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $item)
                                        <tr>
                                            <td>{{ $item->so_phieu }}</td>
                                            <td>{{ $item->loai == 'nd' ? 'Nội địa' : 'Xuất khẩu' }}</td>
                                            <td>{{ $item->ngay }}</td>
                                            <td>{{ $item->to }}</td>
                                            <td>{{ $item->created_user }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            @if ($item->status == 'New')
                                                <th style="color: blue">{{ $item->status }}</th>
                                                <td>
                                                    @if ($item->loai == 'nd')
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    @else
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    @endif
                                                </td>
                                            @elseif ($item->status == 'Approved 1')
                                                <th style="color:orangered">{{ $item->status }}</th>
                                                <td>
                                                    @if ($item->loai == 'nd')
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    @endif
                                                </td>
                                            @elseif ($item->status == 'Approved 2')
                                                <th style="color:orangered">{{ $item->status }}</th>
                                                <td>
                                                    @if ($item->loai == 'nd')
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    @else
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    @endif
                                                </td>
                                            @elseif ($item->status == 'Finish')
                                                <th style="color:green">{{ $item->status }}</th>
                                                <td>
                                                    @if ($item->loai == 'nd')
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    @else
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <div class="dropdown dropend float-end">
                                                    <button class="btn btn-primary dropdown-toggle" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-offset="0,10">
                                                        <i class="fa-solid fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($item->status == 'New')
                                                            @if ($item->loai == 'nd')
                                                                @can('approve_1_bao_gia')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approveBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveBaoGiaModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rollBackBaoGiaModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                            @else
                                                                @can('approve_2_bao_gia')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approveBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveBaoGiaModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rollBackBaoGiaModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                            @endif
                                                            @if ($item->created_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="editBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editBaoGiaModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                <li><a class="dropdown-item" wire:click="deleteBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deleteBaoGiaModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                            @endif
                                                        @elseif ($item->status == 'Approved 1')
                                                            @if ($item->loai == 'nd')
                                                                @can('approve_2_bao_gia')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approveBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveBaoGiaModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rollBackBaoGiaModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                            @endif
                                                        @elseif ($item->status == 'Approved 2')
                                                            @can('approve_3_bao_gia')
                                                                <li><a class="dropdown-item fw-bolder" wire:click="approveBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveBaoGiaModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rollBackBaoGiaModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                            @endcan
                                                        @elseif ($item->status == 'Finish')
                                                            <li><a class="dropdown-item" wire:click="downloadFile('{{ $item->so_phieu }}')"><i class="fa-solid fa-download"></i> Download</a></li>
                                                            @role('super_admin')
                                                                <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rollBackBaoGiaModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                            @endrole
                                                            @can('create_bao_gia')
                                                                <li><a class="dropdown-item fw-bolder" wire:click="confirmBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#confirmBaoGiaModal"><i class="fa-solid fa-check-double"></i> Confirm</a></li>
                                                            @endcan
                                                        @endif
                                                        <li><a class="dropdown-item" wire:click="viewBaoGiaModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewBaoGiaModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
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
                {{ $result->links() }}
            </div>
        </div>
    </div>
</div>
