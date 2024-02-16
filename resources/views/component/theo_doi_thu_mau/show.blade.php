<style>
    label{
        font-weight:600;
    }
    input[type='checkbox'][readonly]{
    pointer-events: none;}
</style>
<div class="row">
    <div class="col">
        <div wire:ignore.self class="modal" id="showModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Xem thông tin chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                    </div>
                    <div class="modal-body">
                        @if ($state == 'show')
                            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label for="">Số phiếu</label>
                                        <p>{{ $theoDoiThuMauModel['so_phieu'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Ngày</label>
                                        <p>{{ $theoDoiThuMauModel['ngay'] }}</p>
                                    </div>
                                    <hr>
                                    <div class="col-6">
                                        <label for="">Mã khách hàng</label>
                                        <p>{{ $theoDoiThuMauModel['ma_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tên khách hàng</label>
                                        <p>{{ $theoDoiThuMauModel['ten_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Địa chỉ</label>
                                        <p>{{ $theoDoiThuMauModel['dia_chi'] }}</p>
                                    </div>
                                    <hr>
                                    <div class="col-6">
                                        <label for="">Items</label>
                                        <p>{{ $theoDoiThuMauModel['loai_soi'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Lot No</label>
                                        <p>{{ $theoDoiThuMauModel['lot'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Quantity</label>
                                        <p>{{ $theoDoiThuMauModel['so_luong'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Delivery date</label>
                                        <p>{{ $theoDoiThuMauModel['ngay_giao'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Customer products</label>
                                        <p>{{ $theoDoiThuMauModel['san_pham_cua_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Customer Category</label>
                                        <p>{{ $theoDoiThuMauModel['phan_loai_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Textile machine</label>
                                        <p>{{ $theoDoiThuMauModel['may_det'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Textile Structure</label>
                                        <p>{{ $theoDoiThuMauModel['cau_truc_det'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Sample for free/selling </label>
                                        <p>{{ $theoDoiThuMauModel['trang_thai'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Potential Bulk Qty(kg)</label>
                                        <p>{{ $theoDoiThuMauModel['so_luong_tiem_nang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Forecast Season/Month for bulk order</label>
                                        <p>{{ $theoDoiThuMauModel['du_kien'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Sales suggestion (Bp.Kinh Doanh kiến nghị)</label>
                                        <p>{{ $theoDoiThuMauModel['sale_kien_nghi'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Customer Service suggestion(Bp.Phục Vụ Khách Hàng Kiến nghị)</label>
                                        <p>{{ $theoDoiThuMauModel['qa_kien_nghi'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Thông số KT:</label>
                                        <p>{{ $theoDoiThuMauModel['thong_so_ky_thuat'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Kết quả dệt vớ:</label>
                                        <p>{{ $theoDoiThuMauModel['ket_qua_det_vo'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Kết quả dệt vải:</label>
                                        <p>{{ $theoDoiThuMauModel['ket_qua_det_vai'] }}</p>
                                    </div>
                                    <hr>
                                    <div class="col-6">
                                        <label for="">Ngày giao hàng</label>
                                        <p>{{ $theoDoiThuMauModel['ngay_giao_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Ngày nhận vải mẫu</label>
                                        <p>{{ $theoDoiThuMauModel['ngay_nhan_vai_mau'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">K.quả thử mẫu</label>
                                        <p>{{ $theoDoiThuMauModel['ket_qua_thu_mau'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Đơn hàng thực tế</label>
                                        <p>{{ $theoDoiThuMauModel['don_hang_thuc_te'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Customer feeback - Phản hồi của KH</label>
                                        <p>{{ $theoDoiThuMauModel['phan_hoi_khach_hang'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <h5 class="card-header">Lịch sử</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Trạng thái</th>
                                                        <th scope="col">Người thực hiện</th>
                                                        <th scope="col">Thời gian</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($theoDoiThuMauLog as $item)
                                                        <tr>
                                                            <td>{{ $item->status }}</td>
                                                            <td>{{ $item->created_user }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>