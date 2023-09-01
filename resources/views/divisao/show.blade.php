@extends('adminlte::page')

@section('title', $divisao->nome)

@section('content_header')
    <h1>Detalhes de Divisão</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Divisão {{$divisao->nome}}</h3>

        @include('divisao.components.form_detalhes')
    </x-adminlte-card>
@stop