@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Promo</h4>
    </div>
    <a href="{{route('promos')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-md-4">
            <form action="{{route('updatePromo', ['promo' => $promo->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama promo', 'value' => $promo->name])
                @include('components.input', ['type' => 'text', 'name' => 'menu', 'label' => 'Menu', 'placeholder' => '', 'value' => $promo->menu->name, 'disabled' => 'disabled'])
                <div class="row">
                    <div class="col-md-6">
                        <label>Harga Awal</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Hot</span>
                            <input type="text" class="form-control" id="hot_price_before" disabled style="text-align: right" value="{{number_format($promo->menu->hot_price, 0, ',', '.')}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Ice</span>
                            <input type="text" class="form-control" id="ice_price_before" disabled style="text-align: right" value="{{number_format($promo->menu->ice_price, 0, ',', '.')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Harga Promo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$promo->hot_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'hot_price')" name="">&nbsp;Hot</span>
                            <input type="text" class="form-control" {{$promo->hot_price !== 0 ? '' : 'disabled'}} name="hot_price" id="hot_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($promo->hot_price, 0, ',', '.')}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$promo->ice_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'ice_price')">&nbsp;Ice</span>
                            <input type="text" class="form-control" {{$promo->ice_price !== 0 ? '' : 'disabled'}} name="ice_price" id="ice_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($promo->ice_price, 0, ',', '.')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        @include('components.input', ['type' => 'date', 'name' => 'start_date', 'label' => 'Mulai Dari', 'value' => $promo->start_date])
                    </div>
                    <div class="col-6">
                        @include('components.input', ['type' => 'date', 'name' => 'end_date', 'label' => 'Sampai', 'value' => $promo->end_date])
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>

@endsection

@section('footer')
    @include('templates.footer')
@endsection
