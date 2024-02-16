<div class="container">
    @include('component.so_tam.add')
    <div class="row py-1">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="timKiem">
                        <div class="row">
                            <div class="col-6 col-lg-5">
                                <label for="" class="form-label">Số SO tạm</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập số SO" wire:model.defer="soTimKiem">
                            </div>
                            <div class="col-6 col-lg-5">
                                <label for="" class="form-label">Khách hàng</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập tên khách hàng" wire:model.defer="khachHangTimKiem">
                            </div>
                            <div class="col-12 col-lg-2">
                                <button class="btn btn-outline-primary btn-sm" style="margin-top: 28px">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-1">
        <div class="col-12">
            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal" wire:click="create">+ Thêm mới</button>
        </div>
    </div>
    <div class="row py-1">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <th>Số SO tạm</th>
                            <th>Mã khách hàng</th>
                            <th>Khách hàng</th>
                            <th>Số XXĐH (nếu có)</th>
                            <th>Số TKSX (nếu có)</th>
                            <th>Người tạo</th>
                        </thead>
                        <tbody>
                            @if (session('main') != null)
                                @foreach (session('main') as $item)
                                    <tr>
                                        <td>{{ $item->so_tam }}</td>
                                        <td>{{ $item->ma_khach_hang }}</td>
                                        <td>{{ $item->ten_khach_hang }}</td>
                                        <td>{{ $item->so_phieu_xxdh }}</td>
                                        <td>{{ $item->so_phieu_tksx }}</td>
                                        <td>{{ $item->created_user }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
