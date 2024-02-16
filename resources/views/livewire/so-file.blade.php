<div class="container">
    <style>
        a:hover {
            background-color: yellow;
        }
    </style>
    <form action="" wire:submit.prevent="upFileAll">
        <div wire:ignore.self class="modal" id="upFileAllModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Up file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInput()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'upFileAll')
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chọn loại chứng từ</label>
                                <select name="" id="" wire:model="loaiChungTu" class="form-select form-select-sm" required>
                                    <option value="">--- Chọn loại chứng từ ---</option>
                                    <option value="bk">Booking</option>
                                    <option value="lc">LC</option>
                                    <option value="cthq">Chứng từ hải quan</option>
                                    <option value="pxk">Phiếu xuất kho</option>
                                    <option value="co">CO</option>
                                    <option value="tkxh">Tờ khai xuất hàng</option>
                                    <option value="tlcd">Tài liệu cố định</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chọn File</label>
                                <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" wire:model.defer="fileAll" multiple required>
                            </div>
                        </div>
                        @if ($loaiChungTu == 'bk')
                            <hr>
                            <form action="" wire:submit.prevent="upFileBooking">
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Booking number</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Booking number" wire:model.defer="bookingNumber">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Total Booking Container</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Total Booking Container" wire:model.defer="totalBookingContainer">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended Vessel/Voyage</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended Vessel/Voyage" wire:model.defer="intendedVessel">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Port of loading</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Port of loading" wire:model.defer="portOfLoading">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Port of discharge</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Port of discharge" wire:model.defer="portOfDischarge">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended vgm cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended Vgm cut-off" wire:model.defer="intendedVgm">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended esi cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended esi cut-off" wire:model.defer="intendedEsi">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended fcl cy cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended fcl cy cut-off" wire:model.defer="intendedFcl">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">ETA</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="ETA" wire:model.defer="eta">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">ETD</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="ETD" wire:model.defer="etd">
                                    </div>
                                </div>
                            </form>
                        @elseif($loaiChungTu == 'pxk')
                            <hr>
                            <form action="" wire:submit.prevent="upFilePXK">
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Quy cách</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Quy cách" wire:model.defer="quyCach" required>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Số lượng</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Số lượng" wire:model.defer="soLuong" required>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInput()">Đóng</button>
                <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
            </div>
            </div>
        </div>
    </form>
    <form action="" wire:submit.prevent="updateFile">
        <div wire:ignore.self class="modal" id="updateFileModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Update file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInput()"></button>
                </div>
                <div class="modal-body">
                    @if ($state == 'updateFile')
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chọn loại chứng từ</label>
                                <select name="" id="" wire:model="loaiChungTu" class="form-select form-select-sm" required>
                                    <option value="">--- Chọn loại chứng từ ---</option>
                                    <option value="bk">Booking</option>
                                    <option value="lc">LC</option>
                                    <option value="cthq">Chứng từ hải quan</option>
                                    <option value="pxk">Phiếu xuất kho</option>
                                    <option value="co">CO</option>
                                    <option value="tkxh">Tờ khai xuất hàng</option>
                                    <option value="tlcd">Tài liệu cố định</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Chọn File</label>
                                <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" wire:model.defer="fileAll" multiple required>
                            </div>
                        </div>
                        @if ($loaiChungTu == 'bk' && $bookingNumber == '')
                            <hr>
                            <form action="" wire:submit.prevent="upFileBooking">
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Booking number</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Booking number" wire:model.defer="bookingNumber">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Total Booking Container</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Total Booking Container" wire:model.defer="totalBookingContainer">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended Vessel/Voyage</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended Vessel/Voyage" wire:model.defer="intendedVessel">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Port of loading</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Port of loading" wire:model.defer="portOfLoading">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Port of discharge</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Port of discharge" wire:model.defer="portOfDischarge">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended vgm cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended Vgm cut-off" wire:model.defer="intendedVgm">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended esi cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended esi cut-off" wire:model.defer="intendedEsi">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Intended fcl cy cut-off</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Intended fcl cy cut-off" wire:model.defer="intendedFcl">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">ETA</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="ETA" wire:model.defer="eta">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">ETD</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="ETD" wire:model.defer="etd">
                                    </div>
                                </div>
                            </form>
                        @endif
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInput()">Đóng</button>
                <button type="submit" class="btn btn-primary">Thực hiện</button>
                </div>
            </div>
            </div>
        </div>
    </form>
    <div class="row mb-3" style="padding-top: 30px">
        <div class="col">
            <button class="btn btn-primary btn-sm float-end" wire:click.prevent="upFileAllModal" data-bs-toggle="modal" data-bs-target="#upFileAllModal">+ Thêm mới 1 bộ chứng từ</button>
        </div>
    </div>
    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <div class="row mb-3">
            <div class="col-12">
                <p class="d-inline">{{ 'Tổng số lượng : ' }}</p>
                <p class="d-inline fw-bold" style="color: blue">{{ number_format($table->sum('so_luong_tong')) }}</p>
            </div>
            <div class="col-12">
                <p class="d-inline">{{ 'Số lượng đã giao : ' }}</p>
                <p class="d-inline fw-bold" style="color: blue">{{ number_format($table->sum('so_luong_da_giao')) }}</p>
            </div>
            <div class="col-12">
                <p class="d-inline">{{ 'Số lượng còn lại : ' }}</p>
                <p class="d-inline fw-bold" style="color: blue">{{ number_format($table->sum('so_luong_tong') - $table->sum('so_luong_da_giao')) }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if ($danhSachFile != null)
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle" style="width:1600px">
                            <thead>
                                <tr>
                                    <th style="width:30px"></th>
                                    <th>Booking details</th>
                                    <th>Booking</th>
                                    <th>LC</th>
                                    <th>Chứng từ hải quan</th>
                                    <th>Phiếu xuất kho</th>
                                    <th>Quy cách</th>
                                    <th>Số lượng tổng</th>
                                    <th>Số lượng đã giao</th>
                                    <th>CO</th>
                                    <th>Tờ khai xuất hàng</th>
                                    <th>Tài liệu cố định</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($danhSachFile as $item)
                                    <tr>
                                        <td>
                                            <a href="" wire:click.prevent="updateFileModal('{{ $item->id }}' ,'{{ $item->booking_number }}')" data-bs-toggle="modal" data-bs-target="#updateFileModal"><i class="fa-solid fa-circle-plus fa-xl"></i></a>
                                        </td>
                                        <td style="font-size: 12px">
                                            @if ($item->booking_number != '')
                                                <div class="accordion" id="accordionExample{{ $item->booking_number }}">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $item->booking_number }}" aria-expanded="true" aria-controls="collapseOne{{ $item->booking_number }}">
                                                                Booking number : {{ $item->booking_number }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne{{ $item->booking_number }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <label class="float-start">Booking number : {{ $item->booking_number }}</label><br>
                                                                <label class="float-start">Total Booking Container : {{ $item->total_booking_container }}</label><br>
                                                                <label class="float-start">Intended Vessel/Voyage : {{ $item->intened_vessel }}</label><br>
                                                                <label class="float-start">Port of loading : {{ $item->port_of_loading }}</label><br>
                                                                <label class="float-start">Port of discharge : {{ $item->port_of_discharge }}</label><br>
                                                                <label class="float-start">Intended vgm cut-off : {{ $item->intened_vgm_cut_off }}</label><br>
                                                                <label class="float-start">Intended esi cut-off : {{ $item->intened_esi_cut_off }}</label><br>
                                                                <label class="float-start">Intended fcl cy cut-off : {{ $item->intened_fcl_cy_cut_off }}</label><br>
                                                                <label class="float-start">ETA : {{ $item->eta }}</label><br>
                                                                <label class="float-start">ETD : {{ $item->etd }}</label><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','BK','{{ $so }}','{{ $item->file_bk }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$item->file_bk) }}</a>
                                        </td>
                                        <td>
                                            @php
                                                $list_lc = explode(',', $item->file_lc);
                                            @endphp
                                            @foreach ($list_lc as $lc)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','LC','{{ $so }}','{{ $lc }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$lc) }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $list_cthq = explode(',', $item->file_cthq);
                                            @endphp
                                            @foreach ($list_cthq as $cthq)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','ChungTuHaiQuan','{{ $so }}','{{ $cthq }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$cthq) }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $list_pxk = explode(',', $item->file_pxk);
                                            @endphp
                                            @foreach ($list_pxk as $pxk)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','PhieuXuatKho','{{ $so }}','{{ $pxk }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$pxk) }}</a><br>
                                            @endforeach
                                        </td>
                                        @foreach ($table as $itemTable)
                                            @if ($itemTable->quy_cach == $item->quy_cach)
                                                <td>
                                                    <p>{{ $itemTable->quy_cach }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $itemTable->so_luong_tong }}</p>
                                                </td> 
                                                <td>
                                                    <p>{{ $itemTable->so_luong_da_giao }}</p>
                                                </td>
                                                @break
                                            @else
                                                @if ($loop->last)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            @endif
                                        @endforeach
                                        <td>
                                            @php
                                                $list_co = explode(',', $item->file_co);
                                            @endphp
                                            @foreach ($list_co as $co)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','CO','{{ $so }}','{{ $co }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$co) }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $list_tkxh = explode(',', $item->file_tkxh);
                                            @endphp
                                            @foreach ($list_tkxh as $tkxh)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','ToKhaiXuatHang','{{ $so }}','{{ $tkxh }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$tkxh) }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $list_tlcd = explode(',', $item->file_tlcd);
                                            @endphp
                                            @foreach ($list_tlcd as $tlcd)
                                                <a class="link-opacity-10 fw-medium" href="" wire:click.prevent="downloadFile('{{ $item->id }}','TaiLieuCoDinh','{{ $so }}','{{ $tlcd }}')" style="text-decoration:none">{{ str_replace(['.xlsx', '.xls', '.docx', '.doc', '.pdf', '.jpg', '.png'], '',$tlcd) }}</a><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
