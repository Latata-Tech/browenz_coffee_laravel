@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center"
         style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('sellings')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>
            Detail Penjualan</h4>
    </div>
    <div class="row">
        <div class="col-10">
            <div class="card w-100">
                <div class="card-body">
                    <table class="w-100">
                        <tr>
                            <th>Tanggal</th>
                            <td>:</td>
                            <td>{{\Illuminate\Support\Carbon::createFromDate($order->created_at)->format('d-m-Y')}}</td>
                            <th>Tipe Pembayaran</th>
                            <td>:</td>
                            <td>{{$order->payment_type}}</td>
                        </tr>
                        <tr>
                            <th>No. Penjualan</th>
                            <td>:</td>
                            <td>{{$order->code}}</td>
                            <th>Kode Promo</th>
                            <td>:</td>
                            <td>{{$codePromo == "" ? '-' : $codePromo}}</td>
                            <th>Karyawan</th>
                            <td>:</td>
                            <td>{{$order->user->name}}</td>
                        </tr>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Banyaknya</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $index => $menu)

                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$menu->menu->name . ' (' . $menu->variant . ')'}}</td>
                                <td>{{$menu->qty}}</td>
                                <td>{{'Rp. ' . number_format($menu->variant === 'ice' ? $menu->menu->ice_price : $menu->menu->hot_price)}}</td>
                                <td>{{'Rp. ' . number_format(($menu->variant === 'ice' ? $menu->menu->ice_price : $menu->menu->hot_price) * $menu->qty)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" style="text-align: right">Diskon</th>
                            <td>{{'Rp. ' . number_format($order->discount)}}</td>
                        </tr>
                        <tr>
                            <th colspan="4" style="text-align: right">Total</th>
                            <td >{{'Rp. ' . number_format($order->total)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
