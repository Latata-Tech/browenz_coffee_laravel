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
    <a href="{{route('employees')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    <form action="{{route('storeAccount', ['employee' => $employee->id])}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'email', 'label' => 'Email', 'placeholder' => 'Masukan email'])
                @include('components.input', ['type' => 'password', 'name' => 'password', 'label' => 'Password', 'placeholder' => 'Masukan password'])
                @include('components.select', ['datas' => $roles, 'name' => 'role_id', 'label' => 'Pilih akses', 'selected' => null])
                Akun Aktif <input type="checkbox" name="status" value="on">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
