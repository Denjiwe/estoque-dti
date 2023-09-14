@extends('adminlte::page')

@section('title', 'Solicitações')

@section('content_header')
    <h1>Solicitações</h1>
@endsection

@section('content')

    @if(isset($_GET['color']))
        <div class="position-fixed top-0 pt-5 mt-3 pe-2 end-0" style="z-index: 11">
            <div class="toast fade show align-items-center bg-{{$_GET['color']}}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $_GET['mensagem'] }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Box de pesquisa --}}
    <x-adminlte-card theme="primary" theme-mode="outline" title="Pesquisar" collapsible>
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
    </x-adminlte-card>

    {{-- Box de exibição --}}
    <x-adminlte-card>
        <h3>{{$titulo}}</h3>
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
    </x-adminlte-card>

    <style scoped>
        button.nav-link {
            background-color: #c2c2c2 !important;
            color: #2c2c2c !important;
        }
        button.nav-link.active {
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
    <script src="{{asset('js/handleToasts.js')}}"></script>
    <script src="{{ asset('js/pesquisaSolicitacao.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop
