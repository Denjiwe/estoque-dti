@extends('adminlte::page')

@section('title', 'Atender Solicitação')

@section('content_header')
    <h1>Alterar Solicitação #{{ $solicitacao->id }}</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        @include('solicitacao.components.form_edit')
    </x-adminlte-card>
@stop