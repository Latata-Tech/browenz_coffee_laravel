@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Laporan</h4>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <form action="" method="GET" id="getReport">
        @csrf
        @method('GET')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label fw-bold">Filter</label>
                    <select class="form-control" name="transaction_type" id="type-filter" onchange="typeFilter(this)">
                        <option value="-">Pilih Filter</option>
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>
                <div id="daily" class="d-none">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Dari</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Dari</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-flex" id="monthly-yearly">
                    <div class="form-group" id="monthly">
                        <label class="form-label fw-bold">Bulan</label>
                        <select class="form-control" name="month" id="month">
                            @for($i = 0; $i < count($month); $i++)
                                <option value="{{$i+1}}">{{$month[$i]}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group" id="yearly">
                        <label class="form-label fw-bold">Tahun</label>
                        <select class="form-control" name="year" id="year">
                            @for($i = now()->format('Y'); $i > now()->format('Y') - 3; $i--)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label fw-bold">Tipe Laporan</label>
                    <select class="form-control" id="type-report" onchange="typeReport(this)">
                        <option value="-">Pilih Laporan</option>
                        <option value="selling">Laporan Penjualan</option>
                        <option value="stock_transaction">Laporan Transaksi Stock</option>
                    </select>
                </div>
                <div class="form-group d-none" id="typeTransaction">
                    <label class="form-label fw-bold">Tipe Transaksi</label>
                    <select class="form-control" name="type" id="type">
                        <option value="in">Masuk</option>
                        <option value="out">Keluar</option>
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-primary mt-1">Download</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
