@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Update Ingredient</h4>
    </div>
    <a href="{{route('ingredients')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'errorUnique'])
    <form action="{{route('updateIngredient', ['ingredient' => $ingredient->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row row-col-2">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $ingredient->name])
                @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok', 'value' => $ingredient->stock])
                @include('components.input', ['type' => 'number', 'name' => 'min_stock', 'label' => 'Stok Minimal', 'value' => $ingredient->min_stock])
                @include('components.select', ['datas' => $stock_types, 'name' => 'stock_type_id', 'label' => 'Tipe Stok', 'selected' => $ingredient->stock_type_id])
                @include('components.input', ['type' => 'text', 'name' => 'description', 'label' => 'Deksripsi', 'value' => $ingredient->description])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
