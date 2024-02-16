<div class="container">
    @include('component.theo_doi_thu_mau.create')
    @include('component.theo_doi_thu_mau.show')
    @include('component.theo_doi_thu_mau.edit')
    @include('component.theo_doi_thu_mau.delete')
    <div class="row my-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <label for="" class="form-label">Số phiếu</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Nhập số phiếu" wire:model.defer="soPhieuTimKiem">
                        </div>
                        <div class="col-6 col-lg-3">
                            <label for="" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Nhập tên khách hàng" wire:model.defer="tenKhachHangTimKiem">
                        </div>
                        <div class="col-6 col-lg-3">
                            <button class="btn btn-outline-primary btn-sm" wire:click="timKiem" style="margin-top: 28px">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-2">
        <div class="col-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="choDuyet" wire:model="radioTimKiem">
                <label class="form-check-label" for="flexRadioDefault1">
                    Chờ duyệt
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="daDuyet" wire:model="radioTimKiem">
                <label class="form-check-label" for="flexRadioDefault2">
                    Đã duyệt
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="tatCa" wire:model="radioTimKiem">
                <label class="form-check-label" for="flexRadioDefault3">
                    Tất cả
                </label>
            </div>
        </div>
        <div class="col-6">
            @can('create_tdtm')
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal" wire:click="create">+ Thêm mới</button>
            @endcan
        </div>
        <div class="col-12">
            <div class="shadow p-2 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-sm" style="width: 1400px">
                                <thead>
                                    <th></th>
                                    <th>Số phiếu</th>
                                    <th>Ngày</th>
                                    <th>Mã KH</th>
                                    <th>Tên KH</th>
                                    <th>Items</th>
                                    <th>Lot</th>
                                    <th>Người tạo</th>
                                    <th>Tạo lúc</th>
                                </thead>
                                <tbody>
                                    @if (session('main') != null)
                                        @foreach (session('main') as $item)
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-sharp fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" wire:click="show('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fa-regular fa-eye"></i> Xem chi tiết</a></li>
                                                            @if ($item->status == 'Mới')
                                                                @can('sm_duyet_tdtm')
                                                                    <li><a class="dropdown-item" wire:click="approveModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> SM Duyệt</a></li>
                                                                @endcan
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="edit('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> Cập nhật</a></li>
                                                                    <li><a class="dropdown-item" wire:click="delete('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-regular fa-trash-can"></i> Xóa</a></li>
                                                                @endif
                                                            @elseif ($item->status == 'SM đã duyệt')
                                                                @can('qa_duyet_tdtm')
                                                                    <li><a class="dropdown-item" wire:click="approveModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> QA Duyệt</a></li>
                                                                @endcan
                                                                {{-- @if ($item->mail_sale == Auth::user()->email)
                                                                    <li><a class="dropdown-item" wire:click="edit('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> Cập nhật</a></li>
                                                                @endif --}}
                                                            @elseif ($item->status == 'QA đã duyệt')
                                                                @can('khst_duyet_tdtm')
                                                                    <li><a class="dropdown-item" wire:click="approveModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> KHST Duyệt</a></li>
                                                                @endcan
                                                            @elseif ($item->status == 'KHST đã duyệt')
                                                                @if ($item->created_user == Auth::user()->username)
                                                                    <li><a class="dropdown-item" wire:click="approveModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="fa-solid fa-check-double"></i> Finish</a></li>
                                                                @endif                                                                
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>{{ $item->so_phieu }}</td>
                                                <td>{{ $item->ngay }}</td>
                                                <td>{{ $item->ma_khach_hang }}</td>
                                                <td>{{ $item->ten_khach_hang }}</td>
                                                <td>{{ $item->loai_soi }}</td>
                                                <td>{{ $item->lot }}</td>
                                                <td>{{ $item->created_user }}</td>
                                                <td>{{ $item->created_at }}</td>
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
                @if (session('main') != null)
                    {{ session('main')->links() }}
                @endif
            </div>
        </div>
    </div>
</div>