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
