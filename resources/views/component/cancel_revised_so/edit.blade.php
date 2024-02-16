<style>
    label{
        font-weight:600;
    }
</style>
<form wire:submit.prevent="update">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="editModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">CẬP NHẬT CANCEL - REVISED S/O</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'edit')
                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Tên khách hàng</label>
                                <input class="form-control" list="datalistOptions" placeholder="Nhập tên khách hàng" wire:model.defer = "cancelRevisedSO.ten_khach_hang" required>
                                <datalist id="datalistOptions">
                                    @foreach ($danhSachKhachHang as $item)
                                        <option value="{{ $item->ten_tv }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" wire:model.defer="cancelRevisedSO.date" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">S/O</label>
                                <input type="text" class="form-control" placeholder="Nhập S/O" wire:model.defer="cancelRevisedSO.so" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-check-inline" style="margin-top: 32px">
                                    <input class="form-check-input" type="checkbox" id="cb1" value="1" wire:model.defer="cancelRevisedSO.being_processed">
                                    <label class="form-check-label" for="cb1">Being processed</label>
                                </div>
                                <div class="form-check form-check-inline" style="margin-top: 32px">
                                    <input class="form-check-input" type="checkbox" id="cb2" value="1" wire:model.defer="cancelRevisedSO.open">
                                    <label class="form-check-label" for="cb2">Open</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="san_xuat_moi" value="1" wire:model.defer="cancelRevisedSO.san_xuat_moi">
                                    <label class="form-check-label" for="san_xuat_moi">Sản xuất mới</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="ton_kho" value="1" wire:model.defer="cancelRevisedSO.ton_kho">
                                    <label class="form-check-label" for="ton_kho">Tồn kho</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="cbA" value="1" wire:model.defer="cancelRevisedSO.cancel_order">
                                    <label class="form-check-label" for="cbA">Cancel order</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="cbB" value="1" wire:model.defer="cancelRevisedSO.revised_latest_shipment_date">
                                    <label class="form-check-label" for="cbB">Revised latest shipment date</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Old date</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="cancelRevisedSO.old_date">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">New date</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="cancelRevisedSO.new_date">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbC"  wire:model.defer="cancelRevisedSO.cb_revised_qty">
                                    <label class="form-check-label" for="cbC">
                                        Revised Q’ty
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Revised Q’ty" wire:model.defer="cancelRevisedSO.revised_qty">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbD"  wire:model.defer="cancelRevisedSO.cb_incoterms">
                                    <label class="form-check-label" for="cbD">
                                        Incoterms
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Incoterms" wire:model.defer="cancelRevisedSO.incoterms">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbE"  wire:model.defer="cancelRevisedSO.cb_payment_terms">
                                    <label class="form-check-label" for="cbE">
                                        Payment terms
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Payment terms" wire:model.defer="cancelRevisedSO.payment_terms">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbF"  wire:model.defer="cancelRevisedSO.cb_shipment_plan">
                                    <label class="form-check-label" for="cbF">
                                        Shipment plan
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Shipment plan" wire:model.defer="cancelRevisedSO.shipment_plan">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbG"  wire:model.defer="cancelRevisedSO.cb_output_tax">
                                    <label class="form-check-label" for="cbG">
                                        Output tax
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Output tax" wire:model.defer="cancelRevisedSO.output_tax">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbH"  wire:model.defer="cancelRevisedSO.cb_bill_to_party">
                                    <label class="form-check-label" for="cbH">
                                        Bill to party
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Bill to party" wire:model.defer="cancelRevisedSO.bill_to_party">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbI"  wire:model.defer="cancelRevisedSO.cb_po_number">
                                    <label class="form-check-label" for="cbI">
                                        PO number
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập PO number" wire:model.defer="cancelRevisedSO.po_number">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbJ"  wire:model.defer="cancelRevisedSO.cb_order_reason">
                                    <label class="form-check-label" for="cbJ">
                                        Order reason
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Order reason" wire:model.defer="cancelRevisedSO.order_reason">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbK"  wire:model.defer="cancelRevisedSO.cb_reason_for_reject">
                                    <label class="form-check-label" for="cbK">
                                        Reason for reject
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Reason for reject" wire:model.defer="cancelRevisedSO.reason_for_reject">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbL"  wire:model.defer="cancelRevisedSO.cb_internal_order">
                                    <label class="form-check-label" for="cbL">
                                        Internal order
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Internal order" wire:model.defer="cancelRevisedSO.internal_order">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cbM"  wire:model.defer="cancelRevisedSO.cb_tolerance">
                                    <label class="form-check-label" for="cbM">
                                        Tolerance
                                    </label>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Nhập Tolerance" wire:model.defer="cancelRevisedSO.tolerance">
                            </div>
                        </div>
                        <hr>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Sale phụ trách</label>
                                            <select name="" id="" class="form-select" wire:model.defer="cancelRevisedSO.sale_phu_trach" required>
                                                <option value="">Vui lòng chọn sale</option>
                                                @foreach ($danhSachSale as $item)
                                                    <option value="{{ $item->email }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <h5 class="card-title">Cập nhật Item</h5>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($cancelRevisedSOItemEdit as $key => $value)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $key == 0 ? ' active' : '' }}" id="tab_{{ $value->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab_{{ $value->id }}-tab-pane" type="button" role="tab" aria-controls="tab_{{ $value->id }}-tab-pane" aria-selected="true">{{ 'Item ' . (int)$key + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($cancelRevisedSOItemEdit as $key => $value)
                                                <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="tab_{{ $value->id }}-tab-pane" role="tabpanel" aria-labelledby="tab_{{ $value->id }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <div class="row g-3">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Old Item</label>
                                                                <input type="text" placeholder="Nhập Old Item" class="form-control form-control-sm" wire:model.defer="oldItemEdit.{{ $value->id }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">New Item</label>
                                                                <input type="text" placeholder="Nhập New Item" class="form-control form-control-sm" wire:model.defer="newItemEdit.{{ $value->id }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Description</label>
                                                                <input type="text" placeholder="Nhập Description" class="form-control form-control-sm" wire:model.defer="descriptionEdit.{{ $value->id }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Old Q’ty</label>
                                                                <input type="text" placeholder="Nhập Old Q’ty" class="form-control form-control-sm" wire:model.defer="oldQtyEdit.{{ $value->id }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">New Q’ty</label>
                                                                <input type="text" placeholder="Nhập New Q’ty" class="form-control form-control-sm" wire:model.defer="newQtyEdit.{{ $value->id }}" required>
                                                            </div>
                                                        </div>
                                                        @if ($key != 0)
                                                            <div class="row">
                                                                <div class="col">
                                                                    <button class="btn btn-outline-danger btn-sm float-end"  style="margin-top: 3px" wire:click.prevent="removeEdit({{ $value->id }})"><i class="fa-regular fa-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <button class="btn btn-primary btn-sm" wire:click.prevent="add({{ $i }})">+ Thêm quy cách</button>
                                        </div>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach ($inputs as $key => $value)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link{{ $key == array_key_last($inputs) ? ' active' : '' }}" id="tab{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $key }}-tab-pane" type="button" role="tab" aria-controls="tab{{ $key }}-tab-pane" aria-selected="true">{{ 'Item ' . (int)$key + 1 }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach ($inputs as $key => $value)
                                                <div class="tab-pane fade{{ $key == array_key_last($inputs) ? ' show active' : '' }}" id="tab{{ $key }}-tab-pane" role="tabpanel" aria-labelledby="tab{{ $key }}-tab" tabindex="0">
                                                    <div class="shadow p-3 bg-body-tertiary rounded" style="margin-top: 10px">
                                                        <div class="row g-3">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Old Item</label>
                                                                <input type="text" placeholder="Nhập Old Item" class="form-control form-control-sm" wire:model.defer="oldItem.{{ $value }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">New Item</label>
                                                                <input type="text" placeholder="Nhập New Item" class="form-control form-control-sm" wire:model.defer="newItem.{{ $value }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Description</label>
                                                                <input type="text" placeholder="Nhập Description" class="form-control form-control-sm" wire:model.defer="description.{{ $value }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">Old Q’ty</label>
                                                                <input type="text" placeholder="Nhập Old Q’ty" class="form-control form-control-sm" wire:model.defer="oldQty.{{ $value }}" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="" class="form-label">New Q’ty</label>
                                                                <input type="text" placeholder="Nhập New Q’ty" class="form-control form-control-sm" wire:model.defer="newQty.{{ $value }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <button class="btn btn-outline-danger btn-sm float-end"  style="margin-top: 3px" wire:click.prevent="remove({{ $key }})"><i class="fa-regular fa-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="">Other reason</label>
                                <textarea class="form-control" name="" id="" cols="30" rows="5" placeholder="Nhập Other Reason" wire:model.defer="cancelRevisedSO.other_reason"></textarea>
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
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </form>