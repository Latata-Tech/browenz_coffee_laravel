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
    @foreach($data as $index => $value)
        @foreach($value->detail as $key => $detail)
            @if($key === 0)
                <tr>
                    <td rowspan="{{count($value->detail)}}" style="vertical-align: top">{{$index+1}}</td>
                    <td rowspan="{{count($value->detail)}}" style="vertical-align: top">{{$value->code}}</td>
                    <td>{{$detail->name}}</td>
                    <td>{{$detail->ingredient->type->name}}</td>
                    <td>{{$detail->histories->reverse()->first()->prev_stock}}</td>
                    <td>{{$detail->qty}}</td>
                </tr>
            @else
                <tr>
                    <td>{{$detail->name}}</td>
                    <td>{{$detail->ingredient->type->name}}</td>
                    <td>{{$detail->histories->reverse()->first()->prev_stock}}</td>
                    <td>{{$detail->qty}}</td>
                </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
</table>
