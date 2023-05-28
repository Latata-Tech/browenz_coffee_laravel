@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <h4>Bahan Baku</h4>
    </div>
    <div class="row mb-2">
        <div class="col-6 justify-content-center">
            <h4>Daftar Bahan Baku</h4>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('createIngredient')}}" class="btn btn-primary">Tambah</a>
        </div>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('ingredients')])
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ingredients as $index => $ingredient)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$ingredient->name}}</td>
                        <td>{{$ingredient->type->name}}</td>
                        <td>{{$ingredient->stock}}</td>
                        <td>
                            <a href="{{route('detailIngredient', ['ingredient' => $ingredient->id])}}" class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="{{route('editIngredient', ['ingredient' => $ingredient->id])}}" class="btn btn-sm btn-link"><i class="material-icons text-warning">edit_square</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                               type="button" data="{{route('deleteIngredient', ['ingredient' => $ingredient->id])}}" onclick="deleteModal(this, 'modal-ingredient')"  class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#ingredientModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($ingredients->count() >= 10)
            <div class="card-footer">
                {{$ingredients->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
    @include('components.modal-delete', ['action' => 'ingredient'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
