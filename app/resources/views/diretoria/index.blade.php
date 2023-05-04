@extends('adminlte::page')

@section('title', 'Diretorias')

@section('content_header')
    <h1>Cadastro de Diretorias</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar">
        <x-slot:body>
            <div class="row">
                <div class="col-3">
                    <label for="IdDiretoria">Id da Diretoria</label>
                    <input type="text" id="IdDiretoria" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeDiretoria">Nome da Diretoria</label>
                    <input type="text" id="nomeDiretoria" class="form-control">
                </div>
                <div class="col-3 pt-4 mt-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                </div>
            </div>
        </x-slot:body>
    </x-box>

    {{-- Box de exibição --}}
    <x-box titulo="{{ $titulo }}">
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
                            <td>{{$diretoria->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$diretoria->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
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
        <x-modal id="editarModal{{$diretoria->id}}" titulo="Editar{{$diretoria->nome}}">
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
            if (confirm('Tem certeza que quer excluir a diretoria?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop