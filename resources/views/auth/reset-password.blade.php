@extends('layout.layout')

@section('header')
    @include('templates.header')
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center w-100 vh-100">
        <form method="POST" action="{{route('storeResetPassword')}}" style="width: 580px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="token" value="{{$token}}">
            <input type="hidden" name="email" value="{{$email}}">
            <div class="text-center">
                <img src="{{asset('images/logo2.png')}}" width="150" height="150">
            </div>
            @include('components.failed')
            @include('components.success')
            @include('components.error')
            <div class="mb-3">
                <label for="" class="form-label">Password Baru</label>
                <input type="password" name="new_password" class="form-control border-0" style="background-color: #eee" placeholder="Masukan password baru">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Konfirmasi Password</label>
                <input type="password" name="new_password_confirmation" class="form-control border-0" style="background-color: #eee" placeholder="Masukan konfirmasi password">
            </div>
            <div>
                <button class="btn btn-primary w-100" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
