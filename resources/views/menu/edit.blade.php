@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('menus')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Edit Menu</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div onclick="document.getElementById('photo').click()" class="bg-white text-center d-flex justify-content-center align-items-center rounded" style="width:157px;height:180px;">
        <img id="previewImage" src="{{asset('storage/'.$menu->photo)}}" width="147" height="138" />
    </div>
    <form action="{{route('updateMenu', ['menu' => $menu->id])}}" method="POST" enctype="multipart/form-data">
        <input type="file" id="photo" name="photo" class="d-none">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama menu', 'value' => $menu->name])
                @include('components.select', ['datas' => $categories, 'name' => 'category_id', 'label' => 'Kategori', 'selected' => $menu->category_id])
                <label class="fw-bold">Harga</label>
                <div class="input-group mb-3 fw-bold">
                    <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$menu->hot_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'hot_price')" name="" id="hot">&nbsp;Hot</span>
                    <input type="text" class="form-control" {{$menu->hot_price !== 0 ? '' : 'disabled'}} name="hot_price" id="hot_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($menu->hot_price, 0, ',', '.')}}">
                </div>
                <div class="input-group mb-3 fw-bold">
                    <span class="input-group-text" id="basic-addon1"><input type="checkbox" {{$menu->ice_price !== 0 ? 'checked' : ''}} onchange="undisabled(this, 'ice_price')">&nbsp;Ice</span>
                    <input type="text" class="form-control" {{$menu->ice_price !== 0 ? '' : 'disabled'}} name="ice_price" id="ice_price" onkeyup="price(this)" style="text-align: right" value="{{number_format($menu->ice_price, 0, ',', '.')}}">
                </div>
                <div id="ingredientsContainer">
                    <label class="fw-bold">Bahan Baku</label>
                    @foreach($menu->ingredients as $key => $ingredient)
                        @if($key !== 0)
                        <div class="mb-2 d-flex align-items-center">
                            @include('components.select-no-label', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'selected' => $ingredient->ingredient_id])
                            <span class="material-icons text-danger" onclick="removeIngredient(this)" style="cursor: pointer">close</span>
                        </div>
                        @else
                            @include('components.select-no-label', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'selected' => $ingredient->ingredient_id])
                        @endif
                    @endforeach
                </div>
                <button class="btn btn-sm btn-success" type="button" id="addIngredient">Tambah</button>
                <div class="form-group">
                    <label>status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{$menu->status == 1 ? 'selected' : ''}}>Aktif</option>
                        <option value="0" {{$menu->status == 0 ? 'selected' : ''}}>Tidak aktif</option>
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
