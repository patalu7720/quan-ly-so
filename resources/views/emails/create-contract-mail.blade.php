<div>
    @if ($loaihopdong == '1' || $loaihopdong == '2')
    <p>Contract No : {{ substr($sohd,4,5) . '/HĐMB-' . substr($sohd,0,4) }}</p>
    @else
    <p>Contract No : {{ $sohd }}</p>
    @endif

    <p>Creator : {{ $username }}</p>
    <p>Creation time : {{ $created_at }}</p>
</div>