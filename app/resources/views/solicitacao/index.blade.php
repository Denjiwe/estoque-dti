@extends('adminlte::page')

@section('title', 'Solicitações')

@section('content_header')
    <h1>Solicitações</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar" id="searchBox">
        <x-slot:body>
            <div class="row">
                <div class="col-3">
                    <label for="IdOrgao">Id da Solicitação</label>
                    <input type="text" id="IdOrgao" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeOrgao">Nome do Usuário</label>
                    <input type="text" id="nomeOrgao" class="form-control">
                </div>
                <div class="col-3 pt-4 mt-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                </div>
            </div>

        </x-slot:body>
    </x-box>

    {{-- Box de exibição --}}
    <x-box titulo="{{ $titulo }}" id="main">
        <x-slot:body>
            <nav class="nav nav-pills nav-justified mt-3 mb-3">
                <a href="{{$rota == 'todas' ?  route('solicitacoes.abertas') : route('minhas-solicitacoes.abertas')}}" class="nav-link @if($ativo == 'abertas') active @endif me-3 solicitacao">Abertos/Liberados</a>
                <a href="{{$rota == 'todas' ? route('solicitacoes.aguardando') : route('minhas-solicitacoes.aguardando')}}" class="nav-link @if($ativo == 'aguardando') active @endif me-3 solicitacao">Aguardando</a>
                <a href="{{$rota == 'todas' ? route('solicitacoes.encerradas') : route('minhas-solicitacoes.encerradas')}}" class="nav-link @if($ativo == 'encerradas') active @endif solicitacao">Encerrados</a>
            </nav>

            <x-tabela-solicitacao solicitacoes='{{ json_encode($solicitacoes) }}'></x-tabela-solicitacao>
        </x-slot:body>

        <x-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <x-paginate>
                        <x-slot:content>
                            <li class="page-item"><a class="page-link {{ $solicitacoes->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $solicitacoes->previousPageUrl() }}">Anterior</a></li>
                                @for($i = 1; $i <= $solicitacoes->lastPage(); $i++)
                                    <li class="page-item {{ $solicitacoes->currentPage() == $i ? 'active' : ''}}">
                                        <a class="page-link" href="{{ $solicitacoes->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            <li class="page-item"><a class="page-link {{ $solicitacoes->currentPage() == $solicitacoes->lastPage() ? 'disabled' : ''}}" href="{{ $solicitacoes->nextPageUrl() }}">Próxima</a></li>
                        </x-slot:content>
                    </x-paginate>
                </div>
                <div class="col-6">
                    <a href="{{ route('solicitacoes.store') }}"><button type="button" class="btn btn-primary float-end" >Criar</button></a>
                </div>
            </div>
        </x-slot:footer>
    </x-box>

    <style scoped>
        a.nav-link.solicitacao {
            background-color: #c3c3c3 !important;
        }
        a.nav-link.active.solicitacao {
            background-color: #0d6efd !important;
        }
    </style>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a solicitação? As entregas feitas serão excluídas também e o estoque será atualizado')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop