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
        <div class="col-md-4">
            @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $ingredient['name']])
            @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok', 'value' => $ingredient['stock']])
            @include('components.input', ['type' => 'text', 'name' => 'stock_type_id', 'label' => 'Tipe Stok', 'value' => $ingredient['stock_type']])
            @include('components.textarea', ['name' => 'description', 'label' => 'Deksripsi', 'value' => $ingredient['description']])
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
