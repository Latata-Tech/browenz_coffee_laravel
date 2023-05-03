@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    @include('components.success')
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <form action="{{route('storeChangePassword')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'password', 'name' => 'old_password', 'label' => 'Password Lama', 'placeholder' => 'Masukan Password'])
                @include('components.input', ['type' => 'password', 'name' => 'new_password', 'label' => 'Password Baru', 'placeholder' => 'Masukan Password'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
