@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Kategori</h4>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-6">
            <h4>Daftar Kategori</h4>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('createCategory')}}" class="btn btn-primary my-3">Tambah</a>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('categories')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $index => $category)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('editCategory', ['category' => $category->id])}}"
                               class="btn btn-sm btn-link"><i
                                    class="material-icons text-warning">edit_square</i></a>
                            <a href="{{route('detailCategory', ['id' => $category->id])}}"
                               class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                               type="button" data="{{route('deleteCategory', ['category' => $category->id])}}"
                               onclick="deleteModal(this, 'modal-kategori')" class="btn btn-sm btn-link"
                               data-bs-toggle="modal" data-bs-target="#kategoriModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($categories->count() >= 10)
            <div class="card-footer">
                {{$employees->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
    @include('components.modal-delete', ['action' => 'kategori'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
