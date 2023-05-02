@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('promos')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Tambah promo</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-md-4">
            <form action="{{route('storePromo')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama promo'])
                @include('components.select', ['datas' => $menus, 'name' => 'menu_id', 'label' => 'Menu', 'selected' => null])
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-bold">Harga Awal</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Hot</span>
                            <input type="text" class="form-control" id="hot_price_before" disabled style="text-align: right" value="0">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Ice</span>
                            <input type="text" class="form-control" id="ice_price_before" disabled style="text-align: right" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Harga Promo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><input type="checkbox" onchange="undisabled(this, 'hot_price')" name="" id="hot">&nbsp;Hot</span>
                            <input type="text" class="form-control" disabled name="hot_price" id="hot_price" onkeyup="price(this)" style="text-align: right" value="0">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><input type="checkbox" onchange="undisabled(this, 'ice_price')">&nbsp;Ice</span>
                            <input type="text" class="form-control" disabled name="ice_price" id="ice_price" onkeyup="price(this)" style="text-align: right" value="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        @include('components.input', ['type' => 'date', 'name' => 'start_date', 'label' => 'Mulai Dari'])
                    </div>
                    <div class="col-6">
                        @include('components.input', ['type' => 'date', 'name' => 'end_date', 'label' => 'Sampai'])
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
