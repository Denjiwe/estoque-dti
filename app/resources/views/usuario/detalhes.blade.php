@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Detalhes de {{$usuario->nome}}</h1>
@endsection

@section('content')
    <x-box titulo="Visualizar">
        <x-slot:body>
            @include('usuario.components.user_show')
        </x-slot:body>
    </x-box>
@stop