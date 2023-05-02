@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('menus')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Tambah Menu</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div onclick="document.getElementById('photo').click()" class="bg-white text-center d-flex justify-content-center align-items-center rounded" style="width:157px;height:180px;">
        <img id="previewImage" src="{{asset('images/placeholder.png')}}" width="80" height="80" />
    </div>
    <form action="{{route('storeMenu')}}" method="POST" enctype="multipart/form-data">
        <input type="file" id="photo" name="photo" class="d-none">
        @csrf
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama menu'])
                @include('components.select', ['datas' => $categories, 'name' => 'category_id', 'label' => 'Kategori', 'selected' => null, 'placeholder' => 'Pilih Kategori'])
                <label class="fw-bold">Harga</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><input type="checkbox" onchange="undisabled(this, 'hot_price')" name="" id="hot">&nbsp;Hot</span>
                    <input type="text" class="form-control" disabled name="hot_price" id="hot_price" onkeyup="price(this)" style="text-align: right" value="0">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><input type="checkbox" onchange="undisabled(this, 'ice_price')">&nbsp;Ice</span>
                    <input type="text" class="form-control" disabled name="ice_price" id="ice_price" onkeyup="price(this)" style="text-align: right" value="0">
                </div>
                <div id="ingredientsContainer" class="fw-bold">
                    @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => null, 'placeholder' => 'Pilih Bahan Baku'])
                </div>
                <button class="btn btn-sm btn-success" type="button" id="addIngredient">Tambah</button>
                <div class="form-group">
                    <label class="fw-bold">Status</label>
                    <select class="form-control" name="status">
                        <option>Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak aktif</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
