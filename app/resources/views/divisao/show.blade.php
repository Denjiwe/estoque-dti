@extends('adminlte::page')

@section('title', $divisao->nome)

@section('content_header')
    <h1>Detalhes de Divisão</h1>
@endsection

@section('content')
    <x-box titulo="Divisão {{$divisao->nome}}" id="content">
        <x-slot:body>
            @include('divisao.components.form_detalhes')
        </x-slot:body>
    </x-box>
@stop