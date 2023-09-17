@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <h1>Relatórios</h1>
@endsection

@section('content')

    @if(session()->get('mensagem'))
        <div class="position-fixed top-0 pt-5 mt-3 pe-2 end-0" style="z-index: 11">
            <div class="toast fade show align-items-center bg-{{ session()->get('color') }}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session()->get('mensagem') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <x-adminlte-card theme="primary" theme-mode="outline">
        <form action="{{ route('relatorios.pesquisa') }}" method="POST">
            @csrf
            <div class="row ">
                <div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-sm-0">
                    <label for="item">Item do Relatório</label>
                    <select id="item" name="item" class="form-select" required>
                        <option value="" selected hidden>-- Selecione --</option>
                        <option value="entregas">Entregas</option>
                        <option value="impressoras">Impressoras</option>
                        <option value="produtos">Produtos</option>
                        <option value="usuarios">Usuários</option>
                        <option value="solicitacoes">Solicitações</option>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-sm-0">
                    <label for="tipo">Por</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="" selected hidden>-- Selecione --</option>
                        <option value="Orgao">Órgão</option>
                        <option value="Diretoria">Diretoria</option>
                        <option value="Divisao">Divisão</option>
                        <option value="Usuario">Usuário</option>
                        <option value="Solicitacao">Solicitação</option>
                        <option value="Entrega">Entrega</option>
                        <option value="Produto">Produto</option>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-sm-0">
                    <label for="campo">Filtro</label>
                    <select id="campo" name="campo" class="form-control form-select" disabled>
                        <option value="todos" selected>Todos</option>
                        <option value="id">ID</option>
                        <option value="nome">Nome</option>
                    </select>
                </div>
                <div id="dataDiv" class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-md-0">
                    <label for="data">Data</label>
                    <select id="data" name="data" class="form-select">
                        <option value="qualquer" selected>Qualquer</option>
                        <option value="hoje">Hoje</option>
                        <option value="ontem">Ontem</option>
                        <option value="semana">Última Semana</option>
                        <option value="mes">Últimos 30 dias</option>
                        <option value="ultimo_mes">Este mês</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
                <div id="formato" class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0">
                    <label for="formato">Formato</label>
                    <select id="formato" name="formato" class="form-select">
                        <option value="pdf" selected>PDF</option>
                        <option value="xslx">XSLX</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>
            </div>
            <div class="row justify-content-end mt-3">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Gerar</button>
                </div>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('css')
    <style scoped>
        .nome-item {
            border-left: 1px solid #d4d4d4;
            border-right: 1px solid #d4d4d4;
            border-bottom: 1px solid #d4d4d4;
            background-color: #fff;
            padding-left: 5px;
            z-index: 99;
            cursor: pointer;
        }

        .nome-item:hover {
            background-color: #e9e9e9;
        }

        #nome {
            position: absolute;
            width: 92%;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/relatorio.js') }}" type="module"></script>
    <script src="{{asset('js/handleToasts.js')}}"></script>
@stop
