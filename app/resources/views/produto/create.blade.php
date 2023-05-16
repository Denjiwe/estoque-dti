@extends('adminlte::page')

@section('title', 'Cadastrar Produto')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@endsection

@section('content')
    <x-box>
        <x-slot:header>
            <ul class="nav nav-tabs" id="Tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active disabled" id="dados-gerais-tab" data_id="1" data-bs-toggle="tab" data-bs-target="#dados-gerais-tab-pane" type="button" role="tab" aria-controls="dados-gerais-tab-pane" aria-selected="true">Dados Gerais</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="locais-tab" data-bs-toggle="tab" data_id="2" data-bs-target="#locais-tab-pane" type="button" role="tab" aria-controls="locais-tab-pane" aria-selected="false">Impressoras por setor</button>
                </li>
            </ul>
        </x-slot:header>

        <x-slot:body>
            @include('produto.components.form_create_edit')
        </x-slot:body>
    </x-box>
@stop