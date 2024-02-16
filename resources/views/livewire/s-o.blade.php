<div class="container" style="margin-top: 10px"> 

    @include('component.so.detail')
    @include('component.so.detail-hop-dong')
    @include('component.so.detail-pxxdh')
    @include('component.so.detail_ptksx')
    @include('component.so.detail-file')

    <div class="shadow-lg p-3 mb-3 bg-body-tertiary rounded">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control" placeholder="Nhập từ khóa (vd: Số HĐ, Tên KH, Username...)" wire:model.debounce.500ms="search" wire:model.defer="search">
                </div>
            </div>
        </div>
    </div>
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle caption-top" style="width:1220px">
                        <caption>Danh sách SO</caption>
                        <thead class="text-center align-middle table-light">
                            <tr style="height: 50px">
                                <th scope="col" style="width:130px">Số SO</th>
                                <th scope="col" style="width:130px">Hợp đồng</th>
                                <th scope="col" style="width:130px">Phiếu XXDH</th>
                                <th scope="col" style="width:130px">Phiếu TKSX</th>
                                <th scope="col" style="width:100px">Booking</th>
                                <th scope="col" style="width:100px">LC</th>
                                <th scope="col" style="width:100px">Chứng từ hải quan</th>
                                <th scope="col" style="width:100px">Phiếu xuất kho</th>
                                <th scope="col" style="width:100px">CO</th>
                                <th scope="col" style="width:100px">Tờ Khai Xuất Hàng</th>
                                <th scope="col" style="width:100px">Tài liệu cố định</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session('main') as $item)
                                <tr style="height: 10px">
                                    <td >
                                        <p><a class="link-opacity-10 fw-bold" href="{{ route('so-file', $item->so) }}" style="text-decoration:none; color:chocolate">{{ $item->so }}</a></p>
                                    </td>
                                    <td>
                                        @php
                                            $list_hop_dong = explode(',', $item->hop_dong);
                                        @endphp
                                        @foreach ($list_hop_dong as $hd)
                                            <p><a class="link-opacity-10" href="#" wire:click="detailHopDongModal('{{ $hd }}')" data-bs-toggle="modal" data-bs-target="#detailHopDongModal" style="text-decoration:none">{{ $hd }}</a></p>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- @if ($item->status_phieu_xxdh == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @elseif ($item->status_phieu_xxdh == '0')
                                            <i class="fa-regular fa-square-check fa-xl" style="color:orange"></i>
                                        @elseif ($item->status_phieu_xxdh == '1')
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif --}}
                                        <p><a class="link-opacity-10" href="#" wire:click="detailPhieuXXDHModal('{{ $item->phieu_xxdh }}')" data-bs-toggle="modal" data-bs-target="#detailPhieuXXDHModal" style="text-decoration:none">{{ $item->phieu_xxdh }}</a></p>
                                    </td>
                                    <td>
                                        {{-- @if ($item->status_phieu_tksx == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @elseif ($item->status_phieu_tksx == '0')
                                            <i class="fa-regular fa-square-check fa-xl" style="color:orange"></i>
                                        @elseif ($item->status_phieu_tksx == '1')
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif --}}
                                        @php
                                            $list_tksx = explode(',', $item->phieu_tksx);
                                        @endphp
                                        @foreach ($list_tksx as $tksx)
                                            <p><a class="link-opacity-10" href="#" wire:click="detailPhieuTKSXModal('{{ $tksx }}')" data-bs-toggle="modal" data-bs-target="#detailPhieuTKSXModal" style="text-decoration:none">{{ $tksx }}</a></p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($item->bk == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->lc == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->cthq == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->pxk == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->co == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tkxh == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tlcd == '')
                                            <i class="fa-regular fa-square fa-xl" style="color: gray"></i>
                                        @else
                                            <i class="fa-solid fa-square-check fa-xl" style="color:green"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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