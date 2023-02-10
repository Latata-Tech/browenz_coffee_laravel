@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid border-bottom my-3">
        <h4>Detail Kategori</h4>
    </div>
    <a href="{{route('categories')}}" class="btn btn-secondary btn-sm">Kembali</a>
    @include('components.error')
    <div class="row">
        <div class="col-md-3">
            @include('components.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'value' => $category->name])
            @include('components.textarea', ['name' => 'description', 'label' => 'Deskripsi', 'value' => $category->description])
        </div>
    </div>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
