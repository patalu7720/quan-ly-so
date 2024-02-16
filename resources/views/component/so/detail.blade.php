@php
    use Carbon\Carbon;
@endphp
<div wire:ignore.self class="modal" id="detailsSOModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quản lý File SO : {{ $so }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prvent="resetInputField()"></button>
            </div>
            <div class="modal-body">
                @if ($state == 'details')
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '3' ?  'active' : ''  }}" id="tab_3-tab" wire:click="tab('3')" data-bs-toggle="tab" data-bs-target="#tab_3-tab-pane" type="button" role="tab" aria-controls="tab_3-tab-pane" aria-selected="{{ $tab == '3' ?  'true' : 'false'  }}">Booking</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '4' ?  'active' : ''  }}" id="tab_4-tab" wire:click="tab('4')" data-bs-toggle="tab" data-bs-target="#tab_4-tab-pane" type="button" role="tab" aria-controls="tab_4-tab-pane" aria-selected="{{ $tab == '4' ?  'true' : 'false'  }}">Chứng từ hải quan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '5' ?  'active' : ''  }}" id="tab_5-tab" wire:click="tab('5')" data-bs-toggle="tab" data-bs-target="#tab_5-tab-pane" type="button" role="tab" aria-controls="tab_5-tab-pane" aria-selected="{{ $tab == '5' ?  'true' : 'false'  }}">Phiếu xuất kho</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '6' ?  'active' : ''  }}" id="tab_6-tab" wire:click="tab('6')" data-bs-toggle="tab" data-bs-target="#tab_6-tab-pane" type="button" role="tab" aria-controls="tab_6-tab-pane" aria-selected="{{ $tab == '6' ?  'true' : 'false'  }}">CO</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '7' ?  'active' : ''  }}" id="tab_7-tab" wire:click="tab('7')" data-bs-toggle="tab" data-bs-target="#tab_7-tab-pane" type="button" role="tab" aria-controls="tab_7-tab-pane" aria-selected="{{ $tab == '7' ?  'true' : 'false'  }}">Tờ khai xuất hàng</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == '8' ?  'active' : ''  }}" id="tab_8-tab" wire:click="tab('8')" data-bs-toggle="tab" data-bs-target="#tab_8-tab-pane" type="button" role="tab" aria-controls="tab_8-tab-pane" aria-selected="{{ $tab == '8' ?  'true' : 'false'  }}">Tài liệu cố định</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ $tab == '3' ?  'show active' : ''  }}" id="tab_3-tab-pane" role="tabpanel" aria-labelledby="tab_3-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadBooking('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="fileBooking" id="{{ $fileBookingID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="noteBooking"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col">Note</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFileBooking != null)
                                                    @foreach ($danhSachFileBooking as $item)
                                                        <tr>
                                                            <td>
                                                                {{ str_replace('Booking/' . $so . '/', '',$item) }}
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNoteBooking as $note)
                                                                    @if ($note->ten_file == str_replace('Booking/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('Booking','{{ $so }}', '{{ str_replace('Booking/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('Booking','{{ $so }}', '{{ str_replace('Booking/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == '4' ?  'show active' : ''  }}" id="tab_4-tab-pane" role="tabpanel" aria-labelledby="tab_4-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadChungTuHaiQuan('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="fileChungTuHaiQuan" id="{{ $fileChungTuHaiQuanID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="noteChungTuHaiQuan"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col">Note</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFileChungTuHaiQuan != null)
                                                    @foreach ($danhSachFileChungTuHaiQuan as $item)
                                                        <tr>
                                                            <td>
                                                                <label>{{ str_replace('ChungTuHaiQuan/' . $so . '/', '',$item) }}</label>
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNoteChungTuHaiQuan as $note)
                                                                    @if ($note->ten_file == str_replace('ChungTuHaiQuan/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('ChungTuHaiQuan','{{ $so }}', '{{ str_replace('ChungTuHaiQuan/' . $so . '/', '',$item)}}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('ChungTuHaiQuan','{{ $so }}', '{{ str_replace('ChungTuHaiQuan/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == '5' ?  'show active' : ''  }}" id="tab_5-tab-pane" role="tabpanel" aria-labelledby="tab_5-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadPhieuXuatKho('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="filePhieuXuatKho" id="{{ $filePhieuXuatKhoID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="notePhieuXuatKho"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFilePhieuXuatKho != null)
                                                    @foreach ($danhSachFilePhieuXuatKho as $item)
                                                        <tr>
                                                            <td>
                                                                <label>{{ str_replace('PhieuXuatKho/' . $so . '/', '',$item) }}</label>
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNotePhieuXuatKho as $note)
                                                                    @if ($note->ten_file == str_replace('PhieuXuatKho/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('PhieuXuatKho','{{ $so }}', '{{ str_replace('PhieuXuatKho/' . $so . '/', '',$item)}}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('PhieuXuatKho','{{ $so }}', '{{ str_replace('PhieuXuatKho/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == '6' ?  'show active' : ''  }}" id="tab_6-tab-pane" role="tabpanel" aria-labelledby="tab_6-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadCO('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="fileCO" id="{{ $fileCOID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="noteCO"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFileCO != null)
                                                    @foreach ($danhSachFileCO as $item)
                                                        <tr>
                                                            <td>
                                                                <label>{{ str_replace('CO/' . $so . '/', '',$item) }}</label>
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNoteCO as $note)
                                                                    @if ($note->ten_file == str_replace('CO/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('CO','{{ $so }}', '{{ str_replace('CO/' . $so . '/', '',$item)}}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('CO','{{ $so }}', '{{ str_replace('CO/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == '7' ?  'show active' : ''  }}" id="tab_7-tab-pane" role="tabpanel" aria-labelledby="tab_7-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadToKhaiXuatHang('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="fileToKhaiXuatHang" id="{{ $fileToKhaiXuatHangID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="noteToKhaiXuatHang"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFileToKhaiXuatHang != null)
                                                    @foreach ($danhSachFileToKhaiXuatHang as $item)
                                                        <tr>
                                                            <td>
                                                                <label>{{ str_replace('ToKhaiXuatHang/' . $so . '/', '',$item) }}</label>
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNoteToKhaiXuatHang as $note)
                                                                    @if ($note->ten_file == str_replace('ToKhaiXuatHang/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('ToKhaiXuatHang','{{ $so }}', '{{ str_replace('ToKhaiXuatHang/' . $so . '/', '',$item)}}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('ToKhaiXuatHang','{{ $so }}', '{{ str_replace('ToKhaiXuatHang/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == '8' ?  'show active' : ''  }}" id="tab_8-tab-pane" role="tabpanel" aria-labelledby="tab_8-tab" tabindex="0">
                        <div class="row my-4">
                            <div class="col-6">
                                <form wire:submit.prevent="uploadTaiLieuCoDinh('{{ $so }}')">
                                    <div class="shadow p-3 bg-body-tertiary rounded">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Upload file</label>
                                                <input class="form-control" type="file" wire:model.defer="fileTaiLieuCoDinh" id="{{ $fileTaiLieuCoDinhID }}" multiple required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <textarea class="form-control" cols="30" rows="3" placeholder="Nhập ghi chú" wire:model.defer="noteTaiLieuCoDinh"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary float-end">Thực hiện</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="shadow p-3 bg-body-tertiary rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Download file</label>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($danhSachFileTaiLieuCoDinh != null)
                                                    @foreach ($danhSachFileTaiLieuCoDinh as $item)
                                                        <tr>
                                                            <td>
                                                                <label>{{ str_replace('TaiLieuCoDinh/' . $so . '/', '',$item) }}</label>
                                                            </td>
                                                            <td>
                                                                @foreach ($danhSachNoteTaiLieuCoDinh as $note)
                                                                    @if ($note->ten_file == str_replace('TaiLieuCoDinh/' . $so . '/', '',$item))
                                                                        <p style="white-space: pre-line">{{ $note->note }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm float-end mx-2" wire:click="deleteFile('TaiLieuCoDinh','{{ $so }}', '{{ str_replace('TaiLieuCoDinh/' . $so . '/', '',$item)}}')"><i class="fa-solid fa-trash-can"></i></a>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="downloadFile('TaiLieuCoDinh','{{ $so }}', '{{ str_replace('TaiLieuCoDinh/' . $so . '/', '',$item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        </div>
    </div>
</div>