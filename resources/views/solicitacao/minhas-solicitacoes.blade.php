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
                <button class="nav-link active me-3" id="nav-abertos-tab" data-bs-toggle="tab" data-bs-target="#nav-abertos" type="button" role="tab" aria-controls="nav-abertos" aria-selected="true">Abertos/Liberados</button>
                <button class="nav-link me-3" id="nav-aguardando-tab" data-bs-toggle="tab" data-bs-target="#nav-aguardando" type="button" role="tab" aria-controls="nav-aguardando" aria-selected="false">Aguardando</button>
                <button class="nav-link" id="nav-encerrados-tab" data-bs-toggle="tab" data-bs-target="#nav-encerrados" type="button" role="tab" aria-controls="nav-encerrados" aria-selected="false">Encerrados</button>
            </nav>
            @if (count($solicitacoes) > 0)
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-abertos" role="tabpanel" aria-labelledby="nav-abertos-tab" tabindex="0">
                        <x-tabela-solicitacao solicitacoes='{{ json_encode($solicitacoes) }}' status="ABERTO"></x-tabela-solicitacao>
                    </div>
                    <div class="tab-pane fade" id="nav-aguardando" role="tabpanel" aria-labelledby="nav-aguardando-tab" tabindex="0">
                        <x-tabela-solicitacao solicitacoes="{{ json_encode($solicitacoes)  }}" status="AGUARDANDO"></x-tabela-solicitacao>
                    </div>
                    <div class="tab-pane fade" id="nav-encerrados" role="tabpanel" aria-labelledby="nav-encerrados-tab" tabindex="0">
                        <x-tabela-solicitacao solicitacoes="{{ json_encode($solicitacoes) }}" status="ENCERRADO"></x-tabela-solicitacao>
                    </div>
                </div>
            @endif
        </x-slotbody>

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
        button.nav-link {
            background-color: #c3c3c3 !important;
        }
        button.nav-link.active {
            background-color: #0d6efd !important;
        }
    </style>
@stop