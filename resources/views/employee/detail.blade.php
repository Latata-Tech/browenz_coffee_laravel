@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Detail Karyawan</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{$employee['name']}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$employee['email']}}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{$employee['birth_date']}}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{$employee['phone_number']}}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{$employee['address']}}</td>
                </tr>
            </table>
            <a href="{{route('employees')}}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
