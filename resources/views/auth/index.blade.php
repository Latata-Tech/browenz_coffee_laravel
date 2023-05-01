@extends('layout.layout')

@section('header')
    @include('templates.header')
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center w-100 vh-100">
        <form method="POST" action="{{route('login')}}" style="width: 580px;">
            <div class="text-center">
                <img src="{{asset('images/logo2.png')}}" width="150" height="150">
            </div>
            @csrf
            @include('components.error')
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" class="form-control border-0" style="background-color: #eee" placeholder="Masukan email">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" class="form-control border-0" style="background-color: #eee" placeholder="Masukan password">
            </div>
            <div class="mb-3">
                <a class="text-link" href="#">Lupa password?</a>
            </div>
            <div>
                <button class="btn btn-primary w-100" type="submit">Masuk</button>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
