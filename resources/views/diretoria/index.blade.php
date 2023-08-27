@extends('adminlte::page')

@section('title', 'Diretorias')

@section('content_header')
    <h1>Cadastro de Diretorias</h1>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
            <form action="{{ route('diretorias.pesquisa') }}" method="GET">
                <div class="row">
                    <div class="col-2">
                        <label for="campo">Selecione o campo de pesquisa</label>
                        <select id="campo" class="form-select">
                            <option value="id" selected>ID</option>
                            <option value="nome">Nome</option>
                            <option value="status">Status</option>
                            <option value="created_at">Data de Criação</option>
                            <option value="updated_at">Data de Atualização</option>
                        </select>
                    </div>
                    <div class="col-2" id="pesquisa">
                        <label for="id">ID</label>
                        <input type="number" name="id" min='1' placeholder="Informe o ID" class="form-control" required>
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
            @if (count($diretorias) > 0)
                <x-adminlte-datatable id="table" :heads="$heads" :config="$config" head-theme="dark" with-footer footer-theme="dark" bordered striped compressed/>
            @endif
        </x-slot:body>

        <x-slot:footer>
            <div class="row mt-3 mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                    @if(Route::currentRouteName() == 'diretorias.pesquisa')
                        <a href="{{route('diretorias.index')}}">
                            <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                        </a>
                    @endif
                </div>
            </div>
        </x-slot:footer>
    </x-box>

    <x-modal id="adicionarModal" titulo="Adicionar Diretoria">
        <x-slot:body>
            @component('diretoria.components.form_create_edit', ['orgaos' => $orgaos])
            @endcomponent
        </x-slot:body>
    </x-modal>

    @foreach($diretorias as $diretoria)
        <x-modal id="editarModal{{$diretoria->id}}" titulo="Editar {{$diretoria->nome}}">
            <x-slot:body>
                @component('diretoria.components.form_create_edit', ['diretoria' => $diretoria, 'orgaos' => $orgaos])
                @endcomponent
            </x-slot:body>
        </x-modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a diretoria? As divisões e as impressoras ligadas serão excluídas também!!!')) {                                                       
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
    <style scoped>
        body {
            overflow-y: hidden;
            overflow-x: hidden;
        }
    </style>
@stop