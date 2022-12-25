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
        <div class="row row-col-2">
            <div class="col">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama'])
                @include('components.input', ['type' => 'email', 'name' => 'email', 'label' => 'Email'])
                @include('components.input', ['type' => 'password', 'name' => 'password', 'label' => 'Password'])
            </div>
            <div class="col">
                @include('components.input', ['type' => 'text', 'name' => 'phone_number', 'label' => 'No Telepon'])
                @include('components.input', ['type' => 'date', 'name' => 'birth', 'label' => 'Tanggal Lahir'])
                @include('components.input', ['type' => 'text', 'name' => 'address', 'label' => 'Alamat'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
