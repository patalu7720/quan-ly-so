<style>
    input[type='checkbox'][readonly]{
    pointer-events: none;}
</style>
@php
    use Carbon\Carbon;
@endphp
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="detailPhieuXXDHModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Chi tiết phiếu XXĐH</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputField"></button>
        </div>
        <div class="modal-body">
            @if ($state == 'detailPhieuXXDH')
            <div class="row p-3">
                <div class="col-4">
                    @if ($phieuXXDH->loai == 'dht')
                        @if ($phieuXXDH->status == 'New')
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
                        @elseif ($phieuXXDH->status == 'Sale APPROVED')
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
                        @elseif ($phieuXXDH->status == 'SM APPROVED')
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
                        @elseif ($phieuXXDH->status == 'KHST APPROVED')
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
                        @elseif ($phieuXXDH->status == 'QA APPROVED')
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
                        @elseif ($phieuXXDH->status == 'Finish')
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
                        @if ($phieuXXDH->status == 'New')
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
                        @elseif ($phieuXXDH->status == 'Sale APPROVED')
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
                        @elseif ($phieuXXDH->status == 'SM APPROVED')
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
                        @elseif ($phieuXXDH->status == 'QA REQUESTED')
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
                        @elseif ($phieuXXDH->status == 'KHST APPROVED')
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
                        @elseif ($phieuXXDH->status == 'QA APPROVED')
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
                        @elseif ($phieuXXDH->status == 'Finish')
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
                </div>
                <div class="col-8">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" {{ $phieuXXDH->loai == 'dht' ? 'checked' : '' }} readonly>
                                        <label class="form-check-label">
                                            Đơn hàng thường
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" {{ $phieuXXDH->loai == 'dhm' ? 'checked' : '' }} readonly>
                                        <label class="form-check-label">
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
                                                <input class="form-check-input" type="checkbox" id="donHangGRS" {{ $phieuXXDH->don_hang_grs == '1' ? 'checked' : '' }} readonly>
                                                <label class="form-check-label">
                                                    Đơn hàng GRS
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangNonGRS" {{ $phieuXXDH->don_hang_non_grs == '1' ? 'checked' : '' }} readonly>
                                                <label class="form-check-label">
                                                    Đơn hàng Non GRS
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangSXMoi" {{ $phieuXXDH->don_hang_sx_moi == '1' ? 'checked' : '' }} readonly>
                                                <label class="form-check-label">
                                                    Đơn hàng SX mới 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangLapLai" {{ $phieuXXDH->don_hang_lap_lai == '1' ? 'checked' : '' }} readonly>
                                                <label class="form-check-label">
                                                    Đơn hàng lặp lại 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="donHangTonKho" {{ $phieuXXDH->don_hang_ton_kho == '1' ? 'checked' : '' }} readonly>
                                                <label class="form-check-label">
                                                    Đơn hàng t.kho
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="fw-semibold d-inline">Date : </p>
                                            <p class="card-text d-inline">{{ $phieuXXDH->date }}</p>
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
                                            <p class="card-text d-inline">{{ $phieuXXDH->ten_cong_ty }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="fw-semibold d-inline">Số SO : </p>
                                            <p class="card-text d-inline">{{ $phieuXXDH->so }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="fw-semibold d-inline">Số HĐ : </p>
                                            <p class="card-text d-inline">{{ $phieuXXDH->hop_dong }}</p>
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
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label class="form-label">Kiểu máy dệt : {{ $item->kieu_may_det }}</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label">Lot : {{ $item->lot }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label for="soCone" class="form-label">Số cone : {{ $item->so_cone }}</label>
                                                                {{-- <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone.{{ $item->id }}"> --}}
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="soKgCone" class="form-label">Số kg/cone : {{ $item->so_kg_cone }}</label>
                                                                {{-- <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone.{{ $item->id }}"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line : {{ $item->line }}</label>
                                                                {{-- <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line.{{ $item->id }}"> --}}
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="May" class="form-label">Máy : {{ $item->may }}</label>
                                                                {{-- <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May.{{ $item->id }}"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label for="ngayGiaoHang" class="form-label">Ngày giao hàng : {{ $item->ngay_giao_hang != '' ? Carbon::create($item->ngay_giao_hang)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                {{-- <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang.{{ $item->id }}"> --}}
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có)  : {{ $item->ngay_bat_dau_giao != '' ? Carbon::create($item->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY') : '' }}</label>
                                                                {{-- <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao.{{ $item->id }}"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng : {{ $item->thanh_pham_cua_khach_hang }}</label>
                                                                {{-- <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang.{{ $item->id }}"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : {{ $item->phan_anh_cua_khach_hang }}</label>
                                                                {{-- <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang.{{ $item->id }}"></textarea> --}}
                                                            </div>
                                                        </div>
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
                                <input class="form-check-input" type="checkbox" id="cb_cc_view" {{ $phieuXXDH->phan_bo_cc != '' ? 'checked' : '' }} readonly>
                                <label class="form-check-label">CC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cb_tb2_view" {{ $phieuXXDH->phan_bo_tb2 != '' ? 'checked' : '' }} readonly>
                                <label class="form-check-label">TB2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cb_tb3_view" {{ $phieuXXDH->phan_bo_tb3 != '' ? 'checked' : '' }} readonly>
                                <label class="form-check-label">TB3</label>
                            </div>
                        </div> 
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Số cone : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->so_cone }}</p>
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Số kg/cone : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->so_kg_cone }}</p>
                    </div>
                    @if ($phieuXXDH->loai == 'dhm')
                        <div class="col-12">
                            <p class="fw-semibold d-inline">QA kiến nghị : </p>
                            <p class="card-text d-inline">{{ $phieuXXDH->qa_kien_nghi }}</p>
                        </div>
                    @endif
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Nơi sản xuất dự kiến - Line : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->line }}</p>
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Máy : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->may }}</p>
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Ngày giao hàng : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->ngay_giao_hang }}</p>
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold d-inline">Ngày bắt đầu giao (nếu có) : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->ngay_bat_dau_giao }}</p>
                    </div>
                    <div class="col-12">
                        <p class="fw-semibold d-inline">Thành phẩm của khách hàng : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->thanh_pham_cua_khach_hang }}</p>
                    </div>
                    <div class="col-12">
                        <p class="fw-semibold d-inline">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có) : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->phan_anh_cua_khach_hang }}</p>
                    </div>
                    <div class="col-12">
                        <p class="fw-semibold d-inline">Thông tin đóng gói : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->thong_tin_dong_goi }}</p>
                    </div>
                    <div class="col-12">
                        <p class="fw-semibold d-inline">Phản hồi của KHST : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->phan_hoi_khst }}</p>
                    </div>
                    <div class="col-12">
                        <p class="fw-semibold d-inline">Phản hồi của QA : </p>
                        <p class="card-text d-inline">{{ $phieuXXDH->phan_hoi_qa }}</p>
                    </div>
                </div>
            </div>
            <div class="shadow p-3 bg-body-tertiary rounded">
                @if ($logPXXDH != null)
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
                                    @foreach ($logPXXDH as $item)
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInputField">Đóng</button>
        </div>
      </div>
    </div>
</div>