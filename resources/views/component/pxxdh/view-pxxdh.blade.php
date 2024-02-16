<style>
    label{
        font-weight:600;
    }
    input[type='checkbox'][readonly]{
    pointer-events: none;}
</style>
@php
    use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col">
      <div wire:ignore.self class="modal" id="viewPhieuXXDHModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết phiếu xem xét đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'view')
                        <div class="row">
                            <div class="col-4">
                                @if ($donHangSXMoi == '1')
                                    @if (strlen($soSO) < 12)
                                        @if ($status == 'New')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'Sale APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'QA REQUESTED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'KHST APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'QA APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'Finish')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-success" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if ($status == 'New')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'Sale APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'SM APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'QA REQUESTED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'KHST APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'ADMIN APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'QA APPROVED')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($status == 'Finish')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        SM APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA REQUESTED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-secondary p-2" role="alert">
                                                        ADMIN APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-success p-2" role="alert">
                                                        Finish<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    @if ($status == 'New')
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    Sale APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($status == 'Sale APPROVED')
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    QA APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($status == 'QA APPROVED')
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    KHST APPROVED<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($status == 'KHST APPROVED')
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-secondary p-2" role="alert">
                                                    Finish<i class="fa-solid fa-circle-minus" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($status == 'Finish')
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    New<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    Sale APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    QA APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    KHST APPROVED<i class="fa-solid fa-circle-check" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="alert alert-success p-2" role="alert">
                                                    Finish<i class="fa-solid fa-circle-success" style="margin-left: 20px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-8">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="dht" wire:model.defer="loaiDonHang" readonly>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Đơn hàng thường
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="dhm" wire:model.defer="loaiDonHang" readonly>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        Đơn hàng mẫu
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="donHangGRS" wire:model.defer="donHangGRS" readonly>
                                                            <label class="form-check-label" for="donHangGRS">
                                                                Đơn hàng GRS
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="donHangNonGRS" wire:model.defer="donHangNonGRS" readonly>
                                                            <label class="form-check-label" for="donHangNonGRS">
                                                                Đơn hàng Non GRS
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="donHangSXMoi" wire:model.defer="donHangSXMoi" readonly>
                                                            <label class="form-check-label" for="donHangSXMoi">
                                                                Đơn hàng SX mới 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="donHangLapLai" wire:model.defer="donHangLapLai" readonly>
                                                            <label class="form-check-label" for="donHangLapLai">
                                                                Đơn hàng lặp lại 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="donHangTonKho" wire:model.defer="donHangTonKho" readonly>
                                                            <label class="form-check-label" for="donHangTonKho">
                                                                Đơn hàng t.kho
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="fw-semibold d-inline">Date : </p>
                                                        <p class="card-text d-inline">{{ $date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <p class="fw-semibold d-inline">Tên công ty : </p>
                                                        <p class="card-text d-inline">{{ $tenCongTy }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="fw-semibold d-inline">Số SO : </p>
                                                        <a href="http://quanly.soitheky.com.vn/so?search={{ $soSO }}" target="_blank" rel="noopener noreferrer">{{$soSO}}</a>
                                                        {{-- <p class="card-text d-inline">{{ $soSO }}</p> --}}
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="fw-semibold d-inline">Số HĐ : </p>
                                                        <p class="card-text d-inline">{{ $soHD }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <hr>
                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                        <div class="row mb-3 g-3">
                            <div class="col-12">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách - Sale</h5>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @if ($quyCachPhieuXXDH!=null)
                                                @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link{{ $index == 0 ? ' active' : '' }}" id="tab1_{{ $item->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab1_{{ $item->id }}-tab-pane" type="button" role="tab" aria-controls="tab1_{{ $item->id }}-tab-pane" aria-selected="true">{{ 'Quy cách ' . (int)$index + 1 }}</button>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @if ($quyCachPhieuXXDH!=null)
                                                @foreach ($quyCachPhieuXXDH as $index=>$item)
                                                    <div class="tab-pane fade{{ $index == 0 ? ' show active' : '' }}" id="tab1_{{ $item->id }}-tab-pane" role="tabpanel" aria-labelledby="tab1_{{ $item->id }}-tab" tabindex="0">
                                                        <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                            <p>Quy cách : {{ $item->quy_cach }}</p>
                                                            <p>Số lượng : {{ $item->so_luong }}</p>
                                                            <div>
                                                                @if ($donHangSXMoi == 1)
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <label class="form-label" style="color: blue">{{ $item->lich_du_kien == 0 ? 'Chưa có lịch dự kiến' : 'Đã có lịch dự kiến' }}</label>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="row mb-2">
                                                                    <div class="col-5">
                                                                        <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        @if ($item->lot_chinh_thuc == null)
                                                                            <label class="form-label">Lot : {{ $item->lot }}</label>
                                                                        @else
                                                                            <label class="form-label">Lot : {{ $item->lot }} - Lot chính thức : {{ $item->lot_chinh_thuc }}</label>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-5">
                                                                        <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                        {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                        {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-5">
                                                                        <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                        {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                        {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-5">
                                                                        <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                        {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                        {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="row mb-2">
                                                                    <div class="col">
                                                                        <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col">
                                                                        <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="row mb-2">
                                                                    <div class="col">
                                                                        <label class="form-label">Thông tin đóng gói : {{ $item->thong_tin_dong_goi }}</label>
                                                                        {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                        {{-- <input class="form-control" list="datalistThongTinDongGoi" placeholder="Nhập thông tin đóng gói" wire:model.defer = "thongTinDongGoi.{{ $item->id }}">
                                                                        <datalist id="datalistThongTinDongGoi">
                                                                            @if ($listThongTinDongGoi != null)
                                                                                @foreach ($listThongTinDongGoi as $item1)
                                                                                    <option value="{{ $item1->thong_tin_dong_goi }}"></option>
                                                                                @endforeach
                                                                            @endif
                                                                        </datalist> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col">
                                                                        <label class="form-label">Pallet : {{ $item->pallet }}</label>
                                                                        {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                        {{-- <input class="form-control" list="datalistPallet" placeholder="Nhập Pallet" wire:model.defer = "pallet.{{ $item->id }}">
                                                                        <datalist id="datalistPallet">
                                                                            @if ($listPallet != null)
                                                                                @foreach ($listPallet as $item2)
                                                                                    <option value="{{ $item2->pallet }}"></option>
                                                                                @endforeach
                                                                            @endif
                                                                        </datalist> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col">
                                                                        <label class="form-label">Recycle : {{ $item->recycle }}</label>
                                                                        {{-- <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea> --}}
                                                                        {{-- <input class="form-control" list="datalistRecycle" placeholder="Nhập Recycle" wire:model.defer = "recycle.{{ $item->id }}">
                                                                        <datalist id="datalistRecycle">
                                                                            @if ($listRecycle != null)
                                                                                @foreach ($listRecycle as $item3)
                                                                                    <option value="{{ $item3->recycle }}"></option>
                                                                                @endforeach
                                                                            @endif
                                                                        </datalist> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card text-bg-light">
                                    <h5 class="card-header">Quy cách thực tế - KHST</h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="width:30px">#</th>
                                                    <th scope="col">Quy cách</th>
                                                    <th scope="col">Số lượng (kg)</th>
                                                    <th scope="col">Lot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($quyCachPhieuXXDHKHST != null)
                                                        @foreach ($quyCachPhieuXXDHKHST as $item)
                                                            <tr>
                                                                <th class="counterCell"></td>
                                                                <td>{{ $item->quy_cach }}</td>
                                                                <td>{{ $item->so_luong }}</td>
                                                                <td>{{ $item->lot }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <label for="">Phân bổ</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_cc_view" wire:model.defer="cbCC" readonly>
                                        <label class="form-check-label">CC</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb2_view" wire:model.defer="cbTB2" readonly>
                                        <label class="form-check-label">TB2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cb_tb3_view" wire:model.defer="cbTB3" readonly>
                                        <label class="form-check-label">TB3</label>
                                    </div>
                                </div> 
                            </div>
                            {{-- <div class="col-6">
                                <p class="fw-semibold d-inline">Số cone : </p>
                                <p class="card-text d-inline">{{ $soCone }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Số kg/cone : </p>
                                <p class="card-text d-inline">{{ $soKgCone }}</p>
                            </div> --}}
                            @if ($qaKienNghi != '')
                                <div class="col-12">
                                    <p class="fw-semibold d-inline">QA kiến nghị : </p>
                                    <p class="card-text d-inline">{{ $qaKienNghi }}</p>
                                </div>
                            @endif
                            {{-- <div class="col-6">
                                <p class="fw-semibold d-inline">Nơi sản xuất dự kiến - Line : </p>
                                <p class="card-text d-inline">{{ $Line }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Máy : </p>
                                <p class="card-text d-inline">{{ $May }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Ngày giao hàng : </p>
                                <p class="card-text d-inline">{{ $ngayGiaoHang }}</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-semibold d-inline">Ngày bắt đầu giao (nếu có) : </p>
                                <p class="card-text d-inline">{{ $ngayBatDauGiao }}</p>
                            </div> --}}
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Thành phẩm của khách hàng : </p>
                                <p class="card-text d-inline">{{ $thanhPhamCuaKhachHang }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Phản ánh của khách hàng về lot cũ đã đặt hàng : </p>
                                <p class="card-text d-inline">{{ $phanAnhCuaKhachHang }}</p>
                            </div>
                            {{-- <div class="col-12">
                                <p class="fw-semibold d-inline">Thông tin đóng gói : </p>
                                <p class="card-text d-inline">{{ $thongTinDongGoi }}</p>
                            </div> --}}
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Phản hồi của KHST : </p>
                                <p class="card-text d-inline">{{ $phanHoiKHST }}</p>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold d-inline">Phản hồi của QA : </p>
                                <p class="card-text d-inline">{{ $phanHoiQA }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="shadow p-3 bg-body-tertiary rounded">
                        @if ($log != null)
                            <div class="row">
                                <div class="table-responsive caption-top">
                                    <caption>Lịch sử</caption>
                                    <table class="table table-striped" style="width: 900px">
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
                                                        {{ $item->status == 'Confirm' ? 'Xác nhận đã phân bổ' : $item->status }}
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
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif 
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>