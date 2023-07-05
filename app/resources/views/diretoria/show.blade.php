@extends('adminlte::page')

@section('title', $diretoria->nome)

@section('content_header')
    <h1>Detalhes de Diretoria</h1>
@endsection

@section('content')
    <x-box titulo="Diretoria {{$diretoria->nome}}" id="content">
        <x-slot:body>
            @include('diretoria.components.form_detalhes')
        </x-slot:body>
    </x-box>
@stop