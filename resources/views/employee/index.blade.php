@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Karyawan</h4>
    </div>
    @include('components.success')
    <a href="{{route('createEmployee')}}" class="btn btn-primary my-3">Tambah Karyawan</a>
    <h6>Daftar Karyawan</h6>
    <div class="card w-100">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $index => $employee)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$employee->user->email}}</td>
                        <td>{{$employee->user->name}}</td>
                        <td>
                            <a href="" class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            <a href="" class="btn btn-sm btn-link"><i class="material-icons text-warning">edit_square</i></a>
                            <a href="#" data-bs-title="Default tooltip"
                                type="button" data="{{route('deleteEmployee', ['employee' => $employee->id])}}" onclick="deleteModal(this, 'modal-karyawan')"  class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#karyawanModal">
                                <i class="material-icons text-danger">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{$employees->links('vendor.pagination.bootstrap-5')}}
        </div>
    </div>
    @include('components.modal-delete', ['action' => 'karyawan'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
