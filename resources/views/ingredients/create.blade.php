@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('ingredients')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Tambah Bahan Baku</h4>
    </div>
    @include('components.error')
    <form action="{{route('storeIngredient')}}" method="POST">
        @csrf
        <div class="row row-col-2">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama'])
                @include('components.select', ['datas' => $stock_types, 'name' => 'stock_type_id', 'label' => 'Satuan', 'selected' => null, 'placeholder' => 'Pilih Satuan'])
                @include('components.input', ['type' => 'number', 'name' => 'stock', 'label' => 'Stok', 'placeholder' => 'Masukan stok'])
                @include('components.textarea', ['name' => 'description', 'label' => 'Deksripsi', 'placeholder' => 'Masukan Deskripsi'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
