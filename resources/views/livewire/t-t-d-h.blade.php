<div class="container py-3">
    @include('component.ttdh.add-ttdh')
    @include('component.ttdh.approve-ttdh')
    @include('component.ttdh.reject-ttdh')
    @include('component.ttdh.detail')
    @include('component.ttdh.add-ttdh-new-version')
    <style>
        label{
            font-weight: 600;
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
    <div class="shadow p-3 mb-4 bg-body-tertiary rounded">
        <div class="row g-2">
            <div class="col-12 col-lg-6">
                <input type="text" class="form-control" placeholder="Tìm kiếm..." wire:model="search">
            </div>
            <div class="col-12 col-lg-2">
                <input type="date" class="form-control" wire:model.debounce.500ms="tuNgay">
            </div>
            <div class="col-12 col-lg-2">
                <input type="date" class="form-control" wire:model.debounce.500ms="denNgay">
            </div>
            @can('create_ttdh')
                {{-- <div class="col-12 col-lg-2">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createTTDHModal">+ Tạo mới</button>
                </div> --}}
                <div class="col-12 col-lg-2">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createTTDHNewVersionModal" wire:click="createTTDHNewVersionModal">+ Tạo mới</button>
                </div>
            @endcan
            {{-- @role('super_admin')
                <div class="col-12 col-lg-4">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createTTDHNewVersionModal" wire:click="createTTDHNewVersionModal">+ Tạo mới</button>
                </div>
            @endrole --}}
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
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="tatca" wire:model="canhan_tatca" wire:click="changeCaNhanTatCa">
                            <label class="form-check-label" for="inlineRadio3">Tất cả</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="tableMain" class="table-responsive">
                            <table id="tableMain" class="table text-center caption-top table-hover" style="width:1200px">
                                <caption>Danh sách Phiếu TTĐH</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Số phiếu</th>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">Valid from</th>
                                        <th scope="col">Valid to</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col" style="width: 170px">Trạng thái</th>
                                        <th scope="col" style="width: 130px"></th>
                                        <th scope="col" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $item)
                                        <tr>
                                            <td>{{ $item->so_phieu }}</td>
                                            <td>{{ $item->customer }}</td>
                                            <td>{{ $item->valid_from }}</td>
                                            <td>{{ $item->valid_to }}</td>
                                            <td>{{ $item->created_user }}</td>
                                            @if ($item->status == 'New')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif ($item->status == 'Approve 1')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif ($item->status == 'Approve 2')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif ($item->status == 'Finish')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                </td>
                                            @else
                                                <th style="color: red">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @endif
                                            <td>
                                                <div class="dropdown dropend float-end">
                                                    <button class="btn btn-primary dropdown-toggle" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .70rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                                        <i class="fa-solid fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($item->status == 'New')
                                                            @can('approve_1_ttdh')
                                                                <li><a class="dropdown-item fw-bolder" wire:click="duyetWebModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#duyetWebModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                <li><a class="dropdown-item fw-bolder" wire:click="rejectModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Reject</a></li>
                                                            @endcan
                                                        @endif
                                                        @if ($item->status == 'Approve 1')
                                                            @can('approve_2_ttdh')
                                                                <li><a class="dropdown-item fw-bolder" wire:click="duyetWebModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#duyetWebModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                <li><a class="dropdown-item fw-bolder" wire:click="rejectModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Reject</a></li>
                                                            @endcan
                                                        @endif
                                                        @if ($item->status == 'Approve 2')
                                                            @can('approve_3_ttdh')
                                                                <li><a class="dropdown-item fw-bolder" wire:click="duyetWebModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#duyetWebModal"><i class="fa-solid fa-check-double"></i> Approve</a></li>
                                                                <li><a class="dropdown-item fw-bolder" wire:click="rejectModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Reject</a></li>
                                                            @endcan
                                                        @endif
                                                        <li><a class="dropdown-item" wire:click="downloadFile('{{ $item->so_phieu }}')"><i class="fa-solid fa-download"></i> Download</a></li>
                                                        <li><a class="dropdown-item" wire:click="detailModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fa-solid fa-eye"></i> Xem chi tiết</a></li>
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
