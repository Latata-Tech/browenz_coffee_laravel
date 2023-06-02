<table>
    <tr>
        <td colspan="7" rowspan="1" style="text-align: center; vertical-align: center;">LAPORAN TRANSAKSI {{$type === "in" ? "MASUK" : "KELUAR"}} BAHAN BAKU {{$time}}</td>
    </tr>
    <tr>
    </tr>
    <thead>
    <tr>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Nama</th>
        <th>Satuan</th>
        <th>Keluar</th>
        <th>Stok Sekarang</th>
    </tr>
    </thead>
    <tbody>
    @dd($data)
    @foreach($data as $index => $value)
        @foreach($value[array_keys($value)[0]] as $key => $detail)
            @if($key === 0)
                <tr>
                    <td rowspan="{{count($value[array_keys($value)[0]])}}" style="vertical-align: top">{{$index+1}}</td>
                    <td rowspan="{{count($value[array_keys($value)[0]])}}" style="vertical-align: top">{{array_keys($value)[0]}}</td>
                    <td>{{$detail['name']}}</td>
                    <td>{{$detail['type']}}</td>
                    <td>{{$detail[$type]}}</td>
                    <td>{{$detail['current']}}</td>
                </tr>
            @else
                <tr>
                    <td>{{$detail['name']}}</td>
                    <td>{{$detail['type']}}</td>
                    <td>{{$detail[$type]}}</td>
                    <td>{{$detail['current']}}</td>
                </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
</table>
