@extends('adminlte::page')

@section('title', 'Cadastrar Usuário')

@section('content_header')
    <h1>Cadastro de Usuários</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Cadastro</h3>

        @include('entrega.components.entrega_show')
    </x-adminlte-card>
@stop