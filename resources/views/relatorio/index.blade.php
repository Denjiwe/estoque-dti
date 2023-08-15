@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <h1>Relatórios</h1>
@endsection

@section('content')
    <x-box>
        <x-slot:body>
            <form action="{{ route('relatorios.pesquisa') }}" method="POST">
                @csrf
                <div class="row ">
                    <div class="col-2">
                        <label for="item">Item do Relatório</label>
                        <select id="item" name="item" class="form-select">
                            <option value="todos" selected>Todos</option>
                            <option value="suprimentos">Suprimentos</option>
                            <option value="entregas">Entregas</option>
                            <option value="impressoras">Impressoras</option>
                            <option value="usuarios">Usuário</option>
                            <option value="solicitacoes">Solicitação</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="tipo">Por</label>
                        <select id="tipo" name="tipo" class="form-select">
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
                    <div class="col-2">
                        <label for="campo">Campo</label>
                        <select id="campo" name="campo" class="form-select">
                            <option value="todos" selected>Todos</option>
                            <option value="id">ID</option>
                            <option value="nome">Nome</option>
                        </select>
                    </div>
                    <div id="dataDiv" class="col-2">
                        <label for="data">Data</label>
                        <select id="data" name="data" class="form-select">
                            <option value="hoje" selected>Hoje</option>
                            <option value="ontem">Ontem</option>
                            <option value="semana">Última Semana</option>
                            <option value="mes">Últimos 30 dias</option>
                            <option value="ultimo_mes">Este mês</option>
                            <option value="personalizado">Personalizado</option>
                        </select>
                    </div>
                    <div class="col-2 pt-4 mt-2">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                    </div>
                </div>
            </form>
        </x-slot:body>
    </x-box>
@stop

@section('js')
    <script src="{{ asset('js/relatorio.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop