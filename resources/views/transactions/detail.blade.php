@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Transaksi Stok</h4>
    </div>
    <a href="{{route('transactions')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-md-4">
            @include('components.input', ['type' => 'date', 'name' => 'date', 'label' => 'Tanggal', "value" => $ingredient_transactions->transaction_date])
            @include('components.input', ['type' => 'text', 'name' => 'type', 'label' => 'Tipe', "value" => $ingredient_transactions->type === "in" ? "Masuk" : "Keluar"])
            <div class="form-group d-none" id="first">
                <div class="row">
                    <div class="col-6">
                        @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => null, 'onchange' => 'onchange=getStockType(this)'])
                    </div>
                    <div class="col-6">
                        <label class="mt-3">Jumlah</label>
                        <div class="input-group flex-nowrap align-items-center">
                            <input type="number" class="form-control" name="qties[]">
                            <span class="input-group-text" id="addon-wrapping">@</span>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($ingredient_transactions->detail as $key => $value)
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            @include('components.select', ['datas' => $ingredients, 'name' => 'ingredient_id[]', 'label' => 'Bahan baku', 'selected' => $value->ingredient_id, "disabled" => "disabled"])
                        </div>
                        <div class="col-6">
                            <label class="mt-3">Jumlah</label>
                            <div class="input-group flex-nowrap align-items-center">
                                <input type="number" class="form-control" name="qties[]" value="{{$value->qty}}">
                                <span class="input-group-text" id="addon-wrapping">@</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div id="ingredients_container"></div>
            @include('components.textarea', ['name' => 'description', 'label' => 'Deskripsi', "value" => $ingredient_transactions->description])
        </div>
    </div>

@endsection

@section('footer')
    @include('templates.footer')
@endsection
