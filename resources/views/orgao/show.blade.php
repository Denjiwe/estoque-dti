@extends('adminlte::page')

@section('title', $orgao->nome)

@section('content_header')
    <h1>Detalhes de Órgão</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Órgao {{$orgao->nome}}</h3>

        @include('orgao.components.form_detalhes')
    </x-adminlte-card>
@stop