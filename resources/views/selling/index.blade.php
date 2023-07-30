@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center"
         style="border-bottom: 1px solid #333 !important;">
        <h4>Penjualan</h4>
    </div>
    <div class="row">
        <div class="col-6 justify-content-center">
            <h4>Daftar Penjualan</h4>
        </div>
        <div class="col-4"></div>
        <div class="col-2">
            <form action="{{route('sellings')}}" id="form_date_filter" method="GET">
                @csrf
                <input type="date" class="form-control" name="date_filter" id="date_filter" value="{{$date_filter}}">
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="row justify-content-end">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div id="button-search">
                                    <i class="material-icons">search</i>
                                </div>
                                <input type="search" id="searchData" name="search"
                                       class="form-control border-start-0 border-secondary" onkeyup="search()"
                                       placeholder="Search..." aria-describedby="button-search"
                                       value="{{request('search') ?? ""}}">
                                </form>
                            </div>
                        </div>
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
                                <a href="{{route('detailSelling', ['id' => $order->id])}}"
                                   class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$orders->links('vendor.pagination.bootstrap-5')}}
            </div>
        </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
