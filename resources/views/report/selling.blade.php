<table>
    <tr>
        <th colspan="6" rowspan="2" style="text-align: center; vertical-align: center">LAPORAN PENJUALAN {{$tipe ?? ""}}</th>
    </tr>
    <tr></tr>
    <thead>
    <tr>
        <th>No</th>
        <th>Kode Penjualan</th>
        <th>Kasir</th>
        <th>Total Sebelum Diskon</th>
        <th>Diskon</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $total = 0;
        $totalDiscount = 0;
        $totalBeforeDiscount = 0;
    ?>
    @foreach($orders as $index => $order)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$order->code}}</td>
            <td>{{$order->user->name}}</td>
            <td>{{$order->total_before_discount}}</td>
            <td>{{$order->discount}}</td>
            <td>{{$order->total}}</td>
        </tr>
        <?php
            $total += $order->total;
            $totalDiscount += $order->discount;
            $totalBeforeDiscount += $order->total_before_discount;
            ?>
    @endforeach
    <tr>
        <th colspan="3" style="text-align: center">Total</th>
        <td>{{$totalBeforeDiscount}}</td>
        <td>{{$totalDiscount}}</td>
        <td>{{$total}}</td>
    </tr>
    </tbody>
</table>
