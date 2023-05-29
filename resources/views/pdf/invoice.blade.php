<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
            border-collapse: collapse;
        }

        td {
            padding: 3px;
        }
    </style>
</head>
<body>
<div style="text-align: center">
    <h3>BROWENZ COFFEE</h3>
</div>
<table style="width: 100%">
    <tr>
        <td colspan="2">{{$orderDate}}</td>
        <td style="text-align: right">{{$orderHour}}</td>
    </tr>
    <tr>
        <td colspan="2">Kasir</td>
        <td style="text-align: right">{{$cashier}}</td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 1px dashed;"></td>
    </tr>
    @foreach($detail as $data)
        <tr>
            <td>{{$data['name'] . '(' .$data['variant'].')'}}</td>
            <td>x{{$data['qty']}}</td>
            <td style="text-align: right">Rp. {{number_format($data['total'])}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="border-top: 1px dashed;"></td>
    </tr>
    <tr>
        <td colspan="2">Diskon</td>
        <td style="text-align: right">Rp. {{number_format($discount)}}</td>
    </tr>
    <tr>
        <td colspan="2">Total</td>
        <td style="text-align: right">Rp. {{number_format($total)}}</td>
    </tr>
</table>
<table>

</table>
</body>
</html>
