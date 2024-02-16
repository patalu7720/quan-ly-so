<style>
    label{
        font-weight:600;
    }
</style>
<div class="row">
    <div class="col">
      <div wire:ignore.self class="modal" id="viewPhieuTKSXFDYModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Xem phiếu thông báo thay đổi mã hàng FDY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
              </div>
              <div class="modal-body">
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
                                Finish <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
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
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Line : </p>
                            <p class="card-text d-inline">{{ $line }}</p>
                        </div>
                        <div class="col-12">
                            <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                            <p class="card-text d-inline">{{ $thongTinDoiMa }}</p>
                        </div>
                        <div class="col-12">
                            <p class="fw-semibold d-inline">Ngày dự định thay đổi : </p>
                            <p class="card-text d-inline">{{ $ngayDuDinhThayDoi }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Quy cách cũ : </p>
                            <p class="card-text d-inline">{{ $quyCachCu }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Quy cách mới : </p>
                            <p class="card-text d-inline">{{ $quyCachMoi }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Lot cũ : </p>
                            <p class="card-text d-inline">{{ $lotCu }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Lot mới : </p>
                            <p class="card-text d-inline">{{ $lotMoi }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Trọng Lượng : </p>
                            <p class="card-text d-inline">{{ $trongLuong1 }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Trọng Lượng : </p>
                            <p class="card-text d-inline">{{ $trongLuong2 }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Màu ống : </p>
                            <p class="card-text d-inline">{{ $mauOng1 }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Màu ống : </p>
                            <p class="card-text d-inline">{{ $mauOng2 }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Chip : </p>
                            <p class="card-text d-inline">{{ $chip1 }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Chip : </p>
                            <p class="card-text d-inline">{{ $chip2 }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Dầu : </p>
                            <p class="card-text d-inline">{{ $dau1 }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Dầu : </p>
                            <p class="card-text d-inline">{{ $dau2 }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Đoạn : </p>
                            <p class="card-text d-inline">{{ $doan1 }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Đoạn : </p>
                            <p class="card-text d-inline">{{ $doan2 }}</p>
                        </div>

                        <div class="col-12">
                            <p class="fw-semibold d-inline">Thông tin khác : </p>
                            <p class="card-text d-inline">{{ $thongTinKhac }}</p>
                        </div>

                        <div class="col-6">
                            <p class="fw-semibold d-inline">Khách hàng : </p>
                            <p class="card-text d-inline">{{ $khachHang }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Số lượng : </p>
                            <p class="card-text d-inline">{{ $soLuong }}</p>
                        </div>

                        <div class="col-12">
                            <p class="fw-semibold d-inline">Ghi chú : </p>
                            <p class="card-text d-inline">{{ $ghiChu }}</p>
                        </div>

                        <div class="col-12">
                            <p class="fw-semibold d-inline">QA kiến nghị : </p>
                            <p class="card-text d-inline">{{ $qaKienNghi }}</p>
                        </div>
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
              </div>
            </div>
        </div>
    </div>
    </div>
  </div>