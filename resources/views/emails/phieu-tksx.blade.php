@if ($type == 'Rollback')
    <p>{{ 'Số phiếu : ' . $soPhieuOutlook }}</p>
    <p>{{ 'Người từ chối : ' . $usernameOutlook }}</p>
    <p>{{ 'Thời gian : ' . $timeOutlook }}</p> 
    <p>{{ 'Lý do : ' . $lyDoRollback }}</p> 
@elseif ($type == 'New')
    <p>{{ 'Số phiếu : ' . $soPhieuOutlook }}</p>
    <p>{{ 'Người tạo : ' . $usernameOutlook }}</p>
    <p>{{ 'Thời gian : ' . $timeOutlook }}</p> 
@else
    <p>{{ 'Số phiếu : ' . $soPhieuOutlook }}</p>
    <p>{{ 'Người duyệt : ' . $usernameOutlook }}</p>
    <p>{{ 'Thời gian : ' . $timeOutlook }}</p> 
@endif

<a href="http://quanly.soitheky.com.vn">Nhấp vào link để mở website.</a> 