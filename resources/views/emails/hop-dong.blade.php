@if ($typeOutlook == 'created')
    @if ($loaihopdongOutlook == '1' || $loaihopdongOutlook == '2')
        <p>Contract No : {{ substr($sohdOutlook,4,5) . '/HĐMB-' . substr($sohdOutlook,0,4) }}</p>
    @else
        <p>Contract No : {{ $sohdOutlook }}</p>
    @endif
    <p>Creator : {{ $usernameOutlook }}</p>
    <p>Creation time : {{ $timeOutlook }}</p>
@elseif ($typeOutlook == 'processing')
    @if ($loaihopdongOutlook == '1' || $loaihopdongOutlook == '2')
        <p>Contract No : {{ substr($sohdOutlook,4,5) . '/HĐMB-' . substr($sohdOutlook,0,4) }}</p>
    @else
        <p>Contract No : {{ $sohdOutlook }}</p>
    @endif
    <p>Approved by : {{ $usernameOutlook }}</p>
    <p>Approved at : {{ $timeOutlook }}</p> 
@elseif ($typeOutlook == 'approved')
    @if ($loaihopdongOutlook == '1' || $loaihopdongOutlook == '2')
        <p>Contract No : {{ substr($sohdOutlook,4,5) . '/HĐMB-' . substr($sohdOutlook,0,4) }}</p>
    @else
        <p>Contract No : {{ $sohdOutlook }}</p>
    @endif
    <p>Approved by : {{ $usernameOutlook }}</p>
    <p>Approved at : {{ $timeOutlook }}</p> 
@elseif ($typeOutlook == 'rejected')
    @if ($loaihopdongOutlook == '1' || $loaihopdongOutlook == '2')
        <p>Contract No : {{ substr($sohdOutlook,4,5) . '/HĐMB-' . substr($sohdOutlook,0,4) }}</p>
    @else
        <p>Contract No : {{ $sohdOutlook }}</p>
    @endif
    <p>Rejected by : {{ $usernameOutlook }}</p>
    <p>Rejected at : {{ $timeOutlook }}</p> 
    <p>Rejected reason : {{ $lydoOutlook }}</p> 
@endif

<a href="http://quanly.soitheky.com.vn/hop-dong">Link to Approve.</a>