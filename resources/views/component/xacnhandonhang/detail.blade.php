<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="detailXNDHModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Chi tiết phiếu XNĐH</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
            </div>
            <div class="modal-body">
                @if ($state == 'detail')
                    <div class="row mb-2">
                        <div class="col-6">
                            <p>Số phiếu : {{ $soPhieu }}</p>
                        </div>
                        <div class="col-6">
                            <p>Loại : {{ $loai == 'nd' ? 'Nội địa' : 'Xuất khẩu' }}</p>
                        </div>
                    </div>
                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                        <table class="table">
                            <thead>
                                <th>Quy cách</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                            </thead>
                            <tbody>
                                @foreach ($danhSachQuyCach as $item)
                                    <tr>
                                        <td>{{ $item->quy_cach }}</td>
                                        <td>{{ $item->so_luong }}</td>
                                        <td>{{ $item->don_gia }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Ngày : {{ $ngay }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Bên A : {{ $benA }}</p>
                        </div>
                        <div class="col-12">
                            <p>Địa chỉ A : {{ $diaChiBenA }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Bên B : {{ $benB }}</p>
                        </div>
                        <div class="col-12">
                            <p>Địa chỉ B : {{ $diaChiBenB }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Incoterm : {{ $incoterm }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Thời gian giao hàng : {{ $thoiGianGiaoHang }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Xuất xứ : {{ $xuatXu }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Đóng gói : {{ $dongGoi }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Hình thức thanh toán : {{ $hinhThucThanhToan }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Thời gian thanh toán : {{ $thoiGianThanhToan }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Địa điểm giao hàng : {{ $diaDiemGiaoHang }}</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Ghi chú : {{ $ghiChu }}</p>
                        </div>
                    </div>
                    <div class="shadow p-3 bg-body-tertiary rounded">
                        @if ($log != null)
                            <div class="row">
                                <div class="table-responsive caption-top">
                                    <caption>Lịch sử</caption>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>
                                                Trạng thái
                                            </td>
                                            <th>
                                                Trạng thái Log
                                            </td>
                                            <th>
                                                Username
                                            </td>
                                            <th>
                                                Thời gian
                                            </td>
                                        </thead>
                                        <tbody>
                                            @foreach ($log as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->status }}
                                                    </td>
                                                    <td>
                                                        {{ $item->status_log }}
                                                    </td>
                                                    <td>
                                                        {{ $item->updated_user }}
                                                    </td>
                                                    <td>
                                                        {{ $item->updated_at }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField">Đóng</button>
            </div>
        </div>
    </div>
</div>