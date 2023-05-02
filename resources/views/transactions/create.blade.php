@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('transactions')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Tambah Transaksi Stok</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-md-4">
            <form action="{{route('storeTransaction')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('components.input', ['type' => 'date', 'name' => 'date', 'label' => 'Tanggal'])
                <div class="form-group">
                    <label class="fw-bold">Tipe</label>
                    <select class="form-control" name="type">
                        <option value="in">Masuk</option>
                        <option value="out">Keluar</option>
                    </select>
                </div>
               <div class="form-group" id="first">
                   <div class="row">
                       <div class="col-6">
                           @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => null, 'onchange' => 'onchange=getStockType(this)', 'placeholder' => 'Pilih Bahan Baku'])
                       </div>
                       <div class="col-6">
                           <label class="mt-3 fw-bold">Jumlah</label>
                           <div class="input-group flex-nowrap align-items-center">
                               <input type="number" class="form-control" name="qties[]">
                               <span class="input-group-text" id="addon-wrapping">@</span>
                           </div>
                       </div>
                   </div>
               </div>
                <div id="ingredients_container"></div>
                <div class="form-group">
                    <button class="form-control btn btn-sm btn-success" type="button" style="width: 100px" onclick="addIngredient()">Tambah</button>
                </div>
                @include('components.textarea', ['name' => 'description', 'label' => 'Deskripsi'])

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>

@endsection

@section('footer')
    @include('templates.footer')
@endsection
