@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Kategori</h4>
    </div>
    <a href="{{route('menus')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    @include('components.error-custom', ['errorName' => 'failed'])
    <div onclick="document.getElementById('photo').click()" class="bg-white text-center d-flex justify-content-center align-items-center rounded" style="width:157px;height:180px;">
        <img id="previewImage" src="{{asset('images/placeholder.png')}}" width="80" height="80" />
    </div>
    <form action="{{route('storeMenu')}}" method="POST">
        <input type="file" id="photo" class="d-none">
        @csrf
        <div class="row">
            <div class="col-md-3">
                @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Masukan nama'])
                @include('components.textarea', ['name' => 'description', 'label' => 'Deskripsi'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
