@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Karyawan</h4>
    </div>
    @include('components.success')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div class="row">
        <div class="col-6 justify-content-center">
            <h4>Daftar Karyawan</h4>
        </div>
        <div class="col-6 text-end"><a href="{{route('createEmployee')}}" class="btn btn-primary">Tambah</a></div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('components.search', ['action' => route('employees')])
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $index => $employee)
                    <tr>
                        <td>{{$index+1}}</td>
                        @if(is_null($employee->email))
                            <td><i class="text-danger">(null)</i></td>
                        @else
                            <td>{{$employee->email ?? "null"}}</td>
                        @endif
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->status ? "Aktif" : "Tidak aktif"}}</td>
                        @if(is_null($employee->email))
                            <td>
                                <a href="{{route('detailEmployee', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                                <a href="{{route('editEmployee', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-link"><i
                                        class="material-icons text-warning">edit_square</i></a>

                                <a href="#" data-bs-title="Default tooltip"
                                   type="button" data="{{route('deleteEmployee', ['employee' => $employee->id])}}"
                                   onclick="deleteModal(this, 'modal-karyawan')" class="btn btn-sm btn-link"
                                   data-bs-toggle="modal" data-bs-target="#karyawanModal">
                                    <i class="material-icons text-danger">delete</i>
                                </a>
                                <a href="{{route('createAccount', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-primary">Buat Akun</a>
                            </td>
                        @else
                            <td>
                                <a href="{{route('detailEmployee', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                                <a href="{{route('editEmployee', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-link"><i
                                        class="material-icons text-warning">edit_square</i></a>
                                <a href="#" data-bs-title="Default tooltip"
                                   type="button" data="{{route('deleteEmployee', ['employee' => $employee->id])}}"
                                   onclick="deleteModal(this, 'modal-karyawan')" class="btn btn-sm btn-link"
                                   data-bs-toggle="modal" data-bs-target="#karyawanModal">
                                    <i class="material-icons text-danger">delete</i>
                                </a>
                                @if($employees->role_id === 2)
                                    <a href="{{route('updateAccount', ['employee' => $employee->id])}}"
                                       class="btn btn-sm btn-warning">Update Akun</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($employees->count() >= 10)
            <div class="card-footer">
                {{$employees->links('vendor.pagination.bootstrap-5')}}
            </div>
        @endif
    </div>
    @include('components.modal-delete', ['action' => 'karyawan'])
@endsection

@section('footer')
    @include('templates.footer')
@endsection
