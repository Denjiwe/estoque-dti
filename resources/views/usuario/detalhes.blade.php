@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Detalhes de {{$usuario->nome}}</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Visualizar</h3>

        @include('usuario.components.user_show')
    </x-adminlte-card>
@stop