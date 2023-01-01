@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Detail Bahan Baku</h4>
    </div>
    <a href="{{route('ingredients')}}" class="btn btn-secondary btn-sm">Kembali</a>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{$ingredient['name']}}</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>{{$ingredient['stock']}}</td>
                </tr>
                <tr>
                    <th>Stok Minimal</th>
                    <td>{{$ingredient['min_stock']}}</td>
                </tr>
                <tr>
                    <th>Tipe Stok</th>
                    <td>{{$ingredient['stock_type']}}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{$ingredient['description']}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
