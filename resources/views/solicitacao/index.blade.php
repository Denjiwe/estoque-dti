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
    <x-box titulo="Pesquisar" id="searchBox">
        <x-slot:body>
            <form action="{{ route('solicitacoes.pesquisa') }}" method="GET">
                <div class="row">
                    <div class="col-2">
                        <label for="campo">Selecione o campo de pesquisa</label>
                        <select id="campo" class="form-select">
                            <option value="id" selected>ID</option>
                            <option value="nome">Nome do Usuário</option>
                            <option value="diretoria">Nome da Diretoria</option>
                            <option value="divisao">Nome da Divisão</option>
                            <option value="status">Status</option>
                            <option value="created_at">Data de Criação</option>
                            <option value="updated_at">Data de Atualização</option>
                        </select>
                    </div>
                    <div class="col-2" id="pesquisa">
                        <label for="id">ID</label>
                        <input type="number" name="id" min="1" placeholder="Informe o ID" class="form-control" required>
                    </div>
                    <div class="col-3 pt-4 mt-2">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                    </div>
                </div>
            </form>
        </x-slot:body>
    </x-box>

    {{-- Box de exibição --}}
    <x-box titulo="{{ $titulo }}" id="main">
        <x-slot:body>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="m-0">
                        @foreach($errors->all() as $error)
                            <li class="m-0">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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

        url = new URL(window.location.href);
        url.searchParams.delete("mensagem");
        url.searchParams.delete("color");
        window.history.pushState('object or string', 'Title', url)
    </script>
    <script src="{{ asset('js/pesquisaSolicitacao.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop