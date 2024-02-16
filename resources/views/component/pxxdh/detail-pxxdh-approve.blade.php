@php
    use Carbon\Carbon;
@endphp
<div class="row mb-2">
    <div class="col">
        <div class="shadow p-3 bg-body-tertiary rounded">
            <div class="row mb-2">
                <div class="col-8">
                    @if ($checkPhieuXXDHHasRollback != '' && $soCone != $soConeLog)
                        <label for="soCone" class="form-label" style="color:red">Số cone</label>
                    @else
                        <label for="soCone" class="form-label">Số cone</label>
                    @endif
                    <input type="text" class="form-control" id="soCone" placeholder="Số cone" wire:model.defer="soCone">
                </div>
                <div class="col-4">
                    @if ($checkPhieuXXDHHasRollback != '' && $soKgCone != $soKgConeLog)
                        <label for="soKgCone" class="form-label" style="color:red">Số kg/cone</label>
                    @else
                        <label for="soKgCone" class="form-label">Số kg/cone</label>
                    @endif
                    <input type="text" class="form-control" id="soKgCone" placeholder="Số kg/cone" wire:model.defer="soKgCone">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    @if ($checkPhieuXXDHHasRollback != '' && $Line != $LineLog)
                        <label for="Line" class="form-label" style="color:red">Nơi sản xuất dự kiến - Line</label>
                    @else
                        <label for="Line" class="form-label">Nơi sản xuất dự kiến - Line</label>
                    @endif
                    <input type="text" class="form-control" id="Line" placeholder="Line" wire:model.defer="Line">
                </div>
                <div class="col-6">
                    
                    @if ($checkPhieuXXDHHasRollback != '' && $May != $MayLog)
                        <label for="May" class="form-label" style="color:red">Máy</label>
                    @else
                        <label for="May" class="form-label">Máy</label>
                    @endif
                    <input type="text" class="form-control" id="May" placeholder="Máy" wire:model.defer="May">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    @if ($checkPhieuXXDHHasRollback != '' && $ngayGiaoHang != $ngayGiaoHangLog)
                    <label for="ngayGiaoHang" class="form-label" style="color:red">Ngày giao hàng :</label>
                    @else
                    <label for="ngayGiaoHang" class="form-label">Ngày giao hàng :</label>
                    @endif
                    @if ($status == 'New')
                        <input type="date" class="form-control" id="ngayGiaoHang" wire:model.defer="ngayGiaoHang">
                    @else
                        @if ($ngayGiaoHang != '')
                            <p>{{ Carbon::create($ngayGiaoHang)->isoFormat('DD-MM-YYYY') }}</p> 
                        @endif
                    @endif
                </div>
                <div class="col-6">
                    @if ($checkPhieuXXDHHasRollback != '' && $ngayBatDauGiao != $ngayBatDauGiaoLog)
                        <label for="ngayBatDauGiao" class="form-label" style="color:red">Ngày bắt đầu giao (nếu có) :</label>
                    @else
                        <label for="ngayBatDauGiao" class="form-label">Ngày bắt đầu giao (nếu có) :</label>
                    @endif
                    @if ($status == 'New')
                        <input type="date" class="form-control" id="ngayBatDauGiao" wire:model.defer="ngayBatDauGiao">
                    @else
                        @if ($ngayBatDauGiao != '')
                            <p>{{ Carbon::create($ngayBatDauGiao)->isoFormat('DD-MM-YYYY') }}</p>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    @if ($checkPhieuXXDHHasRollback != '' && $thanhPhamCuaKhachHang != $thanhPhamCuaKhachHangLog)
                    <label for="thanhPhamCuaKhachHang" class="form-label" style="color:red">Thành phẩm của khách hàng</label>
                    @else
                    <label for="thanhPhamCuaKhachHang" class="form-label">Thành phẩm của khách hàng</label>
                    @endif
                    
                    <input type="text" class="form-control" id="thanhPhamCuaKhachHang" placeholder="Thành phẩm của khách hàng" wire:model.defer="thanhPhamCuaKhachHang">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    @if ($checkPhieuXXDHHasRollback != '' && $phanAnhCuaKhachHang != $phanAnhCuaKhachHangLog)
                    <label for="phanAnhCuaKhachHang" class="form-label" style="color:red">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                    @else
                    <label for="phanAnhCuaKhachHang" class="form-label">Phản ánh của khách hàng về lot cũ đã đặt hàng (nếu có)</label>
                    @endif
                    
                    <textarea class="form-control" id="phanAnhCuaKhachHang" cols="30" rows="3" placeholder="Phản ánh của khách hàng" wire:model.defer="phanAnhCuaKhachHang"></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    @if ($checkPhieuXXDHHasRollback != '' && $thongTinDongGoi != $thongTinDongGoiLog)
                    <label class="form-label" style="color:red">Thông tin đóng gói</label>
                    @else
                    <label class="form-label">Thông tin đóng gói</label>
                    @endif
                    
                    <textarea class="form-control" cols="30" rows="3" placeholder="Thông tin đóng gói" wire:model.defer="thongTinDongGoi"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>