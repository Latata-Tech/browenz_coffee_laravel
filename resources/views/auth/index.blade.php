@extends('layout.layout')

@section('header')
    @include('templates.header')
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center w-100 vh-100">
        <form method="POST" action="{{route('login')}}" style="width: 580px;">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="browenz@gmail.com">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="">
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
