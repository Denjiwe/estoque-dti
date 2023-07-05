@extends('adminlte::page')

@section('title', $orgao->nome)

@section('content_header')
    <h1>Detalhes de Órgão</h1>
@endsection

@section('content')
    <x-box titulo="Órgão {{$orgao->nome}}" id="content">
        <x-slot:body>
            @include('orgao.components.form_detalhes')
        </x-slot:body>
    </x-box>
@stop