<style>
    input[type='checkbox'][readonly]{
    pointer-events: none;}
</style>
@php
    use Carbon\Carbon;
@endphp
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="detailPhieuTKSXModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Chi tiết phiếu TKSX</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
        </div>
        <div class="modal-body">
            @if ($state == 'detailPhieuTKSX')
            <div class="shadow mb-3 p-3 bg-body-tertiary rounded my-4">
                @if ($PhieuTKSXDTY->isNotEmpty())
                    @foreach ($PhieuTKSXDTY as $item)
                        @if (empty($item->sale))
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
                                @endif
                            </div>
                            <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                                <div class="row mb-3 g-3">
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số Phiếu : </p>
                                        <p class="card-text d-inline">{{ $item->so_phieu }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số Máy : </p>
                                        <p class="card-text d-inline">{{ $item->may }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                        <p class="card-text d-inline">{{ $item->quy_cach }}</p>
                                        <p class="card-text d-inline">{{ $item->ma }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ngày : </p>
                                        <p class="card-text d-inline">{{ $item->ngay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                        <p class="card-text d-inline">{{ $item->thong_tin_doi_ma }}</p>
                                    </div>
                                </div>
                        @else
                            <div class="row">
                                @if ($item->status == 'New')
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
                                @elseif ($item->status == 'KHST APPROVED')
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
                                @elseif ($item->status == 'QA APPROVED')
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
                                @elseif ($item->status == 'Sale APPROVED')
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
                                @elseif ($item->status == 'Finish')
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
                            <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                                <div class="row mb-3 g-3">
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số Phiếu : </p>
                                        <p class="card-text d-inline">{{ $item->so_phieu }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Số SO : </p>
                                        <p class="card-text d-inline">{{ $item->so }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số Máy : </p>
                                        <p class="card-text d-inline">{{ $item->may }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã hàng đang chạy : </p>
                                        <p class="card-text d-inline">{{ $item->quy_cach }}</p>
                                        <p class="card-text d-inline">{{ $item->ma }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ngày : </p>
                                        <p class="card-text d-inline">{{ $item->ngay }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                        <p class="card-text d-inline">{{ $item->thong_tin_doi_ma }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Màu ống : </p>
                                        <p class="card-text d-inline">{{ $item->mau_ong }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Sợi (Đơn/Chập) : </p>
                                        <p class="card-text d-inline">{{ $item->soi }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Mã cũ - mới : </p>
                                        <p class="card-text d-inline">{{ $item->ma_cu_moi }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Quy cách POY : </p>
                                        <p class="card-text d-inline">{{ $item->quy_cach_poy }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Mã POY : </p>
                                        <p class="card-text d-inline">{{ $item->ma_poy }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Quy cách DTY : </p>
                                        <p class="card-text d-inline">{{ $item->quy_cach_dty }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Mã DTY : </p>
                                        <p class="card-text d-inline">{{ $item->ma_dty }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Khách hàng : </p>
                                        <p class="card-text d-inline">{{ $item->khach_hang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Loại hàng : </p>
                                        <p class="card-text d-inline">{{ $item->loai_hang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Số lượng đơn hàng : </p>
                                        <p class="card-text d-inline">{{ $item->so_luong_don_hang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Ghi chú số lượng : </p>
                                        <p class="card-text d-inline">{{ $item->ghi_chu_so_luong }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">Điều kiện của khách hàng : </p>
                                        <p class="card-text d-inline">{{ $item->dieu_kien_khach_hang }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">QA kiến nghị : </p>
                                        <p class="card-text d-inline">{{ $item->qa_kien_nghi }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <hr>
                    <div class="shadow p-3 bg-body-tertiary rounded">
                        @if ($logPTKSXDTY != null)
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
                                        @foreach ($logPTKSXDTY as $item)
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
                @elseif ($PhieuTKSXFDY->isNotEmpty())
                    @foreach ($PhieuTKSXFDY as $item)
                        <div class="row">
                            @if ($item->status == 'New')
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
                            @elseif ($item->status == 'KHST APPROVED')
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
                            @elseif ($item->status == 'QA APPROVED')
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
                            @elseif ($item->status == 'Sale APPROVED')
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
                            @elseif ($item->status == 'Finish')
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
                                    <p class="card-text d-inline">{{ $item->so_phieu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Số SO : </p>
                                    <p class="card-text d-inline">{{ $item->so }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Line : </p>
                                    <p class="card-text d-inline">{{ $item->line }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Thông tin đổi mã : </p>
                                    <p class="card-text d-inline">{{ $item->thong_tin_doi_ma }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Ngày dự định thay đổi : </p>
                                    <p class="card-text d-inline">{{ $item->ngay_du_dinh_thay_doi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Quy cách cũ : </p>
                                    <p class="card-text d-inline">{{ $item->quy_cach_cu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Quy cách mới : </p>
                                    <p class="card-text d-inline">{{ $item->quy_cach_moi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Lot cũ : </p>
                                    <p class="card-text d-inline">{{ $item->lot_cu }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Lot mới : </p>
                                    <p class="card-text d-inline">{{ $item->lot_moi }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Trọng Lượng : </p>
                                    <p class="card-text d-inline">{{ $item->trong_luong_1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Trọng Lượng : </p>
                                    <p class="card-text d-inline">{{ $item->trong_luong_2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Màu ống : </p>
                                    <p class="card-text d-inline">{{ $item->mau_ong_1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Màu ống : </p>
                                    <p class="card-text d-inline">{{ $item->mau_ong_2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Chip : </p>
                                    <p class="card-text d-inline">{{ $item->chip_1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Chip : </p>
                                    <p class="card-text d-inline">{{ $item->chip_2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Dầu : </p>
                                    <p class="card-text d-inline">{{ $item->dau_1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Dầu : </p>
                                    <p class="card-text d-inline">{{ $item->dau_2 }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Đoạn : </p>
                                    <p class="card-text d-inline">{{ $item->doan_1 }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Đoạn : </p>
                                    <p class="card-text d-inline">{{ $item->doan_2 }}</p>
                                </div>
        
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Thông tin khác : </p>
                                    <p class="card-text d-inline">{{ $item->thong_tin_khac }}</p>
                                </div>
        
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Khách hàng : </p>
                                    <p class="card-text d-inline">{{ $item->khach_hang }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semibold d-inline">Số lượng : </p>
                                    <p class="card-text d-inline">{{ $item->so_luong }}</p>
                                </div>
        
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">Ghi chú : </p>
                                    <p class="card-text d-inline">{{ $item->ghi_chu }}</p>
                                </div>
        
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">QA kiến nghị : </p>
                                    <p class="card-text d-inline">{{ $item->qua_kien_nghi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="shadow p-3 bg-body-tertiary rounded">
                        @if ($logPTKSXFDY != null)
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
                                        @foreach ($logPTKSXFDY as $item)
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