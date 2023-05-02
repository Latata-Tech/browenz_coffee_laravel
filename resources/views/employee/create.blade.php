@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('employees')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Tambah Karyawan</h4>
    </div>
    @include('components.error')
    <form action="{{route('storeEmployee')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama'])
                @include('components.input', ['type' => 'text', 'name' => 'address', 'label' => 'Alamat', 'placeholder' => 'Masukan alamat'])
                @include('components.input', ['type' => 'text', 'name' => 'phone_number', 'label' => 'Nomor Handphone', 'placeholder' => 'Masukan nomor handphone'])
                @include('components.input', ['type' => 'date', 'name' => 'birth_date', 'label' => 'Tanggal Lahir'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
