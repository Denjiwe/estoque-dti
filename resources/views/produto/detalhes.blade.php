@extends('adminlte::page')

@section('title', $produto->modelo_produto)

@section('content_header')
    <h1>Detalhes de Produto</h1>
@endsection

@section('content')
    <x-box titulo="{{ucfirst(strtolower($produto->tipo_produto))}} {{$produto->modelo_produto}}" id="content">
        <x-slot:body>
            @include('produto.components.form_detalhes')
        </x-slot:body>
    </x-box>
@stop