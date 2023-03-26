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
    @include('components.error-custom', ['errorName' => 'failed'])
    <a href="{{route('createEmployee')}}" class="btn btn-primary my-3">Tambah Karyawan</a>
    <div class="row">
        <div class="col-6">
            <h4>Daftar Karyawan</h4>
        </div>
        <div class="col-3"></div>
        <div class="col-3">
            @include('components.search', ['action' => route('employees')])
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
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
                        @if(is_null($employee->role_id) && $employee->email === 'admin@browenz.com')
                            <td>
                                <a href="{{route('detailEmployee', ['employee' => $employee->id])}}"
                                   class="btn btn-sm btn-link"><i class="material-icons text-primary">preview</i></a>
                            </td>
                        @elseif(is_null($employee->email))
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
                                @if(auth()->user()->role_id === 1 && $employee->role_id === null || auth()->user()->email === 'admin@browenz.com')
                                    <a href="{{route('createAccount', ['employee' => $employee->id])}}"
                                       class="btn btn-sm btn-primary">Buat Akun</a>
                                @endif
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
                                @if(auth()->user()->email === 'admin@browenz.com' || auth()->user()->role_id === 1)
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
        @if($employees->count() > 10)
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
