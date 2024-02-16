<style>
    table, th, td {
        border: 1px solid;
        border-collapse: collapse;
        padding: 10px;
    }
    th {height: 40px}
</style>
<h3>Danh sách hợp đồng bị quá hạn nhận hợp đồng gốc</h3>
<table>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Số hợp đồng</th>
            <th scope="col">Sale</th>
            <th scope="col">Ngày up bản scan</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0;
            use Carbon\Carbon;
        @endphp
        @foreach ($hopdong as $item)
            <tr>
                <td>{{ $count = $count + 1 }}</td>
                <td>{{ substr($item->sohd,4,5) . '/HĐMB-' . substr($item->sohd,0,4) }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ Carbon::create($item->updated_at)->format('d-m-Y H:m:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
