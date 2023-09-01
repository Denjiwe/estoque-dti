@extends('adminlte::page')

@section('title', $diretoria->nome)

@section('content_header')
    <h1>Detalhes de Diretoria</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Diretoria {{$diretoria->nome}}</h3>

        @include('diretoria.components.form_detalhes')
    </x-adminlte-card>
@stop