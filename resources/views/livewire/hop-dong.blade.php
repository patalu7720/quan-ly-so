<div class="container" style="margin-top: 10px">
<style>
    table {
        counter-reset: tableCount;     
    }
    .counterCell:before {              
        content: counter(tableCount); 
        counter-increment: tableCount; 
    }
</style>

@include('component.HDNDTV')
@include('component.HDNDSN')
@include('component.HDXKTCTA')
@include('component.HDXKTCSN')
@include('component.HDXKTT')
@include('component.annexDESIPRO')

@include('component.deleteHD')
@include('component.reject-modal')

@include('component.uploadFileScan')
@include('component.uploadFileRoot')
@include('component.uploadHopDongCoFileSan')
@include('component.uploadPhuLuc')
@include('component.uploadFileTDG')

@include('component.chiTietHopDong')

<div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <div class="row mb-3">
        <div class="col">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Khung tìm kiếm
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label">Nhân viên</label>
                                    <select name="" id="" class="form-select" wire:model.defer="userTimKiem">
                                        <option value="">Tất cả</option>
                                        @foreach ($danhSachSaleAdmin as $item)
                                            <option value="{{ $item->username }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Số HĐ</label>
                                    <input type="text" class="form-control" placeholder="Nhập số HĐ" wire:model.defer="soHDTimKiem">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Loại hợp đồng</label>
                                    <select name="" id="" class="form-select" wire:model.defer="loaiHDTimKiem">
                                        <option value="">Tất cả</option>
                                        <option value="1">Nội địa tiếng Việt</option>
                                        <option value="2">Nội địa song ngữ</option>
                                        <option value="3">Xuất khẩu TC T.A</option>
                                        <option value="4">Xuất khẩu TC song ngữ</option>
                                        <option value="5">Xuất khẩu TT</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Trạng thái</label>
                                    <select name="" id="" class="form-select" wire:model.defer="trangThaiTimKiem">
                                        {{-- <option value="tatca">Tất cả</option>
                                        <option value="doiduyet">Đợi duyệt</option>
                                        <option value="daduyet">Đã duyệt</option> --}}
                                        <option value="TatCa">Tất cả</option>
                                        <option value="New">New</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Scanned file received">Scanned file received</option>
                                        <option value="Success">Success</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Từ ngày</label>
                                    <input type="date" class="form-control" wire:model.defer="tuNgay">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Đến ngày</label>
                                    <input type="date" class="form-control" wire:model.defer="denNgay">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên khách hàng" wire:model.defer="tenKHTimKiem">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary float-end" wire:click="timKiem">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row mb-3">
        <div class="col">
            @can('create_contracts')
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="canhan" wire:model="canhan_tatca">
                    <label class="form-check-label" for="inlineRadio1">Cá nhân</label>
                </div>
            @endcan
            @can('approve_contracts')
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="doiduyet" wire:model="canhan_tatca">
                    <label class="form-check-label" for="inlineRadio2">HĐ đợi duyệt</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="daduyet" wire:model="canhan_tatca">
                    <label class="form-check-label" for="inlineRadio3">HĐ đã duyệt</label>
                </div>
            @endcan
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="doiduyet" wire:model="canhan_tatca">
                <label class="form-check-label" for="inlineRadio2">HĐ đợi duyệt</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="daduyet" wire:model="canhan_tatca">
                <label class="form-check-label" for="inlineRadio3">HĐ đã duyệt</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="tatca" wire:model="canhan_tatca">
                <label class="form-check-label" for="inlineRadio4">Tất cả</label>
            </div>
        </div>
        @can('create_contracts')
            <div class="col-12 col-lg-4">
                <div class="btn-group d-inline px-2 float-end">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        + XK
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalXKTCTA" wire:click = "createHopDongXuatKhauTaiChoTiengAnh()">Tại chỗ - tiếng Anh</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalXKTCSNTV" wire:click = "createHopDongXuatKhauTaiChoSongNgu()">Tại chỗ - song ngữ</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalXKTT" wire:click = "createHopDongXuatKhauTrucTiep()">Trực tiếp</a></li>
                    </ul>
                </div>
                <div class="btn-group d-inline px-2 float-end">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        + NĐ
                    </button>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalNDTV" wire:click = "createHopDongNoiDiaTiengViet()">Tiếng Việt</a></li>
                    <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalNDSNTV" wire:click = "createHopDongNoiDiaSongNgu()">Song ngữ</a></li>
                    </ul>
                </div>
                <div class="btn-group d-inline px-2 float-end">
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><h6 class="dropdown-header">Tạo HĐ có sẵn file</h6></li>
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('1')">Tiếng Việt</a></li>
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('2')">Song ngữ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('3')">Tại chỗ - tiếng Anh</a></li>
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('4')">Tại chỗ - song ngữ</a></li>
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('5')">Trực tiếp</a></li>
                    </ul>
                </div>
            </div>
        @endcan
    </div> --}}
    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table text-center table-striped table-hover caption-top" style="width:1500px">
                        <caption>Danh sách hợp đồng
                            @can('create_contracts')
                                <div class="btn-group d-inline px-2">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><h6 class="dropdown-header">Tạo HĐ có sẵn file</h6></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('1')">Tiếng Việt</a></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('2')">Song ngữ</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('3')">Tại chỗ - tiếng Anh</a></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('4')">Tại chỗ - song ngữ</a></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalUploadHopDongCoFileSan" wire:click = "uploadHopDongCoFileSanModal('5')">Trực tiếp</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalAnnexDESIPRO" wire:click = "createAnnexDESIPRO('3')">Annex DESIPRO</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group d-inline px-2">
                                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                        + NĐ
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalNDTV" wire:click = "createHopDongNoiDiaTiengViet()">Tiếng Việt</a></li>
                                    <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalNDSNTV" wire:click = "createHopDongNoiDiaSongNgu()">Song ngữ</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group d-inline px-2">
                                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                        + XK
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalXKTCTA" wire:click = "createHopDongXuatKhauTaiChoTiengAnh()">Tại chỗ - tiếng Anh</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalXKTCSNTV" wire:click = "createHopDongXuatKhauTaiChoSongNgu()">Tại chỗ - song ngữ</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalXKTT" wire:click = "createHopDongXuatKhauTrucTiep()">Trực tiếp</a></li>
                                    </ul>
                                </div>
                            @endcan
                        </caption>
                        <thead>
                            <th scope="col">Số HĐ.</th>
                            <th scope="col">Loại HĐ.</th>
                            <th scope="col">Bên B.</th>
                            <th scope="col">Tình trạng.</th>
                            <th scope="col">Người tạo.</th>
                            <th scope="col">Ngày hết hạn.</th>
                            <th scope="col">Thời gian tạo.</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach (session('main') as $item)
                                <tr>
                                <td>
    
                                    @if ($item->loaihopdong == '1' || $item->loaihopdong == '2')
                                        
                                        {{ substr($item->sohd,4,5) . '/HĐMB-' . substr($item->sohd,0,4) }}
    
                                    @else
    
                                        {{ str_replace('_','/',$item->sohd) }}
    
                                    @endif
    
                                </td>
                                <td>
                                    @if ($item->loaihopdong == '1')
                                        {{ 'Nội địa' }}
                                    @elseif ($item->loaihopdong == '2')
                                        {{ 'Nội địa S.N' }}
                                    @elseif ($item->loaihopdong == '3')
                                        {{ 'XKTC T.A' }}
                                    @elseif ($item->loaihopdong == '4')
                                        {{ 'XKTC S.N' }}
                                    @elseif ($item->loaihopdong == '5')
                                        {{ 'XKTT' }}
                                    @endif
                                </td>
                                <td>{{ $item->ten_tv }}</td>
                                <td 
                                @if ($item->tinhtrang == 'New')
                                    style="color: #0000FF"
                                @elseif($item->tinhtrang == 'Processing')
                                    style="color: #DC7633"
                                @elseif($item->tinhtrang == 'Approved')
                                    style="color: #239B56"
                                @elseif($item->tinhtrang == 'Scanned file received')
                                    style="color: #8E44AD"
                                @elseif($item->tinhtrang == 'Success')
                                    style="color: #229954"
                                @endif class="fw-bolder">{{ $item->tinhtrang }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->ngayhethanhd }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td style="width:100px">
                                    <div class="btn-group" style="margin-right: 3px">
                                        <a href="" wire:click="chiTietHopDong('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalChiTietHopDong"><i class="fa-regular fa-file-lines fa-2xl"></i></a>
                                    </div>
                                    <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-sharp fa-solid fa-bars"></i>
                                    </button>
                                    <ul class="dropdown-menu">
    
                                        <li><a class="dropdown-item" wire:click="taifileHD('{{ $item->sohd }}', '{{ $item->sohd . '.docx' }}')"><i class="fa-sharp fa-solid fa-download" style="color:#00AAEE"></i> Download</a></li>
                                        
                                        @can('edit_contracts')
                                            @if ($item->tinhtrang == 'New')
    
                                                @if ($item->loaihopdong == '1')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongNoiDiaTiengViet({{ $item->sohd }})" data-bs-toggle="modal" data-bs-target="#ModalNDTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                                
                                                @elseif($item->loaihopdong == '2')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongNoiDiaSongNgu({{ $item->sohd }})" data-bs-toggle="modal" data-bs-target="#ModalNDSNTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                                
                                                @elseif ($item->loaihopdong == '3')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTaiChoTiengAnh('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTCTA"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                            
                                                @elseif($item->loaihopdong == '4')
                
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTaiChoSongNgu('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTCSNTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                
                                                @elseif($item->loaihopdong == '5')
                
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTrucTiep('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTT"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                                
                                                @endif
    
                                                <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="deleteConfirm('{{ $item->sohd }}', '{{ $item->loaihopdong }}')" data-bs-toggle="modal" data-bs-target="#ModalXoa"><i class="fa-sharp fa-solid fa-trash-can" style="color: red"></i> Xóa</a></li>
                                        
                                            @elseif ($item->tinhtrang == 'Approved')
                                                    
                                                <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="uploadFileScanModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalUpFileScan"><i class="fa-sharp fa-solid fa-file-arrow-up" style="color:#3498DB"></i> Tải lên file scan</a></li>
    
                                            @elseif ($item->tinhtrang == 'Scanned file received')
            
                                                <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="uploadFileRootModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalUpFileRoot"><i class="fa-sharp fa-solid fa-file-arrow-up" style="color:#E74C3C"></i> Tải lên file gốc</a></li>
    
                                            @elseif ($item->tinhtrang == 'Rejected')
                                                    
                                                @if ($item->loaihopdong == '1')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongNoiDiaTiengViet({{ $item->sohd }})" data-bs-toggle="modal" data-bs-target="#ModalNDTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                            
                                                @elseif($item->loaihopdong == '2')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongNoiDiaSongNgu({{ $item->sohd }})" data-bs-toggle="modal" data-bs-target="#ModalNDSNTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                                
                                                @elseif ($item->loaihopdong == '3')
    
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTaiChoTiengAnh('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTCTA"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                            
                                                @elseif($item->loaihopdong == '4')
                
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTaiChoSongNgu('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTCSNTV"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                
                                                @elseif($item->loaihopdong == '5')
                
                                                    <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="editHopDongXuatKhauTrucTiep('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalXKTT"><i class="fa-solid fa-pencil" style="color:coral"></i> Sửa HĐ</a></li>
                                                
                                                @endif
    
                                            @endif
                                        @endcan

                                        @can('approve_1_contracts')
                                            @if ($item->tinhtrang == 'New')
                                                <li><a class="dropdown-item" href="" wire:click.prevent="approve1('{{ $item->sohd }}')"><i class="fa-sharp fa-solid fa-check-double" style="color:#27AE60"></i></i> Approve</a></li>
                                                <li><a class="dropdown-item" href="" wire:click.prevent="rejectModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i></i> Reject</a></li>
                                            @elseif($item->tinhtrang == 'Processing')
                                                <li><a class="dropdown-item" href="" wire:click.prevent="rollback('{{ $item->sohd }}')"><i class="fa-solid fa-rotate-left" style="color: #27AE60"></i></i> Rollback</a></li>
                                            @endif
                                        @endcan

                                        @can('approve_contracts')
                                            @if ($item->tinhtrang == 'Processing')
                                                <li><a class="dropdown-item" href="" wire:click.prevent="approve('{{ $item->sohd }}')"><i class="fa-sharp fa-solid fa-check-double" style="color:#27AE60"></i></i> Approve</a></li>
                                                <li><a class="dropdown-item" href="" wire:click.prevent="rejectModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa-solid fa-ban"></i></i> Reject</a></li>
                                            @elseif($item->tinhtrang == 'Approved')
                                                <li><a class="dropdown-item" href="" wire:click.prevent="rollback('{{ $item->sohd }}')"><i class="fa-solid fa-rotate-left" style="color: #27AE60"></i></i> Rollback</a></li>
                                            @endif
                                        @endcan
                                        @role('super_admin')
                                            <li><a class="dropdown-item" href="" wire:click.prevent="rollback('{{ $item->sohd }}')"><i class="fa-solid fa-rotate-left" style="color: #27AE60"></i></i> Rollback</a></li>
                                        @endrole
                                        <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="uploadFilePhuLucModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalUpFilePhuLuc"><i class="fa-sharp fa-solid fa-file-arrow-up" style="color:#3498DB"></i> Tải lên phụ lục hợp đồng</a></li>
                                        {{-- <li><a class="dropdown-item {{ Auth::user()->username == $item->username ? '' : 'disabled' }}" href="" wire:click.prevent="uploadFileTDGModal('{{ $item->sohd }}')" data-bs-toggle="modal" data-bs-target="#ModalUpFileTDG"><i class="fa-sharp fa-solid fa-file-arrow-up" style="color:brown"></i> Tải lên file TDG</a></li> --}}
    
                                    </ul>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="float-start">
                <select class="form-select" wire:model="paginate">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                </select>
            </div>
            <div class="float-end">
                {{ session('main')->links() }}
            </div>
        </div>
    </div>
</div>
</div>
{{-- <li><a class="dropdown-item" href="{{ Storage::url($item->sohd . '.html') }}" target="_blank"><i class="fa-solid fa-eye" style="color:darkslategray"></i> Xem HĐ</a></li> --}}