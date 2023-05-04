@extends('adminlte::page')

@section('title', 'Cadastrar Usuário')

@section('content_header')
    <h1>Cadastro de Usuários</h1>
@endsection

@section('content')
    <x-box titulo="Cadastro">
        <x-slot:body>
            @include('usuario.components.form_create_edit')
        </x-slot:body>
    </x-box>
@stop