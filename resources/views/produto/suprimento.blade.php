@extends('adminlte::page')

@section('title', 'Suprimentos')

@section('content_header')
    <h1>Suprimentos para a impressora</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <ul class="nav nav-tabs" id="Tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link disabled" id="dados-gerais-tab" data_id="1" data-bs-toggle="tab" data-bs-target="#dados-gerais-tab-pane" type="button" role="tab" aria-controls="dados-gerais-tab-pane" aria-selected="true">Dados Gerais</button>
            </li>
            <li class="nav-item" role="presentation" id="locais-li">
                <button class="nav-link disabled" id="locais-tab" data-bs-toggle="tab" data_id="2" data-bs-target="#locais-tab-pane" type="button" role="tab" aria-controls="locais-tab-pane" aria-selected="false">Setores da Impressora</button>
            </li>
            <li class="nav-item" role="presentation" id="suprimentos-li" >
                <button class="nav-link active disabled" id="suprimentos-tab" data-bs-toggle="tab" data_id="3" data-bs-target="#suprimentos-tab-pane" type="button" role="tab" aria-controls="suprimentos-tab-pane" aria-selected="false">Suprimentos</button>
            </li>
            <li class="nav-item" role="presentation" style="display:none;" id="impressoras-li" >
                <button class="nav-link disabled" id="impressoras-tab" data-bs-toggle="tab" data_id="4" data-bs-target="#impressoras-tab-pane" type="button" role="tab" aria-controls="impressoras-tab-pane" aria-selected="false">Impressoras</button>
            </li>
        </ul>

        @include('produto.components.form_suprimento')
    </x-adminlte-card>
@stop