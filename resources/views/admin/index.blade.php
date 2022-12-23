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
            @include('components.card-dashboard', ['title' => 5, 'subtitle' => 'Jumlah pesanan hari ini', 'icon' => 'receipt'])
        </div>
        <div class="col-md-4">
            @include('components.card-dashboard', ['title' => 'Rp. 150.000', 'subtitle' => 'Total penjualan hari ini', 'icon' => 'receipt_long'])
        </div>
        <div class="col-md-4">
            @include('components.card-dashboard', ['title' => 'Rp. 3.500.000', 'subtitle' => 'Total penjualan bulan ini', 'icon' => 'insights'])
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
