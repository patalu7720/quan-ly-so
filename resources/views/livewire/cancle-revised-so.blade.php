<div class="container" style="margin-top: 10px">
    @include('component.cancel_revised_so.add')
    @include('component.cancel_revised_so.edit')
    @include('component.cancel_revised_so.show')
    @include('component.cancel_revised_so.approve')
    @include('component.cancel_revised_so.delete')
    @include('component.cancel_revised_so.reject')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Khung tìm kiếm
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-6 col-lg-3">
                                    <label for="" class="form-label">Số phiếu</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Nhập số phiếu" wire:model.debounce.500ms="soPhieuTimKiem">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Nhập tên khách hàng"  wire:model.defer="tenKhachHangTimKiem">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">S/O</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Nhập S/O" wire:model.defer="soTimKiem">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="" id="" class="form-select form-select-sm" wire:model.defer="trangThaiTimKiem">
                                        <option value="">Tất cả</option>
                                        <option value="New">New</option>
                                        <option value="Sale Approved">Sale Approved</option>
                                        <option value="SM Approved">SM Approved</option>
                                        <option value="KHST Approved">KHST Approved</option>
                                        <option value="MD Approved">MD Approved</option>
                                        <option value="Finish">Finish</option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Admin</label>
                                    <select name="" id="" class="form-select form-select-sm" wire:model.defer="adminTimKiem">
                                        <option value="">Tất cả</option>
                                        @if ($danhSachAdmin != null)
                                            @foreach ($danhSachAdmin as $item)
                                                <option value="{{ $item->username }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Sale phụ trách</label>
                                    <select name="" id="" class="form-select form-select-sm" wire:model.defer="saleTimKiem">
                                        <option value="">Tất cả</option>
                                        @if ($danhSachSale != null)
                                            @foreach ($danhSachSale as $item)
                                                <option value="{{ $item->email }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label for="" class="form-label">Từ ngày</label>
                                    <input type="date" class="form-control form-control-sm" wire:model.debounce.500ms="tuNgay">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label for="" class="form-label">Đến ngày</label>
                                    <input type="date" class="form-control form-control-sm" wire:model.debounce.500ms="denNgay">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary btn-sm float-end" wire:click="timKiem">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('create_cancel_revised_so')
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal" wire:click="create">+ Thêm mới</button>
            @endcan
        </div>
        <div class="col-12">
            <div class="shadow p-2 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-sm" style="width: 1300px">
                                <thead>
                                    <th>Số phiếu</th>
                                    <th>Tên khách hàng</th>
                                    <th>Mã khách hàng</th>
                                    <th>SO</th>
                                    <th>Date</th>
                                    <th>Người tạo</th>
                                    <th>Trạng thái</th>
                                    <td></td>
                                    <th>Thời gian tạo</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach (session('main') as $item)
                                        <tr>
                                            <td>{{ $item->so_phieu }}</td>
                                            <td>{{ $item->ten_khach_hang }}</td>
                                            <td>{{ $item->ma_khach_hang }}</td>
                                            <td>{{ $item->so }}</td>
                                            <td>{{ Carbon::create($item->date)->isoFormat('DD-MM-YYYY') }}</td>
                                            <td>{{ $item->created_user }}</td>
                                            @if ($item->status == 'New')
                                                <th style="color: blue">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif ($item->status == 'Sale Approved')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif ($item->status == 'SM Approved')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif($item->status == 'KHST Approved')
                                                <th style="color: #BA4A00">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-plus mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-check mx-0" style="color: green"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @elseif($item->status == 'MD Approved')
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
                                            @elseif($item->status == 'Reject')
                                                <th style="color:red">{{ $item->status }}</th>
                                                <td>
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                    <i class="fa-solid fa-square-minus mx-0" style="color: #ABB2B9"></i> 
                                                </td>
                                            @endif
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-sharp fa-solid fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" wire:click="show('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fa-regular fa-eye"></i> Xem chi tiết</a></li>
                                                        @if ($item->status == 'New')
                                                            @if ($item->created_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="edit('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> Cập nhật</a></li>
                                                                <li><a class="dropdown-item" wire:click="delete('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                            @elseif ($item->sale_phu_trach == Auth::user()->email)
                                                                <li><a class="dropdown-item" wire:click="edit('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> Cập nhật</a></li>
                                                                <li><a class="dropdown-item" wire:click="approveModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Duyệt</a></li>
                                                            @endif
                                                        @elseif ($item->status == 'Sale Approved')
                                                            @if ($item->updated_user == Auth::user()->username)
                                                                <li><a class="dropdown-item" wire:click="edit('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> Cập nhật</a></li>
                                                            @endif
                                                            @can('approve_2_cancel_revised_so')
                                                                <li><a class="dropdown-item" wire:click="approveModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Duyệt</a></li>
                                                                <li><a class="dropdown-item" wire:click="rejectModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Từ chối</a></li>
                                                            @endcan
                                                        @elseif ($item->status == 'SM Approved')
                                                            @can('approve_3_cancel_revised_so')
                                                                <li><a class="dropdown-item" wire:click="approveModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Duyệt</a></li>
                                                                <li><a class="dropdown-item" wire:click="rejectModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Từ chối</a></li>
                                                            @endcan
                                                        @elseif ($item->status == 'KHST Approved')
                                                            @can ('approve_4_cancel_revised_so')
                                                                <li><a class="dropdown-item" wire:click="approveModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Duyệt</a></li>
                                                                <li><a class="dropdown-item" wire:click="rejectModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i> Từ chối</a></li>
                                                            @endcan
                                                        @elseif ($item->status == 'MD Approved')
                                                            @if ($item->sale_phu_trach == Auth::user()->email)
                                                                <li><a class="dropdown-item" wire:click="approveModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                            @endif
                                                        @endif
                                                        @if (in_array($item->status,['KHST Approved', 'MD Approved', 'Finish']))
                                                            <li><a class="dropdown-item" wire:click="download('{{ $item->so }}', '{{ $item->id }}')"><i class="fa-solid fa-download"></i> Tải xuống file</a></li>
                                                        @endif
                                                        @role('super_admin')
                                                            <li><a class="dropdown-item" wire:click="deleteModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
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
                {{ session('main')->links() }}
            </div>
        </div>
    </div>
</div>
