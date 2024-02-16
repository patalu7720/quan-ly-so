{!! nl2br($contentOutlook) !!}
@if ($statusOutlook == 'Approve 1')
    <a href="http://quanly.soitheky.com.vn/ttdh-duyet/1/{{ $soPhieuOutlook }}">Nhấp vào link để duyệt</a><br /><br />
    <a href="http://quanly.soitheky.com.vn/ttdh-tu-choi/1/{{ $soPhieuOutlook }}">Nhấp vào link để từ chối</a><br /><br />
@elseif ($statusOutlook == 'Approve 2')
    <a href="http://quanly.soitheky.com.vn/ttdh-duyet/2/{{ $soPhieuOutlook }}">Nhấp vào link để duyệt</a><br /><br />
    <a href="http://quanly.soitheky.com.vn/ttdh-tu-choi/2/{{ $soPhieuOutlook }}">Nhấp vào link để từ chối</a><br /><br />
@elseif ($statusOutlook == 'Approve 3')
    <a href="http://quanly.soitheky.com.vn/ttdh-duyet/3/{{ $soPhieuOutlook }}">Nhấp vào link để duyệt</a><br /><br />
    <a href="http://quanly.soitheky.com.vn/ttdh-tu-choi/3/{{ $soPhieuOutlook }}">Nhấp vào link để từ chối</a><br /><br />
@endif

@if ($statusOutlook == 'Reject')
    <span>Lý do từ chối : {{ $reasonRejectOutlook }}</span><br />
    <span>Tại cấp duyệt : {{ $levelRejectOutlook }}</span><br />
@endif

<span style="color: #0431B4;font-size:16px">Best Regards.</span>