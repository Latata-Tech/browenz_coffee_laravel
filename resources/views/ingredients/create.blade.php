@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Karyawan</h4>
    </div>
    <a href="{{route('ingredients')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    <form action="{{route('storeIngredient')}}" method="POST">
        @csrf
        <div class="row row-col-2">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama'])
                @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok'])
                @include('components.input', ['type' => 'number', 'name' => 'min_stock', 'label' => 'Stok Minimal'])
                @include('components.select', ['datas' => $stock_types, 'name' => 'stock_type_id', 'label' => 'Tipe Stok', 'selected' => null])
                @include('components.input', ['type' => 'text', 'name' => 'description', 'label' => 'Deksripsi'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
