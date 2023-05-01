@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Promo</h4>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row mb-2">
        <div class="col-6 justify-content-center">
            <h4>Daftar Promo</h4>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('createPromo')}}" class="btn btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('promos')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($promos as $index => $promo)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$promo->name}}</td>
                        <td>{{strtotime(\Illuminate\Support\Carbon::now()->format('Y-m-d')) > strtotime($promo->end_date) ? 'Tidak aktif' : 'Aktif' }}</td>
                        <td>
                            <a href="{{route('detailPromo', ['promo' => $promo->id])}}"
                               class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="{{route('editPromo', ['promo' => $promo->id])}}"
                               class="btn btn-sm btn-link"><i
                                    class="material-icons text-warning">edit_square</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                               type="button" data="{{route('deletePromo', ['promo' => $promo->id])}}"
                               onclick="deleteModal(this, 'modal-promo')" class="btn btn-sm btn-link"
                               data-bs-toggle="modal" data-bs-target="#promoModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($promos->count() >= 10)
            <div class="card-footer">
                {{$promos->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
    @include('components.modal-delete', ['action' => 'promo'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
