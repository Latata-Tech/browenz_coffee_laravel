@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('menus')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Detail Menu</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div onclick="document.getElementById('photo').click()" class="bg-white text-center d-flex justify-content-center align-items-center rounded" style="width:157px;height:180px;">
        <img id="previewImage" src="{{asset('storage/'.$menu->photo)}}" width="147" height="138" />
    </div>
    <input type="file" id="photo" name="photo" class="d-none">
    @csrf
    <div class="row">
        <div class="col-md-3">
            @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama menu', 'value' => $menu->name])
            @include('components.select', ['datas' => $categories, 'name' => 'category_id', 'label' => 'Kategori', 'selected' => $menu->category_id])
            <label class="fw-bold">Harga</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$menu->hot_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'hot_price')" name="" id="hot">&nbsp;Hot</span>
                <input type="text" class="form-control" disabled name="hot_price" id="hot_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($menu->hot_price, 0, ',', '.')}}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$menu->ice_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'ice_price')">&nbsp;Ice</span>
                <input type="text" class="form-control" disabled name="ice_price" id="ice_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($menu->ice_price, 0, ',', '.')}}">
            </div>
            <div id="ingredientsContainer">
                <label class="fw-bold">Bahan Baku</label>
                @foreach($menu->ingredients as $ingredient)
                    @include('components.select-no-label', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'selected' => $ingredient->ingredient_id])
                @endforeach
            </div>
            <div class="form-group">
                <label class="fw-bold">status</label>
                <select class="form-control" name="status">
                    <option value="1" {{$menu->status == 1 ? 'selected' : ''}}>Aktif</option>
                    <option value="0" {{$menu->status == 0 ? 'selected' : ''}}>Tidak aktif</option>
                </select>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
