@extends('adminlte::page')

@section('title', 'Solicitações')

@section('content_header')
    <h1>Solicitações</h1>
@endsection

@section('content')

    @if(session()->get('mensagem'))
        <div class="position-fixed top-0 pt-5 mt-3 right-3" style="z-index: 11; top: 0; right: 10px">
            <div class="toast fade show align-items-center bg-{{ session()->get('color') }}" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session()->get('mensagem') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Box de pesquisa --}}
    <x-adminlte-card theme="primary" theme-mode="outline" title="Pesquisar" collapsible="collapsed">
        <form action="{{ route('solicitacoes.pesquisa') }}" method="GET">
            <div class="row">
                <div class="col-12 col-sm-7 col-xl-3 col-lg-4 col-xxl-2">
                    <label for="campo">Campo de pesquisa</label>
                    <select id="campo" class="form-control">
                        <option value="id" selected>ID</option>
                        <option value="nome">Nome do Usuário</option>
                        <option value="diretoria">Nome da Diretoria</option>
                        <option value="divisao">Nome da Divisão</option>
                        <option value="status">Status</option>
                        <option value="created_at">Data de Criação</option>
                        <option value="updated_at">Data de Atualização</option>
                    </select>
                </div>
                <div class="col-12 col-sm-5 col-xl-3 col-lg-4 col-xxl-2 mt-2 mt-sm-0" id="pesquisa">
                    <label for="id">ID</label>
                    <input type="number" name="id" min="1" placeholder="Informe o ID" class="form-control" required>
                </div>
                <div class="col-3 pt-4 mt-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>
            </div>
        </form>
    </x-adminlte-card>

    {{-- Box de exibição --}}
    <x-adminlte-card>
        <h3>{{$titulo}}</h3>

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
        <ul class="nav nav-pills flex-column flex-sm-row" id="Tab" role="tablist">
            <li class="flex-sm-fill text-sm-center nav-item border-bottom-0" role="presentation">
                <a
                    class="nav-link text-center nav-item active solicitacao"
                    id='abertas'
                    data-toggle="tab"
                    data-target="#abertas-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="abertas-tab-pane"
                    aria-selected="true"
                >Abertos/Liberados</a>
            </li>
            <li class="flex-sm-fill text-center nav-item border-bottom-0" role="presentation">
                <a
                    class="nav-link solicitacao"
                    id='aguardando'
                    data-toggle="tab"
                    data-target="#aguardando-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="aguardando-tab-pane"
                    aria-selected="true"
                >Aguardando</a>
            </li>
            <li class="flex-sm-fill text-center nav-item border-bottom-0" role="presentation">
                <a
                    class="nav-link solicitacao"
                    id='encerradas'
                    data-toggle="tab"
                    data-target="#encerradas-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="encerradas-tab-pane"
                    aria-selected="true"
                >Encerradas</a>
            </li>
        </ul>

        <div class="tab-content" id="TabContent">
            <div class="tab-pane fade show active mt-2" id="abertas-tab-pane" role="tabpanel" aria-labelledby="abertas-tab" tabindex="0">
                <x-adminlte-datatable id="tableAbertas" :heads="$heads" :config="$configAbertas" bordered beautify compressed beautify/>
            </div>

            <div class="tab-pane fade mt-2" id="aguardando-tab-pane" role="tabpanel" aria-labelledby="aguardando-tab" tabindex="0">
                <x-adminlte-datatable id="tableAguardando" :heads="$heads" :config="$configAguardando" bordered beautify compressed beautify/>
            </div>

            <div class="tab-pane fade mt-2" id="encerradas-tab-pane" role="tabpanel" aria-labelledby="encerradas-tab" tabindex="0">
                <x-adminlte-datatable id="tableEncerradas" :heads="$heads" :config="$configEncerradas" bordered beautify compressed beautify/>
            </div>
        </div>

        <div class="row justify-content-end mt-3">
            <div class="col-auto">
                <a href="{{ route('solicitacoes.store') }}"><button type="button" class="btn btn-primary float-end" >Criar</button></a>
            </div>
        </div>
    </x-adminlte-card>

    <style scoped>
        button.nav-link.solicitacao {
            background-color: #c2c2c2 !important;
            color: #2c2c2c !important;
        }
        button.nav-link.active.solicitacao {
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
@stop