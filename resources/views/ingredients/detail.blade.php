@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('ingredients')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Detail Bahan Baku</h4>
    </div>
    <div class="row">
        <div class="col-md-4">
            @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $ingredient['name']])
            @include('components.input', ['type' => 'text', 'name' => 'stock_type_id', 'label' => 'Satuan', 'value' => $ingredient['stock_type']])
            @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok', 'value' => $ingredient['stock']])
            @include('components.textarea', ['name' => 'description', 'label' => 'Deksripsi', 'value' => $ingredient['description']])
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
