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

    @include('component.pxxdh.add-pxxdh')
    @include('component.pxxdh.edit-pxxdh')
    @include('component.pxxdh.delete-pxxdh')
    @include('component.pxxdh.view-pxxdh')
    @include('component.pxxdh.approve-pxxdh-new')
    @include('component.pxxdh.rollback-pxxdh')
    @include('component.pxxdh.confirm-pxxdh')
    @include('component.pxxdh.download')
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
                    @can('create_pxxdhs')
                        <div class="col-12 col-lg-3">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addPhieuXXDHModal">+ Thêm mới</button>
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
                        @can('phan_bo_pxxdh')
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="phieuChuaPhanBo" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio4">Chưa phân bổ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="phieuDaPhanBo" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio5">Đã phân bổ</label>
                            </div>
                        @endcan

                        @can('view_pxxdhs')
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="tatca" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio3">Tất cả</label>
                            </div>
                        @endcan

                        @canany(['create_pxxdhs', 'sale_approve_pxxdhs', 'sm_approve_pxxdhs', 'quan_ly_khst_approve_pxxdhs', 'qa_approve_pxxdhs'])
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="phieuDoiDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio1">Phiếu đợi duyệt</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="phieuDaDuyet" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio2">Phiếu đã duyệt</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="tatca" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                                <label class="form-check-label" for="inlineRadio3">Tất cả</label>
                            </div>
                        @endcanany
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="tableMain" class="table text-center caption-top table-hover" style="width:1700px">
                                <caption>Danh sách phiếu xem xét đơn hàng</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Số phiếu</th>
                                        <th scope="col">Số SO</th>
                                        <th scope="col">Số HĐ</th>
                                        <th scope="col">Loại</th>
                                        <th scope="col">SX mới</th>
                                        <th scope="col">Lặp lại</th>
                                        <th scope="col">TK</th>
                                        <th scope="col" style="width:200px">Lot</th>
                                        <th scope="col" style="width:250px">Tên khách hàng</th>
                                        <th scope="col">Sale</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col" style="width: 170px">Trạng thái</th>
                                        <th scope="col" style="width: 130px"></th>
                                        <th scope="col" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($danhSachPhieuXXDH as $item)
                                        @if ($item->don_hang_sx_moi == '1')
                                            <tr>
                                                <td>{{ $item->so_phieu }}</td>
                                                <td>
                                                    <a href="http://quanly.soitheky.com.vn/so?search={{ $item->so }}" target="_blank" rel="noopener noreferrer">{{$item->so}}</a>
                                                </td>
                                                <td>{{ $item->hop_dong }}</td>
                                                <td>
                                                    @if ($item->loai == 'dht')
                                                        {{ 'Đh thường' }}
                                                    @else
                                                        {{ 'Đh mẫu' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_sx_moi == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_lap_lai == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_ton_kho == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $item->lot }}</td>
                                                <td>{{ $item->ten_cong_ty }}</td>
                                                <td>{{ $item->mail_chinh }}</td>
                                                <td>{{ $item->created_user }}</td>
                                                
                                                @if (strlen($item->so) < 12)
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
                                                    @elseif ($item->status == 'Sale APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif ($item->status == 'QA REQUESTED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif($item->status == 'KHST APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif($item->status == 'QA APPROVED')
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
                                                        <th style="color:green">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
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
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>  
                                                        </td>
                                                    @elseif ($item->status == 'Sale APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>  
                                                        </td>
                                                    @elseif ($item->status == 'SM APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i>  
                                                        </td>
                                                    @elseif ($item->status == 'QA REQUESTED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
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
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif($item->status == 'ADMIN APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif($item->status == 'QA APPROVED')
                                                        <th style="color: #BA4A00">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        </td>
                                                    @elseif($item->status == 'Finish')
                                                        <th style="color:green">{{ $item->status }}</th>
                                                        <td>
                                                            <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                            <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
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
                                                                @if ($item->mail_chinh == Auth::user()->email)
                                                                    @can('sale_approve_pxxdhs')
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> Sale Approve</a></li>
                                                                    @endcan
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item" wire:click="deletePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deletePhieuXXDHModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'Sale APPROVED')
                                                                @if (strlen($item->so) == 12)
                                                                    @can('sm_approve_pxxdhs')
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> SM Approve</a></li>
                                                                        <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                    @endcan
                                                                @endif
                                                                @if (strlen($item->so) < 12)
                                                                    @can('qa_approve_pxxdhs')
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                        <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                    @endcan
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'SM APPROVED')
                                                                @can('qa_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @elseif ($item->status == 'KHST APPROVED')
                                                                @if (strlen($item->so) < 12)
                                                                    @can('qa_approve_pxxdhs')
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                        <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                    @endcan
                                                                @endif
                                                                @if (strlen($item->so) == 12)
                                                                    @if ($item->created_user == Auth::user()->username)
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> Admin Approve</a></li>
                                                                        <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                    @endif
                                                                @endif
                                                                @can('phan_bo_pxxdh')
                                                                    <li><a class="dropdown-item" wire:click="xacNhanPhieuXXDHModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#xacNhanPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Xác nhận phân bổ</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="downloadFileModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#downloadFileModal"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    {{-- <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li> --}}
                                                                @endif
                                                            @elseif ($item->status == 'ADMIN APPROVED')
                                                                @can('qa_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                            @elseif ($item->status == 'QA REQUESTED')
                                                                @can('quan_ly_khst_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> KHST Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'QA APPROVED')
                                                                @can('phan_bo_pxxdh')
                                                                    <li><a class="dropdown-item" wire:click="xacNhanPhieuXXDHModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#xacNhanPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Xác nhận phân bổ</a></li>
                                                                @endcan
                                                                {{-- @can('quan_ly_khst_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> KHST Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan --}}
                                                                <li><a class="dropdown-item" wire:click="downloadFileModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#downloadFileModal"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                @endif
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'Finish')
                                                                @can('phan_bo_pxxdh')
                                                                    <li><a class="dropdown-item" wire:click="xacNhanPhieuXXDHModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#xacNhanPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Xác nhận phân bổ</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="downloadFileModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#downloadFileModal"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $item->so_phieu }}</td>
                                                <td>
                                                    <a href="http://quanly.soitheky.com.vn/so?search={{ $item->so }}" target="_blank" rel="noopener noreferrer">{{$item->so}}</a>
                                                </td>
                                                <td>{{ $item->hop_dong }}</td>
                                                <td>
                                                    @if ($item->loai == 'dht')
                                                        {{ 'Đh thường' }}
                                                    @else
                                                        {{ 'Đh mẫu' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_sx_moi == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_lap_lai == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->don_hang_ton_kho == '1')
                                                        <i class="fa-solid fa-square-check"></i>
                                                    @else
                                                        <i class="fa-regular fa-square"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $item->lot }}</td>
                                                <td>{{ $item->ten_cong_ty }}</td>
                                                <td>{{ $item->mail_chinh }}</td>
                                                <td>{{ $item->created_user }}</td>
                                                
                                                @if ($item->status == 'New')
                                                    <th style="color: #BA4A00"></i>{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    </td>
                                                @elseif ($item->status == 'Sale APPROVED')
                                                    <th style="color: #BA4A00">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
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
                                                    </td>
                                                @elseif($item->status == 'KHST APPROVED')
                                                    <th style="color: #BA4A00">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    </td>
                                                @elseif($item->status == 'Finish')
                                                    <th style="color:green">{{ $item->status }}</th>
                                                    <td>
                                                        <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                        <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="dropdown dropend float-end">
                                                        <button class="btn btn-primary dropdown-toggle" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                                            <i class="fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if ($item->status == 'New')
                                                                @if ($item->mail_chinh == Auth::user()->email)
                                                                    @can('sale_approve_pxxdhs')
                                                                        <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> Sale Approve</a></li>
                                                                    @endcan
                                                                @endif
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item" wire:click="deletePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deletePhieuXXDHModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'Sale APPROVED')
                                                                @can('qa_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> QA Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    {{-- <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li> --}}
                                                                @endif
                                                            @elseif ($item->status == 'QA APPROVED')
                                                                @can('quan_ly_khst_approve_pxxdhs')
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> KHST Approve</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                                @if ($item->updated_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="editPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editPhieuXXDHModal"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a></li>
                                                                    <li><a class="dropdown-item" wire:click="rollBackModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#rollBackPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Roll Back</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'KHST APPROVED')
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item fw-bolder" wire:click="approvePhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approvePhieuXXDHModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                                @endif
                                                                @can('phan_bo_pxxdh')
                                                                    <li><a class="dropdown-item" wire:click="xacNhanPhieuXXDHModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#xacNhanPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Xác nhận phân bổ</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="downloadFileModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#downloadFileModal"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @elseif ($item->status == 'Finish')
                                                                @can('phan_bo_pxxdh')
                                                                    <li><a class="dropdown-item" wire:click="xacNhanPhieuXXDHModal('{{ $item->so_phieu }}', '{{ $item->status }}')" data-bs-toggle="modal" data-bs-target="#xacNhanPhieuXXDHModal"><i class="fa-solid fa-rotate-left"></i> Xác nhận phân bổ</a></li>
                                                                @endcan
                                                                <li><a class="dropdown-item" wire:click="downloadFileModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#downloadFileModal"><i class="fa-solid fa-download"></i> Download</a></li>
                                                                <li><a class="dropdown-item" wire:click="viewPhieuXXDHModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#viewPhieuXXDHModal"><i class="fa-solid fa-eye"></i> Xem Chi tiết</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
                {{ $danhSachPhieuXXDH->links() }}
            </div>
        </div>
    </div>
</div>
