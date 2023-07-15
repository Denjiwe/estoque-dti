@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Bem-vindo, {{ explode(' ', auth()->user()->nome)[0] }}!</h1>
@endsection

@section('content')
<div class="row ms-1">
    <div class="col-2">
        <x-adminlte-info-box title="Entregas" text="{{ $entregas }}" icon="fas fa-lg fa-clipboard-check text-dark" theme="gradient-teal" icon-theme="white"/>
    </div>
    <div class="col-2">
        <x-adminlte-info-box title="Solicitações" text="{{ $solicitacoes }}" icon="fas fa-lg fa-clipboard text-dark" theme="danger" icon-theme="white"/>
    </div>
    <div class="col-2">
        <x-adminlte-info-box title="Usuários" text="{{ $usuarios }}" icon="fas fa-lg fa-user text-dark" theme="gradient-primary" icon-theme="white"/>
    </div>
    <div class="col-2">
        <x-adminlte-info-box title="Produtos" text="{{ $produtos }}" icon="fas fa-lg fa-kaaba text-dark" theme="gradient-secondary" icon-theme="white"/>
    </div>
    <div class="col-4">
        <x-adminlte-profile-widget name="{{ auth()->user()->nome }}" theme="primary">
            <x-adminlte-profile-col-item class="text-primary border-right" icon="fas fa-lg fa-clipboard-check"
            title="Entregas" text="25" size=6 badge="primary"/>
            <x-adminlte-profile-col-item class="text-danger" icon="fas fa-lg fa-clipboard-list" title="Chamados Encerrados"
            text="10" size=6 badge="danger"/>
        </x-adminlte-profile-widget>
    </div>
</div>
@endsection
