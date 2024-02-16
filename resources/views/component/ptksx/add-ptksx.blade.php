<form wire:submit.prevent="addPhieuMHDTY">
    <div class="row">
      <div class="col">
        <div wire:ignore.self class="modal" id="addPhieuMHDTYModal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tạo phiếu thông báo thay đổi mã hàng DTY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="resetInputField()"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <div class="shadow p-3 bg-body-tertiary rounded">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="phieuTheoDon" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadio1">Theo đơn</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="phieuDukien" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadio2">Dự kiến</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="phieuDungMay" wire:model="theodon_dukien">
                                            <label class="form-check-label" for="inlineRadio3">Stop máy</label>
                                        </div>
                                    </div>
                                </div>

                                @if ($theodon_dukien == 'phieuDungMay')
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="soMay" class="form-label">Số Máy</label>
                                            <select class="form-select" id="soMay" wire:model.defer="soMay" required>
                                                <option value=''>Chọn sô máy</option>
                                                <option value='1'>1</option>
                                                <option value='2'>2</option>
                                                <option value='3'>3</option>
                                                <option value='4'>4</option>
                                                <option value='5'>5</option>
                                                <option value='6'>6</option>
                                                <option value='7'>7</option>
                                                <option value='8'>8</option>
                                                <option value='9'>9</option>
                                                <option value='10'>10</option>
                                                <option value='11'>11</option>
                                                <option value='12'>12</option>
                                                <option value='13'>13</option>
                                                <option value='14'>14</option>
                                                <option value='15'>15</option>
                                                <option value='16'>16</option>
                                                <option value='17'>17</option>
                                                <option value='18'>18</option>
                                                <option value='19'>19</option>
                                                <option value='20'>20</option>
                                                <option value='21'>21</option>
                                                <option value='22'>22</option>
                                                <option value='23'>23</option>
                                                <option value='24'>24</option>
                                                <option value='25'>25</option>
                                                <option value='26'>26</option>
                                                <option value='27'>27</option>
                                                <option value='28'>28</option>
                                                <option value='29'>29</option>
                                                <option value='30'>30</option>
                                                <option value='31'>31</option>
                                                <option value='32'>32</option>
                                                <option value='33'>33</option>
                                                <option value='34'>34</option>
                                                <option value='35'>35</option>
                                                <option value='36'>36</option>
                                                <option value='37'>37</option>
                                                <option value='38'>38</option>
                                                <option value='39'>39</option>
                                                <option value='40'>40</option>
                                                <option value='41'>41</option>
                                                <option value='42'>42</option>
                                                <option value='43'>43</option>
                                                <option value='44'>44</option>
                                                <option value='45'>45</option>
                                                <option value='46'>46</option>
                                                <option value='47'>47</option>
                                                <option value='48'>48</option>
                                                <option value='49'>49</option>
                                                <option value='50'>50</option>
                                                <option value='51'>51</option>
                                                <option value='52'>52</option>
                                                <option value='53'>53</option>
                                                <option value='54'>54</option>
                                                <option value='55'>55</option>
                                                <option value='56'>56</option>
                                                <option value='57'>57</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="mat" class="form-label">Mặt</label>
                                            <select class="form-select" id="mat" wire:model.defer="mat">
                                                <option value=''>Chọn mặt</option>
                                                <option value='A'>A</option>
                                                <option value='B'>B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="quyCach" class="form-label">Mã hàng đang chạy</label>
                                            <input type="text" class="form-control" id="quyCach" placeholder="Quy cách" required wire:model.defer="quyCach">
                                        </div>
                                        <div class="col-6">
                                            <label for="maHang" class="form-label" style="color:white">|</label>
                                            <input type="text" class="form-control" id="maHang" placeholder="Mã" required wire:model.defer="maHang">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="ngay" class="form-label">Ngày</label>
                                            <input type="date" class="form-control" wire:model.defer="ngay">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Thông tin đổi mã</label>
                                            <input type="text" class="form-control" placeholder="Thông tin đổi mã" wire:model.defer="thongTinDoiMa">
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label" {{ $theodon_dukien == 'phieuTheoDon' ? 'required' : 'hidden' }}>Số SO</label>
                                            <input type="text" placeholder="Nhập số SO" class="form-control" wire:model="soSO" {{ $theodon_dukien == 'phieuTheoDon' ? 'required' : 'hidden' }}>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="soMay" class="form-label">Số Máy</label>
                                            <select class="form-select" id="soMay" wire:model.defer="soMay" required>
                                                <option value=''>Chọn sô máy</option>
                                                <option value='1'>1</option>
                                                <option value='2'>2</option>
                                                <option value='3'>3</option>
                                                <option value='4'>4</option>
                                                <option value='5'>5</option>
                                                <option value='6'>6</option>
                                                <option value='7'>7</option>
                                                <option value='8'>8</option>
                                                <option value='9'>9</option>
                                                <option value='10'>10</option>
                                                <option value='11'>11</option>
                                                <option value='12'>12</option>
                                                <option value='13'>13</option>
                                                <option value='14'>14</option>
                                                <option value='15'>15</option>
                                                <option value='16'>16</option>
                                                <option value='17'>17</option>
                                                <option value='18'>18</option>
                                                <option value='19'>19</option>
                                                <option value='20'>20</option>
                                                <option value='21'>21</option>
                                                <option value='22'>22</option>
                                                <option value='23'>23</option>
                                                <option value='24'>24</option>
                                                <option value='25'>25</option>
                                                <option value='26'>26</option>
                                                <option value='27'>27</option>
                                                <option value='28'>28</option>
                                                <option value='29'>29</option>
                                                <option value='30'>30</option>
                                                <option value='31'>31</option>
                                                <option value='32'>32</option>
                                                <option value='33'>33</option>
                                                <option value='34'>34</option>
                                                <option value='35'>35</option>
                                                <option value='36'>36</option>
                                                <option value='37'>37</option>
                                                <option value='38'>38</option>
                                                <option value='39'>39</option>
                                                <option value='40'>40</option>
                                                <option value='41'>41</option>
                                                <option value='42'>42</option>
                                                <option value='43'>43</option>
                                                <option value='44'>44</option>
                                                <option value='45'>45</option>
                                                <option value='46'>46</option>
                                                <option value='47'>47</option>
                                                <option value='48'>48</option>
                                                <option value='49'>49</option>
                                                <option value='50'>50</option>
                                                <option value='51'>51</option>
                                                <option value='52'>52</option>
                                                <option value='53'>53</option>
                                                <option value='54'>54</option>
                                                <option value='55'>55</option>
                                                <option value='56'>56</option>
                                                <option value='57'>57</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="mat" class="form-label">Mặt</label>
                                            <select class="form-select" id="mat" wire:model.defer="mat">
                                                <option value=''>Chọn mặt</option>
                                                <option value='A'>A</option>
                                                <option value='B'>B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="ngay" class="form-label">Sale</label>
                                            <select class="form-select" wire:model.defer="sale" required>
                                                <option value="">Chọn sale</option>
                                                @if ($danhSachMail != null)
                                                    @foreach ($danhSachMail as $item)
                                                        <option value="{{ $item->email }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="quyCach" class="form-label">Mã hàng đang chạy</label>
                                            <input type="text" class="form-control" id="quyCach" placeholder="Quy cách" required wire:model.defer="quyCach">
                                        </div>
                                        <div class="col-6">
                                            <label for="maHang" class="form-label" style="color:white">|</label>
                                            <input type="text" class="form-control" id="maHang" placeholder="Mã" required wire:model.defer="maHang">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="ngay" class="form-label">Ngày</label>
                                            <input type="date" class="form-control" wire:model.defer="ngay" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Thông tin đổi mã</label>
                                            <input type="text" class="form-control" placeholder="Thông tin đổi mã" wire:model.defer="thongTinDoiMa">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Màu ống</label>
                                            <input type="text" class="form-control" placeholder="Màu ống" wire:model.defer="mauOng">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Sợi (Đơn/Chập)</label>
                                            <input type="text" class="form-control" placeholder="Sợi (Đơn/Chập)" wire:model.defer="soi">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label">Mã cũ - mới</label>
                                            <input type="text" class="form-control" placeholder="Mã cũ - mới" wire:model.defer="maCuMoi">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <label for="quyCachPOY" class="form-label">Quy cách POY</label>
                                            <input type="text" class="form-control" id="quyCachPOY" placeholder="Quy cách POY" required wire:model.defer="quyCachPOY">
                                        </div>
                                        <div class="col-7">
                                            <label for="maPOY" class="form-label">Mã POY</label>
                                            <input type="text" class="form-control" id="maPOY" placeholder="Mã POY" required wire:model.defer="maPOY">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <label for="quyCachDTY" class="form-label">Quy cách DTY</label>
                                            <input type="text" class="form-control" id="quyCachDTY" placeholder="Quy cách DTY" required wire:model.defer="quyCachDTY">
                                        </div>
                                        <div class="col-7">
                                            <label for="maDTY" class="form-label">Mã DTY</label>
                                            <input type="text" class="form-control" id="maDTY" placeholder="Mã DTY" required wire:model.defer="maDTY">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="tenCongTy" class="form-label">Khách hàng</label>
                                            <input type="text" class="form-control" id="tenCongTy" placeholder="Tên công ty" wire:model.defer="tenCongTy">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="loaiHang" class="form-label">Loại hàng</label>
                                            <input type="text" class="form-control" id="loaiHang" placeholder="Loại hàng" required wire:model.defer="loaiHang">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="soLuongDonHang" class="form-label">Số lượng đơn hàng</label>
                                            <input type="text" class="form-control" id="soLuongDonHang" placeholder ="Số lượng đơn hàng" required wire:model.defer="soLuongDonHang">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="ghiChuSoLuong" class="form-label">Ghi chú số lượng</label>
                                            <input type="text" class="form-control" id="ghiChuSoLuong" placeholder ="Ghi chú" required wire:model.defer="ghiChuSoLuong">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="ngay" class="form-label">Lấy điều kiện của khách hàng</label>
                                            <select class="form-select" wire:model="dieuKienKhachHangSelect">
                                                <option value="">Chọn quy cách</option>
                                                @if ($danhSachDieuKienKhachHang != null)
                                                    @foreach ($danhSachDieuKienKhachHang as $item)
                                                        <option value="{{ $item->kieu_may_det . ' - ' . $item->thong_tin_dong_goi }}">{{ $item->quy_cach }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <textarea class="form-control" id="dieuKienKhachHang" placeholder ="Điều kiện của khách hàng" wire:model.defer="dieuKienKhachHang" cols="30" rows="5">{{ $dieuKienKhachHang }}</textarea>
                                        </div>
                                    </div>                                 
                                @endif
                            </div>
                        </div>
                    </div>
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