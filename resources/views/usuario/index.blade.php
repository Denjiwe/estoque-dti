@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Cadastro de Usuários</h1>
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

    {{-- Box de pesquisa --}}
    <x-adminlte-card theme="primary" theme-mode="outline"> 
        <form action="{{ route('usuarios.pesquisa') }}" method="GET">
            <div class="row">
                <div class="col-12 col-sm-7 col-xl-3 col-lg-4 col-xxl-2">
                    <label for="campo">Campo de pesquisa</label>
                    <select id="campo" class="form-select">
                        <option value="id" selected>ID</option>
                        <option value="nome">Nome</option>
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
        <h3>Usuários Cadastrados</h3>

        @if (count($usuarios) > 0)
            <x-adminlte-datatable id="table" :heads="$heads" :config="$config" head-theme="dark" compressed/>
        @endif
        
        <div class="row mt-3 mb-3">
            <div class="col-12">
                <a href="{{route('usuarios.create')}}"><button type="button" class="btn btn-primary float-end">Adicionar</button></a>
            </div>
        </div>
    </x-adminlte-card>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o usuário?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }
    </script>
    <script src="{{asset('js/handleToasts.js')}}"></script>
    <script src="{{asset('js/pesquisaUsuario.js')}}"></script>
@stop
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('css')
    <link href="{{asset('css/index.css')}}" rel="stylesheet">
@stop