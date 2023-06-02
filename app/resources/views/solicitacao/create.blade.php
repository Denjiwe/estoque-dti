@extends('adminlte::page')

@section('title', 'Solicitar')

@section('content_header')
    <h1>Solicitar Produtos</h1>
@endsection

@section('content')
    <x-box titulo="Solicitar">
        <x-slot:body>
            @include('solicitacao.components.form_create')
        </x-slot:body>
    </x-box>
@stop