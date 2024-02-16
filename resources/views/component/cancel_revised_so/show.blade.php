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
                                    <div class="col-12">
                                        <h2 class="text-center">CANCEL -  REVISED S/O</h2>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['so_phieu'] }}</p>
                                        <p class="fw-semibold d-inline">Số phiếu : </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text d-inline float-end">{{ $cancelRevisedSO['date'] }}</p>
                                        <p class="fw-semibold d-inline float-end">Date : </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">1. Customer (Tên khách hàng) : </p>
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['ten_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">2. Code (Mã khách hàng) : </p>
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['ma_khach_hang'] }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-semibold d-inline">3. S/O no(Số S/O) : </p>
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['so'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check mx-4">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.being_processed" readonly>
                                            <label class="form-check-label">
                                                Being processed
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.open" readonly>
                                            <label class="form-check-label">
                                                Open
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="">4. Nội dung :</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.san_xuat_moi" readonly>
                                            <label class="form-check-label">
                                                Sản xuất mới
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.ton_kho" readonly>
                                            <label class="form-check-label">
                                                Tồn kho
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cancel_order" readonly>
                                            <label class="form-check-label">
                                                Cancel order
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.revised_latest_shipment_date" readonly>
                                            <label class="form-check-label">
                                                Revised latest shipment date
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">Old date : </p>
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['old_date'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="fw-semibold d-inline">New date : </p>
                                        <p class="card-text d-inline">{{ $cancelRevisedSO['new_date'] }}</p>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_revised_qty" readonly>
                                            <label class="form-check-label">
                                                Revised Q’ty : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['revised_qty'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_incoterms" readonly>
                                            <label class="form-check-label">
                                                Incoterms : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['incoterms'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_payment_terms" readonly>
                                            <label class="form-check-label">
                                                Payment terms : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['payment_terms'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_shipment_plan" readonly>
                                            <label class="form-check-label">
                                                Shipment plan : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['shipment_plan'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_output_tax" readonly>
                                            <label class="form-check-label">
                                                Output tax : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['output_tax'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.bill_to_party" readonly>
                                            <label class="form-check-label">
                                                Bill to party : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['bill_to_party'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_po_number" readonly>
                                            <label class="form-check-label">
                                                PO number : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['po_number'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_order_reason" readonly>
                                            <label class="form-check-label">
                                                Order reason : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['order_reason'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_reason_for_reject" readonly>
                                            <label class="form-check-label">
                                                Reason for reject : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['reason_for_reject'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_internal_order" readonly>
                                            <label class="form-check-label">
                                                Internal order : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['internal_order'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.defer="cancelRevisedSO.cb_tolerance" readonly>
                                            <label class="form-check-label">
                                                Tolerance : 
                                            </label>
                                            <label for="">{{ $cancelRevisedSO['tolerance'] ?? '...........................' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Old Item</th>
                                                    <th scope="col">New Item</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Old Q’ty</th>
                                                    <th scope="col">New Q’ty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cancelRevisedSOItem as $item)
                                                    <tr>
                                                        <td>{{ $item->old_item }}</td>
                                                        <td>{{ $item->new_item }}</td>
                                                        <td>{{ $item->description }}</td>
                                                        <td>{{ $item->old_qty }}</td>
                                                        <td>{{ $item->new_qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="">Other reason : </label>
                                    <p>{{ $cancelRevisedSO['other_reason'] }}</p>
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
                                                        <th scope="col">Ghi chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cancelRevisedSOLog as $item)
                                                        <tr>
                                                            <td>{{ $item->status }}</td>
                                                            <td>{{ $item->created_user }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                            <td>{{ $item->note }}</td>
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