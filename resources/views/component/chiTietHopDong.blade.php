<div wire:ignore.self class="modal" id="ModalChiTietHopDong" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Chi tiết HĐ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
        </div>
            @if ($hopdong != null)
                <div class="modal-body">
                    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <div class="row mb-3" style="margin-top: 10px">
                            <div class="col">
                                @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2')
                                    <h3>Thông tin hợp đồng - {{ substr($hopdong->sohd,4,5) . '/HĐMB-' . substr($hopdong->sohd,0,4) }}</h3>
                                @else
                                    <h3>Thông tin hợp đồng - {{ str_replace('_', '/',$hopdong->sohd) }}</h3>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 g-4">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-12 col-lg-6">
                                                <p class="fw-semibold d-inline">Loại HĐ : </p>
                                                <p class="card-text d-inline">{{ $hopdong->tenhopdong }}</p>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <p class="fw-semibold d-inline">Ngày lập HĐ : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ngaylaphd }}</p>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <p class="fw-semibold d-inline">Tình trạng : </p>
                                                <p class="card-text d-inline">{{ $hopdong->tinhtrang }}</p>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <p class="fw-semibold d-inline">Người tạo : </p>
                                                <p class="card-text d-inline">{{ $hopdong->username }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Số tài khoản : </p>
                                                <p class="card-text d-inline">{{ $hopdong->sotaikhoan }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Chủ tài khoản : </p>
                                                <p class="card-text d-inline">{{ $hopdong->chutaikhoan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder pb-2 text-decoration-underline">Bên A</h5>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Tên công ty : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_a_vs_hop_dong_ten_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Địa chỉ : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_a_vs_hop_dong_dia_chi_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Mã số thuế : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_a_vs_hop_dong_ma_so_thue_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Điện thoại : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_a_vs_hop_dong_dien_thoai_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Fax : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_a_vs_hop_dong_fax_tv }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h5 class="card-title fw-bolder pb-2 text-decoration-underline">Bên B - Mã khách hàng : {{ $hopdong->ben_b_vs_hop_dong_ma_khach_hang }}</h5>
                                        <div class="row g-3">
                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2' || $hopdong->loaihopdong == '4')
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Tên công ty : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_ten_tv }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Địa chỉ : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_dia_chi_tv }}</p>
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Tên công ty : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_ten_ta }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Địa chỉ : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_dia_chi_ta }}</p>
                                                </div>
                                            @endif
                                            
                                            
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Mã số thuế : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_ma_so_thue_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Điện thoại : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_dien_thoai_tv }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-semibold d-inline">Fax : </p>
                                                <p class="card-text d-inline">{{ $hopdong->ben_b_vs_hop_dong_fax_tv }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 g-4">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder pb-2 text-decoration-underline">Sản phẩm</h5>
                                        <div class="row g-2">
                                            @if ($hopdong->loaihopdong == '2' || $hopdong->loaihopdong == '4')
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Tỷ giá : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->tygia }}</p>
                                                </div>
                                            @endif
                                            @if ($hopdong->loaihopdong == '3' || $hopdong->loaihopdong == '5')
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Chất lượng : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->chatluong_ta }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Đóng gói : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->donggoi_ta }}</p>
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Chất lượng : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->chatluong }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Đóng gói : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->donggoi }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="overflow-auto" style="height :500px">
                                            @for ($i=1; $i <16 ; $i++)
                                                @if ($sanpham->{'quycach'.$i} != '' && $sanpham->{'soluong'.$i} != '' && $sanpham->{'dongia'.$i} != '')
                                                    <hr width="40%">
                                                    <div class="row g-3">    
                                                        <div class="col-12">
                                                            <p class="fw-semibold d-inline">Quy cách : </p>
                                                            <p class="card-text d-inline">{{ $sanpham->{'quycach'.$i} }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="fw-semibold d-inline">Số lượng : </p>
                                                            <p class="card-text d-inline">{{ number_format($sanpham->{'soluong'.$i}) }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="fw-semibold d-inline">Đơn giá : </p>
                                                            <p class="card-text d-inline">{{ $sanpham->{'dongia'.$i} }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h5 class="card-title fw-bolder text-decoration-underline">Thông tin thanh toán</h5>
                                        <div class="overflow-auto" style="height :530px">
                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2' || $hopdong->loaihopdong == '4')
                                                <div class="row g-3 mb-3">
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Thời gian thanh toán : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->thoigianthanhtoan }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phương thức thanh toán : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phuongthucthanhtoan }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Địa điểm giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->diadiemgiaohang }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Địa chỉ : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->diachi_diadiemgiaohang }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Thời gian giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->thoigiangiaohang }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phương thức giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phuongthucgiaohang }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Giao hàng từng phần : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->giaohangtungphan }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phí vận chuyển : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phivanchuyen }}</p>
                                                    </div>
                                                </div>  
                                            @else
                                                <div class="row g-3 mb-3">
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Thời gian thanh toán : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->thoigianthanhtoan_ta }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phương thức thanh toán : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phuongthucthanhtoan_ta }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Địa điểm giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->diadiemgiaohang_ta }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Địa chỉ : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->diachi_diadiemgiaohang_ta }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Thời gian giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->thoigiangiaohang }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phương thức giao hàng : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phuongthucgiaohang_ta }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Giao hàng từng phần : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->giaohangtungphan }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="fw-semibold d-inline">Phí vận chuyển : </p>
                                                        <p class="card-text d-inline">{{ $hopdong->phivanchuyen_ta }}</p>
                                                    </div>
                                                </div> 
                                            @endif
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">PO : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->po }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">CPT : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->cpt }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">ransshipment : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->trungchuyen }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Loading Port : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->loadingport }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="fw-semibold d-inline">Discharging Port : </p>
                                                    <p class="card-text d-inline">{{ $hopdong->dischargport }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder pb-2 text-decoration-underline">Quản lý File HĐ - File TDG</h5>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($danhsachfileHD as $item)
                                                    <tr>
                                                        <td>
                                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2')
                                                                {{ str_replace('HD/' . $hopdong->sohd . '/', '', $item) }}
                                                            @else
                                                                {{ str_replace('HD/' . str_replace('/','_',$hopdong->sohd) . '/', '', $item) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2')
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="taifileHD('{{ $hopdong->sohd }}', '{{ str_replace('HD/' . $hopdong->sohd . '/', '', $item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            @else
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="taifileHD('{{ $hopdong->sohd }}', '{{ str_replace('HD/' . str_replace('/','_',$hopdong->sohd) . '/', '', $item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if (!empty($hopdong->so_tdg))
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Số TDG</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (explode(",", str_replace(' ', '', $hopdong->so_tdg)) as $item)
                                                        <tr>
                                                            <td>
                                                                {{ $item }}
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="taifileTDG('{{ $item }}')"><i class="fa-solid fa-download"></i></a>
                                                            </td>
                                                        </tr>      
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder pb-2 text-decoration-underline">Quản lý File Phụ Lục</h5>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tên file</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($danhsachfilePhuluc as $item)
                                                    <tr>
                                                        <td>
                                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2')
                                                                {{ str_replace('Addendum/' . $hopdong->sohd . '/', '', $item) }}
                                                            @else
                                                                {{ str_replace('Addendum/' . str_replace('/','_',$hopdong->sohd) . '/', '', $item) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2')
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="taifilePhuluc('{{ $hopdong->sohd }}', '{{ str_replace('Addendum/' . $hopdong->sohd . '/', '', $item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            @else
                                                                <a class="btn btn-primary btn-sm float-end" wire:click="taifilePhuluc('{{ $hopdong->sohd }}', '{{ str_replace('Addendum/' . str_replace('/','_',$hopdong->sohd) . '/', '', $item) }}')"><i class="fa-solid fa-download"></i></a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            @else
                <div class="row" style="padding: 40px">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                    </div>
                    <div class="col-1"></div>
                </div>
            @endif
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="resetInputField()">Đóng</button>
          <button type="button" class="btn btn-primary" wire:click="delete">Thực hiện</button>
        </div>
      </div>
    </div>
</div>
    