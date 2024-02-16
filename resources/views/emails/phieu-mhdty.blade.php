@if ($type == 'New')
    <p>{{ 'Số phiếu : ' . $soPhieuOutlook }}</p>
    <p>{{ 'Người tạo : ' . $usernameOutlook }}</p>
    <p>{{ 'Thời gian : ' . $timeOutlook }}</p> 
@else
    <p>{{ 'Số phiếu : ' . $soPhieuOutlook }}</p>
    <p>{{ 'Người duyệt : ' . $usernameOutlook }}</p>
    <p>{{ 'Thời gian : ' . $timeOutlook }}</p> 
@endif

<a href="http://quanly.soitheky.com.vn">Nhấp vào link để mở website.</a> 