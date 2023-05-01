@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Penjualan</h4>
    </div>
    <div class="row">
        <div class="col-6 justify-content-center">
            <h4>Daftar Penjualan</h4>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('sellings')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No Penjualan</th>
                    <th>Total Penjualan</th>
                    <th>Karyawan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $index => $order)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$order->code}}</td>
                        <td>{{'Rp. ' . number_format($order->total)}}</td>
                        <td>{{$order->user->name}}</td>
                        <td>
                            <a href="{{route('detailSelling', ['order' => $order->id])}}"
                               class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($orders->count() >= 10)
            <div class="card-footer">
                {{$orders->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
