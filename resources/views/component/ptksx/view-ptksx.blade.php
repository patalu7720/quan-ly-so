<style>
    label{
        font-weight:600;
    }
</style>
<div class="row">
    <div class="col">
      <div wire:ignore.self class="modal" id="viewPhieuMHDTYModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Xem phiếu thông báo thay đổi mã hàng DTY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
              </div>
              <div class="modal-body">
                @if (empty($sale))
                    <div class="row">
                        @if ($status == 'New')
                        <div class="col">
                            <div class="alert alert-success p-2" role="alert">
                                New <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-secondary p-2" role="alert">
                                KHST APPROVED <i class="fa-solid fa-circle-minus"></i>
                            </div>
                        </div>
                        @elseif ($status == 'KHST APPROVED')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        @elseif ($status == 'Reject')
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    New <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                        <div class="row mb-3 g-3">
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Số Phiếu : </p>
                                <p class="card-text d-inline">{{ $soPhieu }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Số Máy : </p>
                                <p class="card-text d-inline">{{ $soMay }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                <p class="card-text d-inline">{{ $quyCach }}</p>
                                <p class="card-text d-inline">{{ $maHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Ngày : </p>
                                <p class="card-text d-inline">{{ $ngay }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                            </div>
                        </div>
                @else
                    <div class="row">
                        @if ($status == 'New')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    QA APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Sale APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Finish<i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                        @elseif ($status == 'KHST APPROVED')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    QA APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Sale APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Finish <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                        @elseif ($status == 'QA APPROVED')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    QA APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Sale APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Finish <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                        @elseif ($status == 'Sale APPROVED')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    QA APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    Sale APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Finish <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                        @elseif ($status == 'SM APPROVED')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    QA APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    Sale APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-secondary p-2" role="alert">
                                    Finish <i class="fa-solid fa-circle-minus"></i>
                                </div>
                            </div>
                        @elseif ($status == 'Finish')
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    New  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    KHST APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    QA APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    Sale APPROVED  <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    SM APPROVED <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="alert alert-success p-2" role="alert">
                                    Finish <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                        <div class="row mb-3 g-3">
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Số Phiếu : </p>
                                <p class="card-text d-inline">{{ $soPhieu }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Số SO : </p>
                                <p class="card-text d-inline">{{ $soSO }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Số Máy : </p>
                                <p class="card-text d-inline">{{ $soMay }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                <p class="card-text d-inline">{{ $quyCach }}</p>
                                <p class="card-text d-inline">{{ $maHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Ngày : </p>
                                <p class="card-text d-inline">{{ $ngay }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Màu ống : </p>
                                <p class="card-text d-inline">{{ $mauOng }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Sợi (Đơn/Chập) : </p>
                                <p class="card-text d-inline">{{ $soi }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Mã cũ - mới : </p>
                                <p class="card-text d-inline">{{ $maCuMoi }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Quy cách POY : </p>
                                <p class="card-text d-inline">{{ $quyCachPOY }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Mã POY : </p>
                                <p class="card-text d-inline">{{ $maPOY }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Quy cách DTY : </p>
                                <p class="card-text d-inline">{{ $quyCachDTY }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Mã DTY : </p>
                                <p class="card-text d-inline">{{ $maDTY }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Khách hàng : </p>
                                <p class="card-text d-inline">{{ $tenCongTy }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Loại hàng : </p>
                                <p class="card-text d-inline">{{ $loaiHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Số lượng đơn hàng : </p>
                                <p class="card-text d-inline">{{ $soLuongDonHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Ghi chú số lượng : </p>
                                <p class="card-text d-inline">{{ $ghiChuSoLuong }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Điều kiện của khách hàng : </p>
                                <p class="card-text d-inline">{{ $dieuKienKhachHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">QA kiến nghị : </p>
                                <p class="card-text d-inline">{{ $qaKienNghi }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <hr>
                <div class="shadow p-3 bg-body-tertiary rounded">
                    @if ($log != null)
                    <div class="row">
                        <div class="table-responsive caption-top">
                            <caption>Lịch sử</caption>
                            <table class="table table-striped" style="width:800px">
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
                                    <th>
                                        Lý do từ chối
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
                                            <td>
                                                {{ $item->ly_do_rollback }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
              </div>
            </div>
        </div>
    </div>
    </div>
  </div>