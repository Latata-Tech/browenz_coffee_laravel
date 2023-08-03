@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('transactions')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Ubah Transaksi Stok</h4>
    </div>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-md-8">
            <div class="form-group d-none" id="first">
                <div class="row">
                    <div class="col-6">
                        @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => null, 'onchange' => 'onchange=getStockType(this)'])
                    </div>
                    <div class="col-6">
                        <label class="mt-3 fw-bold">Jumlah</label>
                        <div class="row">
                            <div class="col-6 converter-container d-none">
                                <div class="input-group flex-nowrap align-items-center">
                                    <input type="number" class="form-control converts" onkeyup="convertUnit(this)">
                                    <select class="form-control input-group-lg" onchange="onChangeUnit(this)" name="convert">
                                        @foreach($units as $data)
                                            @if(in_array($data->name,['gram', 'kg']))
                                                <option value="{{$data->name}}">{{$data->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group flex-nowrap align-items-center">
                                    <input type="number" class="form-control" name="qties[]">
                                    <span class="input-group-text" id="addon-wrapping">@</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{route('updateTransaction', ['transaction' => $ingredient_transactions->id])}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('components.input', ['type' => 'date', 'name' => 'date', 'label' => 'Tanggal', "value" => $ingredient_transactions->transaction_date])
                @include('components.input', ['type' => 'text', 'name' => 'type', 'label' => 'Tipe', "value" => $ingredient_transactions->type === "in" ? "Masuk" : "Keluar"])

                @foreach($ingredient_transactions->detail as $key => $value)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => $value->ingredient_id])
                            </div>
                            <div class="col-6">
                                <label class="mt-3 fw-bold">Jumlah</label>
                                <div class="input-group flex-nowrap align-items-center">
                                    <input type="number" class="form-control" name="qties[]" value="{{$value->qty}}">
                                    <span class="input-group-text" id="addon-wrapping">{{$value->ingredient->type->name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div id="ingredients_container"></div>
                <div class="form-group">
                    <button class="form-control btn btn-sm btn-success" type="button" style="width: 100px"
                            onclick="addIngredient()">Tambah
                    </button>
                </div>
                @include('components.textarea', ['name' => 'description', 'label' => 'Deskripsi', "value" => $ingredient_transactions->description])

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>

@endsection

@section('footer')
    @include('templates.footer')
@endsection
