@extends('adminlte::page')

@section('title', 'Cadastrar Produto')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@endsection

@section('content')
    <x-box titulo="Cadastro">
        <x-slot:body>
            @include('produto.components.form_create_edit')
        </x-slot:body>
    </x-box>
@stop