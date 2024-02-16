<div class="row">
    @php
        use Carbon\Carbon;
    @endphp
    <div class="col">
        <div wire:ignore.self class="modal" id="chiTietModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Chi tiết mô phỏng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
                    </div>
                    <div class="modal-body">
                        @if ($state == 'chiTiet')
                            @if ($danhSachMoPhong->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped text-center table-sm" style="width: 1300px">
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
                                        <th>Người tạo</th>
                                        <th>Thời gian tạo</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($danhSachMoPhong as $item)
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
                                                <td>{{ $item->ket_qua_nhuom }}</td>
                                                <td>{{ $item->created_user }}</td>
                                                <td>{{ $item->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @else
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>