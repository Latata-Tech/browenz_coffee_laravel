<table>
    <tr>
        <td colspan="7" rowspan="2" style="text-align: center; vertical-align: center;">LAPORAN TRANSAKSI {{$type === "in" ? "Masuk" : "Keluar"}} BAHAN BAKU {{$time}}</td>
    </tr>
    <tr>
    </tr>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Satuan</th>
        <th>Stok Sebelum</th>
        <th>Keluar</th>
        <th>Stok Sekarang</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $index => $transaction)
        @foreach($transaction->detail as $pos => $detail)
            @if($pos === 0)
                <tr>
                    <td rowspan="{{$transaction->detail->count()}}">{{$index+1}}</td>
                    <td rowspan="{{$transaction->detail->count()}}">{{$transaction->code}}</td>
                    <td>{{$detail->ingredient->name}}</td>
                    <td>{{$detail->ingredient->type->name}}</td>
                    @if($typeFilter === "daily")
                        <td>{{$detail->ingredient->history->whereBetween(\Illuminate\Support\Facades\DB::raw(), $start_date)}}</td>
                    @elseif($typeFilter === "monthly")
                    @elseif($typeFilter === "yearly")
                </tr>
            @else
            @endif

        @endforeach

    @endforeach
    <tr>
        <td></td>
    </tr>
    </tbody>
</table>
