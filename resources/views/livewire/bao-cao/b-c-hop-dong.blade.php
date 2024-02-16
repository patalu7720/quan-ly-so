<div class="container">
    <div class="row py-3 g-2">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Tìm kiếm
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Nhân viên</label>
                                <select name="" id="" class="form-select" wire:model.defer="saleAdmin">
                                    <option value="">Chọn nhân viên</option>
                                    @foreach ($danhSachSaleAdmin as $item)
                                        <option value="{{ $item->username }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" wire:model.defer="tuNgay">
                            </div>
                            <div class="col">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" wire:model.defer="denNgay">
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" style="margin-top: 27px" wire:click="timKiem">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($state == 'timKiem')
        <div class="row mb-3 g-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Dữ liệu của Phòng KD
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <p class="d-inline fw-bold">Tổng HĐ : </p>
                                <p class="d-inline fw-bold">{{ $danhSachHopDongTatCa->sum('total') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        @foreach ($danhSachHopDongTatCa as $item)
                                            <th>
                                                @if ($item->loaihopdong == '1')
                                                    {{ 'Nội địa' }}
                                                @elseif ($item->loaihopdong == '2')
                                                    {{ 'Nội địa S.N' }}
                                                @elseif ($item->loaihopdong == '3')
                                                    {{ 'XKTC T.A' }}
                                                @elseif ($item->loaihopdong == '4')
                                                    {{ 'XKTC S.N' }}
                                                @elseif ($item->loaihopdong == '5')
                                                    {{ 'XKTT' }}
                                                @endif
                                            </th>
                                        @endforeach
                                    </thead>
                                    <tbody>
                                        @foreach ($danhSachHopDongTatCa as $item)
                                            <td>{{ $item->total }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Dữ liệu của <p class="d-inline fw-bold">{{ $saleAdmin }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    @foreach ($danhSachHopDongCaNhan as $item)
                                        <th>
                                            @if ($item->loaihopdong == '1')
                                                {{ 'Nội địa' }}
                                            @elseif ($item->loaihopdong == '2')
                                                {{ 'Nội địa S.N' }}
                                            @elseif ($item->loaihopdong == '3')
                                                {{ 'XKTC T.A' }}
                                            @elseif ($item->loaihopdong == '4')
                                                {{ 'XKTC S.N' }}
                                            @elseif ($item->loaihopdong == '5')
                                                {{ 'XKTT' }}
                                            @endif
                                        </th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach ($danhSachHopDongCaNhan as $item)
                                        <td>{{ $item->total }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
