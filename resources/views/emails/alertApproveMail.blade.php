@if ($loaihopdong == '1' || $loaihopdong == '2')
<p>Số hợp đồng : {{ substr($sohd,4,5) . '/HĐMB-' . substr($sohd,0,4) }} đã được duyệt.</p>
@else
<p>Số hợp đồng : {{ $sohd }} đã được duyệt.</p>
@endif

