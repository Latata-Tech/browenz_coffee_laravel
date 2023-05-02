@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('employees')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Ubah Akun</h4>
    </div>
    @include('components.error')
    <form action="{{route('storeUpdateAccount', ['employee' => $employee->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-3">
                @include('components.select', ['datas' => $roles, 'name' => 'role_id', 'label' => 'Pilih akses', 'selected' => $employee->role_id])
                Akun Aktif <input type="checkbox" name="status" {{$employee->status ? "checked" : ""}} value="on">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
