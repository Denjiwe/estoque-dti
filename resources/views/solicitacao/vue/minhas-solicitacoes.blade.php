@extends('solicitacao.vue.page')

@section('title', 'Minhas Solicitações')

@section('content')
    <layout nome="{{ auth()->user()->nome }}">
        <minhas-solicitacoes 
            :solicitacoes="{{ json_encode($solicitacoes) }}"
        />
    </layout>
@stop