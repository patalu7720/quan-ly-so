<style>
    label{
        font-weight:600;
    }
</style>
<div class="row">
    <div class="col">
      <div wire:ignore.self class="modal" id="viewBaoGiaModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Chi tiết phiếu Báo Giá / {{ $soPhieu }}</h5>
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
                                Approved 1 <i class="fa-solid fa-circle-minus"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-secondary p-2" role="alert">
                                Finish <i class="fa-solid fa-circle-minus"></i>
                            </div>
                        </div>
                    @elseif ($status == 'Approved 1')
                        <div class="col">
                            <div class="alert alert-success p-2" role="alert">
                                New <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-success p-2" role="alert">
                                Approved 1 <i class="fa-solid fa-circle-check"></i>
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
                                New <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-success p-2" role="alert">
                                Approved 1 <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-secondary p-2" role="alert">
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
                            <p class="fw-semibold d-inline">Loại : </p>
                            <p class="card-text d-inline">{{ $loaiBaoGia }}</p>
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
                                        <th>
                                            Thông tin xác nhận
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
                                                    {{ $item->confirm }}
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