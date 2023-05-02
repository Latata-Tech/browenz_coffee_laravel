@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('employees')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Ubah Karyawan</h4>
    </div>
    @include('components.error')
    <form action="{{route('updateEmployee', ['employee' => $employee->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row row-col-2">
            <div class="col-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama', 'value' => $employee->name])
                @include('components.input', ['type' => 'text', 'name' => 'address', 'label' => 'Alamat', 'placeholder' => 'Masukan alamat', 'value' => $employee->address])
                @include('components.input', ['type' => 'text', 'name' => 'phone_number', 'label' => 'Nomor Handphone', 'placeholder' => 'Masukan nomor handphone', 'value' => $employee->phone_number])
                @include('components.input', ['type' => 'date', 'name' => 'birth_date', 'label' => 'Tanggal Lahir', 'value' => $employee->birth_date])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
