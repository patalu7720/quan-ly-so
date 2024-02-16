<div class="container">
    <form action="" wire:submit.prevent="upFile">
        <div wire:ignore.self class="modal" id="upFileModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Up File TC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn File</label>
                        <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" wire:model="file" multiple required>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Mã Khách hàng</label>
                            @if ($listKhachHang != null)
                                <input class="form-control" list="datalistOptions1" placeholder="Nhập tên khách hàng" wire:model="khachHang" required>
                                <datalist id="datalistOptions1">
                                    @foreach ($listKhachHang as $item)
                                        <option value="{{ $item->ma_khach_hang }}">{{ $item->ten_tv ?? $item->ten_ta }}</option>
                                    @endforeach
                                </datalist>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Hợp đồng</label>
                            @if ($listHopDong != null)
                                    <input class="form-control" list="datalistOptions2" placeholder="Nhập số Hợp đồng" wire:model.defer="hopDong" required>
                                    <datalist id="datalistOptions2">
                                        @foreach ($listHopDong as $item)
                                            <option>{{ $item->sohd_new }}</option>
                                        @endforeach
                                    </datalist>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
            </div>
            </div>
        </div>
    </form>
    <div class="row mb-3 g-2" style="margin-top: 15px">
        <div class="col-12 collapse" id="collapseExample">
            <div class="card card-body">
                <div class="row g-2 mb-3">
                    <div class="col-12 col-lg-4">
                        <label for="" class="form-label">Mã khách hàng</label>
                        <input type="text" placeholder="Mã khách hàng" class="form-control form-control-sm" wire:model.defer="maKhachHangTimKiem">
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="" class="form-label">Khách hàng</label>
                        <input type="text" placeholder="Khách hàng" class="form-control form-control-sm" wire:model.defer="khachHangTimKiem">
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="" class="form-label">Số hợp đồng</label>
                        <input type="text" placeholder="Số hợp đồng" class="form-control form-control-sm" wire:model.defer="soHopDongTimKiem">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-outline-primary btn-sm float-end" wire:click.prevent="timKiem">Tìm kiếm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary btn-sm float-end" wire:click.prevent="upFileModal" data-bs-toggle="modal" data-bs-target="#upFileModal">+ Thêm mới</button>
            <button class="btn btn-outline-secondary btn-sm float-end mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="shadow p-3 bg-body-tertiary rounded">
                <div class="row mb-3">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <th>Mã khách hàng</th>
                                <th>Khách hàng</th>
                                <th>Hợp đồng</th>
                                <th>File</th>
                                <th>Người thao tác</th>
                                <th>Thời gian</th>
                            </thead>
                            <tbody>
                                @foreach (session('main') as $item)
                                    <tr>
                                        <td>
                                            {{ $item->ma_khach_hang }}
                                        </td>
                                        <td>
                                            {{ $item->ten_tv ?? $item->ten_ta }}
                                        </td>
                                        <td>
                                            {{ $item->hop_dong }}
                                        </td>
                                        <td>
                                            @php
                                                $list_file = explode(',', $item->file);
                                            @endphp
                                            @foreach ($list_file as $file)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->hop_dong }}','{{ $file }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$file) }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $item->created_user }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
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
