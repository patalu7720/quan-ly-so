<div class="container" style="margin-top: 10px">

    @include('component.theo_doi_tksx_dty.create')
    @include('component.theo_doi_tksx_dty.edit')
    @include('component.theo_doi_tksx_dty.duyet')

    @php
        use Carbon\Carbon;
    @endphp
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="row">
                <div class="col">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="choCapNhat" wire:click="radioClick" wire:model="radioTongQuatChiTiet">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Chờ cập nhật thông tin
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="choDuyet"  wire:click="radioClick" wire:model="radioTongQuatChiTiet">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="daHoanTat"  wire:click="radioClick" wire:model="radioTongQuatChiTiet">
                        <label class="form-check-label" for="flexRadioDefault3">
                            Đã hoàn tất
                        </label>
                    </div>
                </div>
            </div>
        </div>
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
                                <div class="col-6 col-lg-2">
                                    <label class="form-label">Mã hàng</label>
                                    <input type="text" class="form-control" placeholder="Nhập mã hàng" wire:model.defer="maHangTimKiem">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Quy cách</label>
                                    <input type="text" class="form-control" placeholder="Nhập quy cách"  wire:model.defer="quyCachTimKiem">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên khách hàng"  wire:model.defer="tenKhachHangTimKiem">
                                </div>
                                <div class="col-6 col-lg-2">
                                    <label class="form-label">Nhà máy</label>
                                    <select name="" id="" class="form-select" wire:model.defer="nhaMayTimKiem">
                                        <option value="">Tất cả</option>
                                        <option value="TB2">TB2</option>
                                        <option value="TB3">TB3</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-primary float-end" style="margin-top: 28px" wire:click="timKiem">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('create_theo_doi_tksx')
                <button class="btn btn-primary float-end mx-2" data-bs-toggle="modal" data-bs-target="#createModal" wire:click="create">+ Thêm mới</button>
                <button class="btn btn-success float-end" wire:click="taiFile">Tải file</button>
            @endcan
        </div>
        <div class="col-12">
            <div class="shadow p-2 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-sm" style="width: 3000px">
                                <thead>
                                    <th>TKSX</th>
                                    <th>Máy</th>
                                    <th>Mã hàng</th>
                                    <th>Quy cách</th>
                                    <th>Đơn-chập</th>
                                    <th>Mã cũ-mới</th>
                                    <th>Line POY</th>
                                    <th>Mã POY</th>
                                    <th>KH</th>
                                    <th style="width: 400px">Yêu cầu KH</th>
                                    <th style="width: 400px">Điều kiện KH</th>
                                    <th>Khối lượng</th>
                                    <th>Ngày QA ký TK</th>
                                    <th>Ngày TK</th>
                                    <th>Ngày SX chính thức</th>
                                    <th>Ngày kiểm tra TSKT</th>
                                    <th>Ngày QC gửi TSKT</th>
                                    <th></th>
                                    <th>Kết quả</th>
                                    <th>Người tạo</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach (session('main') as $item)
                                        <tr>
                                            <td>{{ $item->tksx }}</td>
                                            <td>{{ $item->may }}</td>
                                            <td>{{ $item->ma_hang }}</td>
                                            <td>{{ $item->quy_cach }}</td>
                                            <td>{{ $item->don_chap }}</td>
                                            <td>{{ $item->ma_cu_moi }}</td>
                                            <td>{{ $item->line_poy }}</td>
                                            <td>{{ $item->ma_poy }}</td>
                                            <td>{{ $item->khach_hang }}</td>
                                            <td>{{ $item->yeu_cau_khach_hang }}</td>
                                            <td>{{ $item->dieu_kien_khach_hang }}</td>
                                            <td>{{ $item->khoi_luong }}</td>
                                            <td>{{ Carbon::create($item->ngay_qa_ky_tk)->isoFormat('DD-MM-YYYY') }}</td>
                                            <td>{{ Carbon::create($item->ngay_tk)->isoFormat('DD-MM-YYYY') }}</td>
                                            <td>{{ $item->ngay_sx_chinh_thuc ? Carbon::create($item->ngay_sx_chinh_thuc)->isoFormat('DD-MM-YYYY') : ''}}</td>
                                            <td>{{ $item->ngay_kiem_tra_tskt ? Carbon::create($item->ngay_kiem_tra_tskt)->isoFormat('DD-MM-YYYY') : ''}}</td>
                                            <td>{{ $item->ngay_qc_gui_tskt ? Carbon::create($item->ngay_qc_gui_tskt)->isoFormat('DD-MM-YYYY') : ''}}</td>
                                            @if ($item->status == 'Đã cập nhật' || $item->status == 'Đã duyệt')
                                                <td>
                                                    <a href="" wire:click.prevent="download('{{ $item->id }}', '{{ $item->file }}')">{{ $item->file }}</a>
                                                </td>
                                            @else  
                                                <td></td>
                                            @endif
                                            <td>{{ $item->ket_qua }}</td>
                                            <td>{{ $item->created_user }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-sharp fa-solid fa-bars"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($item->status == 'Thêm mới')
                                                            <li><a class="dropdown-item" wire:click="edit('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i> Cập nhật</a></li>
                                                        @elseif ($item->status == 'Đã cập nhật')
                                                            <li><a class="dropdown-item" wire:click="duyetModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#duyetModal"><i class="fa-solid fa-pencil"></i> Duyệt</a></li>
                                                        @endif
        
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
