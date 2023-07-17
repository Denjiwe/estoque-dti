@extends('adminlte::page')

@section('title', 'Auditoria')

@section('content_header')
    <h1>Auditoria</h1>
@endsection

@section('content')
    <x-box>
        <x-slot:body>
            <form action="{{ route('auditoria.pesquisa') }}" method="GET">
                <div class="row ">
                    <div class="col-2">
                        <label for="tipo">Tipo</label>
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
                        <label for="acao">Ação</label>
                        <select id="acao" name="acao" class="form-select">
                            <option value="Todos" selected>Todos</option>
                            <option value="created">Criação</option>
                            <option value="updated">Atualizado</option>
                            <option value="deleted">Excluído</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="data">Data</label>
                        <select id="data" name="data" class="form-select">
                            <option value="today" selected>Hoje</option>
                            <option value="week">Última Semana</option>
                            <option value="month">Último mês</option>
                            <option value="customized">Personalizado</option>
                        </select>
                    </div>
                    <div class="col-3 pt-4 mt-2">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                    </div>
                </div>
            </form>
        </x-slot:body>
    </x-box>
@stop

@section('js')
    <script src="{{ asset('js/auditoria.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop