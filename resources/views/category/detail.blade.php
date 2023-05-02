@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <a href="{{route('categories')}}"><span class="material-icons" style="color: #1A72DD">chevron_left</span></a><h4>Detil Kategori</h4>
    </div>
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
