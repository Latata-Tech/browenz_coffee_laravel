@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <h4>Menu</h4>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row mb-2">
        <div class="col-6 justify-content-center">
            <h4>Daftar Menu</h4>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('createMenu')}}" class="btn btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('menus')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menus as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$menu->name}}</td>
                        <td>{{is_null($menu->category) ? null : $menu->category->name}}</td>
                        <td>
                            <a href="{{route('detailMenu', ['menu' => $menu->id])}}"
                               class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="{{route('editMenu', ['menu' => $menu->id])}}"
                               class="btn btn-sm btn-link"><i
                                    class="material-icons text-warning">edit_square</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                               type="button" data="{{route('deleteMenu', ['menu' => $menu->id])}}"
                               onclick="deleteModal(this, 'modal-menu')" class="btn btn-sm btn-link"
                               data-bs-toggle="modal" data-bs-target="#menuModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{$menus->links('vendor.pagination.bootstrap-5')}}
        </div>
    </div>
    @include('components.modal-delete', ['action' => 'menu'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
