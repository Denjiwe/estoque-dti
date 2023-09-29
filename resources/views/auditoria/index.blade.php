@extends('adminlte::page')

@section('title', 'Auditoria')

@section('content_header')
    <h1>Auditoria</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <form action="{{ route('auditorias.pesquisa') }}" method="POST">
            @csrf
            <div class="row ">
                <div class="col-6 col-sm-4 col-md-2">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                        <option value="Todos" selected>Todos</option>
                        <option value="Orgao">Órgão</option>
                        <option value="Diretoria">Diretoria</option>
                        <option value="Divisao">Divisão</option>
                        <option value="Usuario">Usuário</option>
                        <option value="Solicitacao">Solicitação</option>
                        <option value="Entrega">Entrega</option>
                        <option value="Produto">Produto</option>
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <label for="acao">Ação</label>
                    <select id="acao" name="acao" class="form-control">
                        <option value="Todos" selected>Todos</option>
                        <option value="created">Criação</option>
                        <option value="updated">Atualização</option>
                        <option value="deleted">Exclusão</option>
                    </select>
                </div>
                <div id="dataDiv" class="col-6 col-sm-4 col-md-2 mt-3 mt-sm-0">
                    <label for="data">Data</label>
                    <select id="data" name="data" class="form-control">
                        <option value="hoje" selected>Hoje</option>
                        <option value="ontem">Ontem</option>
                        <option value="semana">Última Semana</option>
                        <option value="mes">Últimos 30 dias</option>
                        <option value="ultimo_mes">Este mês</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
                <div class="col-6 col-sm-2 pt-4 mt-4 mt-md-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                </div>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script src="{{ asset('js/auditoria.js') }}"></script>
@stop