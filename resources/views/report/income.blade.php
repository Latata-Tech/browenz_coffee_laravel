@extends('layout.layout')

@section('header')
    @include('templates.header')
    @include('templates.nav')
    @include('templates.body')
@endsection

@section('content')
    <div class="container-fluid my-3 border border-black d-flex align-items-center" style="border-bottom: 1px solid #333 !important;">
        <h4>Laporan</h4>
    </div>
    <table class="table">
        @foreach($data as $value)
            <tr>
                <th>{{$value['name']}}</th>
                <td>{{$value['total']}}</td>
            </tr>
        @endforeach
    </table>
@endsection

@section('footer')
    @include('templates.footer')
@endsection
