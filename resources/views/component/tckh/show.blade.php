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
                                        <label for="">Mã khách hàng</label>
                                        <p>{{ $tieuChuanKhachHangModel['ma_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tên khách hàng</label>
                                        <p>{{ $tieuChuanKhachHangModel['ten_khach_hang'] }}</p>
                                    </div>
                                    <hr>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label for="">Loại máy dệt</label>
                                        <p>{{ $tieuChuanKhachHangModel['loai_may_det'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Quy cách sợi</label>
                                        <p>{{ $tieuChuanKhachHangModel['quy_cach_soi'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Chủng loại sợi</label>
                                        <p>{{ $tieuChuanKhachHangModel['chung_loai_soi'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Chip của lot DTY/FDY tham chiếu</label>
                                        <p>{{ $tieuChuanKhachHangModel['chip'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Khách hàng chỉ định Chip</label>
                                        <p>{{ $tieuChuanKhachHangModel['khach_hang_chi_dinh_chip'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Lot tham chiếu TKSX</label>
                                        <p>{{ $tieuChuanKhachHangModel['lot'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Twist</label>
                                        <p>{{ $tieuChuanKhachHangModel['twist'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Denier</label>
                                        <p>{{ $tieuChuanKhachHangModel['denier'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tenacity (g/d)</label>
                                        <p>{{ $tieuChuanKhachHangModel['tenacity'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Elongation (%)</label>
                                        <p>{{ $tieuChuanKhachHangModel['elongation'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">DTY-BWS (%)
                                            FDY-Oil pick %</label>
                                        <p>{{ $tieuChuanKhachHangModel['dty_bws'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">DTY-CR (%)
                                            FDY-U%</label>
                                        <p>{{ $tieuChuanKhachHangModel['dty_cr'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">DTY-CC(%)
                                            FDY-BWS (%)</label>
                                        <p>{{ $tieuChuanKhachHangModel['dty_cc'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">DTY-Oil pick %
                                            FDY-Knots/m</label>
                                        <p>{{ $tieuChuanKhachHangModel['dty_oil_pick'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">DTY-Knots/m
                                            FDY-Ti02</label>
                                        <p>{{ $tieuChuanKhachHangModel['dty_knots'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Stability(%)</label>
                                        <p>{{ $tieuChuanKhachHangModel['stability'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Ti02/Masterbatch</label>
                                        <p>{{ $tieuChuanKhachHangModel['ti02'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Times (torque/ meter) (s)</label>
                                        <p>{{ $tieuChuanKhachHangModel['times'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Torque/ meter</label>
                                        <p>{{ $tieuChuanKhachHangModel['torque'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Yêu cầu tem, đóng gói</label>
                                        <p>{{ $tieuChuanKhachHangModel['yeu_cau_tem'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Thông tin khác</label>
                                        <p>{{ $tieuChuanKhachHangModel['thong_tin_khac'] }}</p>
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
                                                    @foreach ($tieuChuanKhachHangLog as $item)
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