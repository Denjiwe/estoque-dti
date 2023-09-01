@extends('adminlte::page')

@section('title', $produto->modelo_produto)

@section('content_header')
    <h1>Detalhes de Produto</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $produto->modelo_produto }}</h3>

        @include('produto.components.form_detalhes')
    </x-adminlte-card>
@stop