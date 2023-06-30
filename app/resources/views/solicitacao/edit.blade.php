@extends('adminlte::page')

@section('title', 'Atender Solicitação')

@section('content_header')
    <h1>Alterar Solicitação #{{ $solicitacao->id }}</h1>
@endsection

@section('content')
    <x-box titulo="Solicitar">
        <x-slot:body>
            @include('solicitacao.components.form_edit')
        </x-slot:body>
    </x-box>
@stop