@extends('adminlte::page')

@section('title', 'Diretorias')

@section('content_header')
    <h1>Cadastro de Diretorias</h1>
@endsection

@section('content')
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
            <table class="table text-center table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Órgão</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diretorias as $key => $diretoria)
                    @php

                        $dataCriacao = strtotime($diretoria->created_at);
                        $dataEdicao = strtotime($diretoria->updated_at);
                    @endphp
                        <tr>
                            <td>{{$diretoria->id}}</td>
                            <td>{{$diretoria->nome}}</td>
                            <td>{{$diretoria->orgao->nome}}</td>
                            <td>{{ucfirst(strtolower($diretoria->status))}}</td>
                            <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$diretoria->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('diretorias.show', ['diretoria' => $diretoria->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$diretoria->id}}" action="{{route('diretorias.destroy', ['diretoria' => $diretoria->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger mx-1 shadow" type="button" onclick="excluir({{$diretoria->id}})" title="Excluir">
                                                <i class="fa fa-lg fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </x-slot:body>

        <x-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <x-paginate>
                        <x-slot:content>
                            <li class="page-item"><a class="page-link {{ $diretorias->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $diretorias->previousPageUrl() }}">Anterior</a></li>
                                @for($i = 1; $i <= $diretorias->lastPage(); $i++)
                                    <li class="page-item {{ $diretorias->currentPage() == $i ? 'active' : ''}}">
                                        <a class="page-link" href="{{ $diretorias->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            <li class="page-item"><a class="page-link {{ $diretorias->currentPage() == $diretorias->lastPage() ? 'disabled' : ''}}" href="{{ $diretorias->nextPageUrl() }}">Próxima</a></li>
                        </x-slot:content>
                    </x-paginate>
                </div>
                <div class="col-6">
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
            if (confirm('Tem certeza que quer excluir a diretoria? As divisões e as impressoras ligadas serão excluídas!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
    <script src="{{asset('js/pesquisa.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop