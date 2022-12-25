@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Update Karyawan</h4>
    </div>
    <a href="{{route('employees')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    <form action="{{route('updateEmployee', ['employee' => $employee->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row row-col-2">
            <div class="col">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $employee->user->name])
                @include('components.input', ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'value' => $employee->user->email])
                @include('components.input', ['type' => 'text', 'name' => 'phone_number', 'label' => 'No Telepon', 'value' => $employee->phone_number])
            </div>
            <div class="col">
                @include('components.input', ['type' => 'date', 'name' => 'birth', 'label' => 'Tanggal Lahir', 'value' => $employee->birth_date])
                @include('components.input', ['type' => 'text', 'name' => 'address', 'label' => 'Alamat', 'value' => $employee->address])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
