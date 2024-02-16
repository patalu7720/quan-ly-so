<div class="container" style="margin-top: 10px">
    <style>
        table {
            counter-reset: tableCount;     
        }
        .counterCell:before {              
            content: counter(tableCount); 
            counter-increment: tableCount; 
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

    @include('component.ptksx.add-ptksx')
    @include('component.ptksx.view-ptksx')
    @include('component.ptksx.edit-ptksx')
    @include('component.ptksx.delete-ptksx')
    @include('component.ptksx.approve-ptksx')
    @include('component.ptksx.rollback-ptksx')
    @include('component.ptksx.update-so-ptksx')
    @include('component.ptksx.reject')

    <div class="row mb-2">
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
                    @can('create_ptksx')
                        <div class="col-12 col-lg-3">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addPhieuMHDTYModal">
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
                        {{-- <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="phieuDaDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio2">Phiếu đã duyệt</label>
                        </div> --}}
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
                                <caption>Danh sách phiếu triển khai sản xuất DTY</caption>
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
                                    @foreach ($ptbtdmhdty as $item)
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
                                                @elseif ($item->status == 'Reject')
                                                    <th style="color: #BA4A00">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                    </td>
                                                @else
                                                    <th style="color: #BA4A00">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i>
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
                                                @else
                                                    <th style="color: #BA4A00">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
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
                                                                <li><a class="dropdown-item" wire:click="approvePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuMHDTYModal"><i class="fa-solid fa-check-double"></i> KHST Approve</a></li>
                                                                <li><a class="dropdown-item" wire:click="rejectModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Từ chối</a></li>
                                                            @endcan
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @if ($item->created_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="editPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuMHDTYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                <li><a class="dropdown-item" wire:click="deletePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deletePhieuMHDTYModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                            @endif
                                                        @elseif ($item->status == 'KHST APPROVED')
                                                            @if (!empty($item->sale))
                                                                @can('qa_approve_ptksx')
                                                                    <li><a class="dropdown-item" wire:click="approvePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuMHDTYModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                            @else
                                                                <li><a class="dropdown-item" wire:click="downloadFile('{{ $item->so_phieu }}')"><i class="fa-solid fa-download"></i> Download</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                        @elseif ($item->status == 'QA APPROVED')
                                                            @can('sale_approve_ptksx')
                                                                @if ($item->sale == Auth::user()->email)
                                                                    <li><a class="dropdown-item" wire:click="approvePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuMHDTYModal"><i class="fa-solid fa-check-double"></i> Sale Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endif
                                                            @endcan
                                                            @if ($item->updated_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="editPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuMHDTYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                        @elseif ($item->status == 'Sale APPROVED')
                                                            @can('sm_approve_ptksx')
                                                                <li><a class="dropdown-item" wire:click="approvePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuMHDTYModal"><i class="fa-solid fa-check-double"></i> SM Approve</a></li>
                                                                <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                            @endcan     
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            {{-- @if ($item->updated_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="editPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuMHDTYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                            @endif --}}
                                                        @elseif ($item->status == 'SM APPROVED')
                                                            @if ($item->created_user == Auth::user()->username)
                                                                <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuMHDTYModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                                <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            {{-- @if ($item->updated_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="editPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuMHDTYModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                            @endif --}}
                                                        @elseif ($item->status == 'Finish')
                                                            @if ($item->created_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="updateSoModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#updateSoModal"><i class="fa-solid fa-download"></i> Cập nhật SO</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" wire:click="downloadFile('{{ $item->so_phieu }}')"><i class="fa-solid fa-download"></i> Download</a></li>
                                                            <li><a class="dropdown-item" wire:click="viewPhieuMHDTYModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuMHDTYModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                        @endif
                                                        @role('super_admin')
                                                            <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuTKSXModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                        @endrole
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
                {{ $ptbtdmhdty->links() }}
            </div>
        </div>
    </div>
</div>
