<div class="container" style="margin-top: 10px">

    @include('component.mo_phong.cap-nhat')
    @include('component.mo_phong.chi-tiet')
    @include('component.mo_phong.ket-thuc-mo-phong')
    @include('component.mo_phong.delete')

    @php
        use Carbon\Carbon;
    @endphp
    <div class="row mb-2">
        <div class="col">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="tongQuat" wire:click="radioClick" wire:model.defer="radioTongQuatChiTiet">
                <label class="form-check-label" for="flexRadioDefault1">
                    Tổng quát
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="chiTiet"  wire:click="radioClick" wire:model.defer="radioTongQuatChiTiet">
                <label class="form-check-label" for="flexRadioDefault2">
                    Chi tiết
                </label>
            </div>
        </div>
    </div>
    @if ($radioTongQuatChiTiet == 'tongQuat')
        <div class="row mb-3">
            <div class="col">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Khung tìm kiếm tổng quát
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <label class="form-label">Số TKSX</label>
                                        <input type="text" class="form-control" placeholder="Nhập số TKSX"  wire:model.defer="soTKSXTimKiem">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Mã</label>
                                        <input type="text" class="form-control" placeholder="Nhập mã" wire:model.defer="maTimKiem">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Quy cách</label>
                                        <input type="text" class="form-control" placeholder="Nhập quy cách" wire:model.defer="quyCachTimKiem">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Trạng thái</label>
                                        <select name="" id="" class="form-select" wire:model.defer="trangThaiTimKiem">
                                            <option value='0'>Chưa kết thúc mã</option>
                                            <option value="1">Đã kết thúc mã</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Từ ngày</label>
                                        <input type="date" class="form-control" wire:model.debounce.500ms="tuNgay">
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Đến ngày</label>
                                        <input type="date" class="form-control" wire:model.debounce.500ms="denNgay">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary float-end" wire:click="timKiem">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow p-2 mb-3 bg-body-tertiary rounded">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-striped text-center caption-top table-sm">
                            <caption>Danh sách mã hàng</caption>
                            <thead>
                                <th>Số TKSX</th>
                                <th>Ngày tạo TKSX</td>
                                <th>Máy</th>
                                <th>Mã</th>
                                <th>Quy cách</th>
                                <th>Số lần mô phỏng</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach (session('main') as $item)
                                    <tr>
                                        <td>{{ $item->so_phieu }}</td>
                                        <td>{{ Carbon::create($item->created_at)->isoFormat('DD-MM-YYYY') }}</td>
                                        <td>{{ $item->may }}</td>
                                        <td>{{ $item->ma_dty }}</td>     
                                        <td>{{ $item->quy_cach_dty }}</td>    
                                        <td>
                                            @if ($item->number_row == 0)
                                                {{ '-' }}
                                            @else
                                                {{ $item->number_row }}
                                            @endif
                                        </td>
                                        <td>
                                            <a class="link-success" title="Cập nhật" href="" wire:click="capNhatModal('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#capNhatModal"><i class="fa-solid fa-pencil fa-xl"></i></a>&nbsp;
                                            <a href="" title="Xem chi tiết" wire:click="chiTiet('{{ $item->so_phieu }}')" data-bs-toggle="modal" data-bs-target="#chiTietModal"><i class="fa-regular fa-eye fa-xl"></i></a>&nbsp;
                                            <a class="link-danger" title="Kết thúc mô phỏng" href="" wire:click="ketThucMoPhongModal('{{ $item->so_phieu }}', '{{ $item->ma_dty }}')" data-bs-toggle="modal" data-bs-target="#ketThucMoPhongModal"><i class="fa-regular fa-circle-check fa-xl"></i></a>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-sharp fa-solid fa-bars"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" wire:click="capNhatModal('{{ $item->so_phieu }}', '{{ $item->quy_cach_dty }}', '{{ $item->ma_dty }}')" data-bs-toggle="modal" data-bs-target="#capNhatModal"><i class="fa-solid fa-pen-nib"></i> Cập nhật</a></li>
                                                </ul>
                                            </div> --}}
                                        </td>                                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-3">
            <div class="col">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Khung tìm kiếm chi tiết
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row g-2">
                                    <div class="col-3">
                                        <label class="form-label">Nhân viên</label>
                                        <select name="" id="" class="form-select" wire:model.defer="userTimKiem">
                                            <option value="">Tất cả</option>
                                            @foreach ($danhSachNhanVien as $item)
                                                <option value="{{ $item->username }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Số lưu kho</label>
                                        <input type="text" class="form-control" placeholder="Nhập số lưu kho"  wire:model.defer="soLuuKhoTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Mã</label>
                                        <input type="text" class="form-control" placeholder="Nhập mã" wire:model.defer="maTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Quy cách</label>
                                        <input type="text" class="form-control" placeholder="Nhập quy cách" wire:model.defer="quyCachTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Máy</label>
                                        <input type="text" class="form-control" placeholder="Nhập máy" wire:model.defer="mayTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Plant</label>
                                        <select name="" id="" class="form-select" wire:model.defer="plantTimKiem">
                                            <option value="">Tất cả</option>
                                            <option value="1100">1100</option>
                                            <option value="1200">1200</option>
                                            <option value="1301">1301</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Ngày sản xuất</label>
                                        <input type="date" class="form-control" wire:model.defer="ngaySanXuatTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Ngày dệt</label>
                                        <input type="date" class="form-control" wire:model.defer="ngayDetTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Kết quả nhuộm</label>
                                        <input type="text" class="form-control" placeholder="Nhập kết quả nhuộm" wire:model.defer="ketQuaNhuomTimKiem">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select name="" id="" class="form-select" wire:model.defer="trangThaiTimKiem">
                                            <option value='0'>Chưa kết thúc mã</option>
                                            <option value="1">Đã kết thúc mã</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="" class="form-label">Từ ngày</label>
                                        <input type="date" class="form-control" wire:model.debounce.500ms="tuNgay">
                                    </div>
                                    <div class="col-3">
                                        <label for="" class="form-label">Đến ngày</label>
                                        <input type="date" class="form-control" wire:model.debounce.500ms="denNgay">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary float-end" wire:click="timKiem">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button class="btn btn-success btn-sm float-end" wire:click="taiFile">Tải file</button>
            </div>
        </div>
        <div class="shadow p-2 mb-3 bg-body-tertiary rounded">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-striped text-center table-sm" style="width: 1500px">
                            <thead>
                                <th>Số lưu kho</th>
                                <th>Quy cách</th>
                                <th>Mã</th>
                                <th>Máy</th>
                                <th>Plant</th>
                                <th>Ngày sản xuất</th>
                                <th>Lần xuống giàn</th>
                                <th>Ngày trên TKSX</th>
                                <th>Ngày dệt</th>
                                <th>Kết quả nhuộm</th>
                                <th>Khách hàng</th>
                                <th>Người tạo</th>
                                <th>Thời gian tạo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach (session('main') as $item)
                                    <tr>
                                        <td>{{ $item->so_luu_kho }}</td>
                                        <td>{{ $item->quy_cach }}</td>
                                        <td>{{ $item->ma }}</td>
                                        <td>{{ $item->may }}</td>
                                        <td>{{ $item->plant }}</td>
                                        <td>{{ Carbon::create($item->ngay_san_xuat)->isoFormat('DD-MM-YYYY') }}</td>
                                        <td>{{ $item->lan_xuong_gian }}</td>
                                        <td>{{ Carbon::create($item->ngay_tren_tksx)->isoFormat('DD-MM-YYYY') }}</td>
                                        <td>{{ Carbon::create($item->ngay_det)->isoFormat('DD-MM-YYYY') }}</td>
                                        @if ($item->ket_qua_nhuom == 'OK')
                                            <td class="fw-bold" style="color: green">{{ $item->ket_qua_nhuom }}</td>
                                        @elseif($item->ket_qua_nhuom == 'SỌC NHẸ')
                                            <td class="fw-bold" style="color:coral">{{ $item->ket_qua_nhuom }}</td>
                                        @else
                                            <td class="fw-bold" style="color: red">{{ $item->ket_qua_nhuom }}</td>
                                        @endif
                                        <td>{{ $item->khach_hang }}</td>
                                        <td>{{ $item->created_user }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a class="dropdown-item" href="" style="color:red" wire:click="deleteModal('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-regular fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
