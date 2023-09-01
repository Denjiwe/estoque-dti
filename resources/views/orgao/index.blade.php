@extends('adminlte::page')

@section('title', 'Órgãos')

@section('content_header')
    <h1>Cadastro de Órgãos</h1>
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

    <x-adminlte-card  theme="primary" theme-mode="outline">
        <h3>Pesquisar</h3>
        <form action="{{ route('orgao.pesquisa') }}" method="GET">
                <div class="row">
                    <div class="col-7 col-sm-7 col-xl-3 col-lg-4 col-xxl-2">
                        <label for="campo">Campo de pesquisa</label>
                        <select id="campo" class="form-select">
                            <option value="id" selected>ID</option>
                            <option value="nome">Nome</option>
                            <option value="status">Status</option>
                            <option value="created_at">Data de Criação</option>
                            <option value="updated_at">Data de Atualização</option>
                        </select>
                    </div>
                    <div class="col-5 col-sm-5 col-xl-3 col-lg-4 col-xxl-2" id="pesquisa">
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
        <h3>Órgãos Cadastrados</h3>
        
        @if (count($orgaos) > 0)
            <x-adminlte-datatable id="table" :heads="$heads" :config="$config" head-theme="dark" compressed/>
        @endif
        
        <div class="row mt-3 mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
            </div>
        </div>
    </x-adminlte-card>

    <x-modal id="adicionarModal" titulo="Adicionar Órgão">
        <x-slot:body>
            @component('orgao.components.form_create_edit')
            @endcomponent
        </x-slot:body>
    </x-modal>

    @foreach($orgaos as $orgao)
        <x-modal id="editarModal{{$orgao->id}}" titulo="Editar {{$orgao->nome}}">
            <x-slot:body>
                @component('orgao.components.form_create_edit', ['orgao' => $orgao])
                @endcomponent
            </x-slot:body>
        </x-modal>
    @endforeach
    
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o órgão? Todas as diretorias criadas nesse órgão serão excluídas, além das divisões e impressoras a elas atreladas!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }
    </script>
    <script src="{{asset('js/handleToasts.js')}}"></script>
    <script src="{{asset('js/pesquisa.js')}}"></script>
@stop
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('css')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@stop