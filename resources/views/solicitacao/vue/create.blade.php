@extends('solicitacao.vue.page')

@section('title', 'Minhas Solicitações')

@section('content')
    <layout nome="{{ auth()->user()->nome }}">
        <solicitar></solicitar>
    </layout>
@stop
