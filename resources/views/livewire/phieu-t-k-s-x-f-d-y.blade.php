<div class="container" style="margin-top: 10px">
    <style>
        table {
            counter-reset: tableCount;     
        }
        .counterCell:before {              
            content: counter(tableCount); 
            counter-increment: tableCount; 
        }
        label{
            font-weight:600;
        }
        body{
            font-size: 12.5px;
            font-family: Arial, Helvetica, sans-serif;
        }
        #tableMain th:last-child td:last-child
        {
            position:sticky;
            right:0px;
        }
        #tableMain td:last-child
        {
            position:sticky;
            right:0px;
        }
    </style>

    @include('component.ptksx_fdy.add-ptksx-fdy')
    @include('component.ptksx_fdy.view-ptksx-fdy')
    @include('component.ptksx_fdy.edit-ptksx-fdy')
    @include('component.ptksx_fdy.delete-ptksx-fdy')
    @include('component.ptksx_fdy.approve-ptksx-fdy')
    @include('component.ptksx_fdy.rollback-ptksx-fdy')
    @include('component.ptksx_fdy.update-so-ptksxfdy')

    <div class="row mb-2">
        <div class="col">
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control" placeholder="Nhập từ khóa (vd: Số phiếu, Username...)" wire:model.debounce.500ms="search" wire:model.defer="search">
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="date" class="form-control" wire:model.debounce.500ms="tuNgay">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="date" class="form-control" wire:model.debounce.500ms="denNgay">
                    </div>
                    @can('create_ptksx')
                        <div class="col-12 col-lg-3">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addPhieuTKSXFDYModal">
                                + Thêm mới
                            </button>
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
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1_" value="phieuDoiDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio1_">Phiếu đợi duyệt</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2_" value="phieuDaDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio2_">Phiếu đã duyệt</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3_" value="tatca" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio3_">Tất cả</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="tableMain" class="table text-center caption-top table-striped table-hover" style="width:1200px">
                                <caption>Danh sách phiếu triển khai sản xuất FDY</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Số phiếu</th>
                                        <th scope="col">Số SO</th>
                                        <th scope="col">Tên khách hàng</th>
                                        <th scope="col">Sale phụ trách</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col">Thời gian tạo</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col" style="width: 120px"></th>
                                        <th scope="col" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($ptksxfdy != null)
                                        @foreach ($ptksxfdy as $item)
                                            <tr>
                                                @if (empty($item->so))
                                                    @if (empty($item->sale))
                                                        <td>{{ $item->so_phieu . ' ' }}<i class="fa-solid fa-ban" style="color: red"></i></td>
                                                    @else
                                                        <td>{{ $item->so_phieu . ' ' }}<i class="fa-regular fa-circle-question" style="color:orange"></i></td>
                                                    @endif
                                                @else
                                                    <td>{{ $item->so_phieu . ' ' }}<i class="fa-regular fa-rectangle-list" style="color:green"></i></td>
                                                @endif
                                                
                                                <td>{{ $item->so == '' ? '-' : $item->so }}</td>
                                                <td>{{ $item->khach_hang }}</td>
                                                <td>{{ $item->sale }}</td>
                                                <td>{{ $item->created_user }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                @if (empty($item->sale))
                                                    @if ($item->status == 'New')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td>
                                                    @else
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: green"></i>
                                                        </td>
                                                    @endif
                                                @else
                                                    @if ($item->status == 'New')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td>
                                                    @elseif($item->status == 'KHST APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td>
                                                    @elseif($item->status == 'QA APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td>
                                                    @elseif($item->status == 'Sale APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td>
                                                    @elseif($item->status == 'SM APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        </td> 
                                                    @elseif($item->status == 'Finish')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                        </td>
                                                    @endif
                                                @endif
                                                <td>
                                                    <div class="dropdown dropend float-end">
                                                        <button class="btn btn-primary dropdown-toggle" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                                            <i class="fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if ($item->status == 'New')
                                                                @can('quan_ly_khst_approve_ptksx')
                                                                    <li><a class="dropdown-item" wire:click="approvePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuTKSXFDYModal"><i class="fa-solid fa-check-double"></i> KHST Approve</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuTKSXFDYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item" wire:click="deletePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deletePhieuTKSXFDYModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'KHST APPROVED')
                                                                @can('qa_approve_ptksx')
                                                                    <li><a class="dropdown-item" wire:click="approvePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuTKSXFDYModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXFDYModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @elseif ($item->status == 'QA APPROVED')
                                                                @can('sale_approve_ptksx')
                                                                    <li><a class="dropdown-item" wire:click="approvePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuTKSXFDYModal"><i class="fa-solid fa-check-double"></i> Sale Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXFDYModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuTKSXFDYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @elseif ($item->status == 'Sale APPROVED')
                                                                @can('sm_approve_ptksx')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuTKSXFDYModal"><i class="fa-solid fa-check-double"></i> SM Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXFDYModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                {{-- @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuTKSXFDYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif --}}
                                                            @elseif ($item->status == 'SM APPROVED')
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuTKSXFDYModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXFDYModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                {{-- @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuMHDTYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif --}}
                                                            @elseif ($item->status == 'Finish')
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="updateSoModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#updateSoModal"><i class="fa-solid fa-download"></i> Cập nhật SO</a></li>
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="downloadFile('{{ $item->so_phieu }}')"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuTKSXFDYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuTKSXFDYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($ptksxfdy != null)
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
                    {{ $ptksxfdy->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
