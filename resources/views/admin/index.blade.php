@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="row row-col-4">
        <div class="col-md-4">
            @include('components.card-dashboard', ['title' => $orders, 'subtitle' => 'Jumlah pesanan hari ini', 'icon' => 'receipt'])
        </div>
        <div class="col-md-4">
            @include('components.card-dashboard', ['title' => 'Rp. '. number_format($totalDaily), 'subtitle' => 'Total penjualan hari ini', 'icon' => 'point_of_sales'])
        </div>
        <div class="col-md-4">
            @include('components.card-dashboard', ['title' => 'Rp. '. number_format($totalMonthly), 'subtitle' => 'Total penjualan bulan ini', 'icon' => 'receipt_long'])
        </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Produk terlaris</h1>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah Pesanan</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bestSellers as $index => $best)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$best->menu->name}}</td>
                        <td>{{$best->totalorder}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
