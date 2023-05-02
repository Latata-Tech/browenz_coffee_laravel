@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('ingredients')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Ubah Bahan Baku</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'errorUnique'])
    <form action="{{route('updateIngredient', ['ingredient' => $ingredient->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row row-col-2">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $ingredient->name])
                @include('components.select', ['datas' => $stock_types, 'name' => 'stock_type_id', 'label' => 'Satuan', 'selected' => $ingredient->stock_type_id])
                @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok', 'value' => $ingredient->stock])
                @include('components.textarea', ['type' => 'text', 'name' => 'description', 'label' => 'Deksripsi', 'value' => $ingredient->description])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
