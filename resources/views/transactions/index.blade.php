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
            <h4>Daftar Transaksi</h4>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('createTransaction')}}" class="btn btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('transactions')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ingredient_transactions as $index => $transaction)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$transaction->code}}</td>
                        <td>{{\Illuminate\Support\Carbon::createFromDate($transaction->date)->format('d/m/Y')}}</td>
                        <td>{{$transaction->type === 'in' ? 'Masuk' : 'Keluar'}}</td>
                        <td>
                            <a href="{{route('editTransaction', ['id' => $transaction->id])}}"
                               class="btn btn-sm btn-link"><i
                                    class="material-icons text-warning">edit_square</i></a>
                            <a href="{{route('detailTransaction', ['transaction' => $transaction->id])}}"
                            class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                               type="button" data="{{route('deleteTransaction', ['transaction' => $transaction->id])}}"
                               onclick="deleteModal(this, 'modal-transaction')" class="btn btn-sm btn-link"
                               data-bs-toggle="modal" data-bs-target="#transactionModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($ingredient_transactions->count() > 10)
            <div class="card-footer">
                {{$ingredient_transctions->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
    @include('components.modal-delete', ['action' => 'transaction'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
