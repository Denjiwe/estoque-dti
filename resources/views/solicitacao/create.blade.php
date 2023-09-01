@extends('adminlte::page')

@section('title', 'Solicitar')

@section('content_header')
    <h1>Solicitar Produtos</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        @include('solicitacao.components.form_create')
    </x-adminlte-card>
@stop