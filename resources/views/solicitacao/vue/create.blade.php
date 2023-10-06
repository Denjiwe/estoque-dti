@extends('solicitacao.vue.page')

@section('title', 'Minhas Solicitações')

@section('content')
    <layout nome="{{ auth()->user()->nome }}">
        <solicitar
            :usuario-id="{{ auth()->user()->id }}"
            :impressoras="{{ $impressoras }}"
        ></solicitar>
    </layout>
@stop
