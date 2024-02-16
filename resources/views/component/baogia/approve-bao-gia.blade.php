<form wire:submit.prevent="approveBaoGia">
    <div wire:ignore.self class="modal" id="approveBaoGiaModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Duyệt Phiếu Báo Gía / {{ $soPhieu }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="shadow mb-3 p-3 bg-body-tertiary rounded">
                    <div class="row mb-3 g-3">
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Số Phiếu : </p>
                            <p class="card-text d-inline">{{ $soPhieu }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Loại : </p>
                            <p class="card-text d-inline">{{ $loaiBaoGia == 'nd' ? 'Nội địa' : 'Xuất khẩu' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">Ngày : </p>
                            <p class="card-text d-inline">{{ $ngay }}</p>
                        </div>
                        <div class="col-6">
                            <p class="fw-semibold d-inline">To : </p>
                            <p class="card-text d-inline">{{ $to }}</p>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive caption-top">
                                        <caption>Quy cách</caption>
                                        <table class="table table-striped" style="width: 1000px">
                                            <thead>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">OEM</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Bobbin weight</th>
                                                <th scope="col">Yarn price</th>
                                                <th scope="col">Grade</th>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachBaoGiaSanPham != null)
                                                    @foreach ($danhSachBaoGiaSanPham as $item)
                                                        <tr>
                                                            <td scope="col">{{ $item->yarn_type_1 }}</td>
                                                            <td scope="col">{{ $item->yarn_type_2 }}</td>
                                                            <td scope="col">{{ $item->yarn_type_3 }}</td>
                                                            <td scope="col">{{ $item->yarn_type_4 }}</td>
                                                            <td scope="col">{{ $item->yarn_type_5 }}</td>
                                                            <td scope="col">{{ $item->yarn_type_6 }}</td>
                                                            <td scope="col">{{ $item->oem }}</td>
                                                            <td scope="col">{{ $item->quantity }}</td>
                                                            <td scope="col">{{ $item->bobbin_weight }}</td>
                                                            <td scope="col">{{ $item->yarn_price }}</td>
                                                            <td scope="col">{{ $item->grade }}</td>
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
                            <p class="fw-semibold d-inline">Remark : </p>
                            <p class="card-text d-inline">{{ $remark }}</p>
                        </div>

                        <div class="col-12">
                            <p class="fw-semibold d-inline">Payment Terms : </p>
                            <p class="card-text d-inline">{{ $paymentTerms }}</p>
                        </div>
                        <div class="col-12">
                            <p class="fw-semibold d-inline">Exchange rate : </p>
                            <p class="card-text d-inline">{{ $exchangeRate }}</p>
                        </div>

                        <div class="col-12">
                            <p class="fw-semibold d-inline">Valid : </p>
                            <p class="card-text d-inline">{{ $validDate }}</p>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Duyệt</button>
            </div>
          </div>
        </div>
    </div>
</form>