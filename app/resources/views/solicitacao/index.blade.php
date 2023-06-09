@extends('adminlte::page')

@section('title', 'Solicitações')

@section('content_header')
    <h1>Solicitações</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar">
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
    <x-box titulo="{{ $titulo }}">
        <x-slot:body>
            @if (count($solicitacoes) > 0)
            <table class="table text-center table-hover table-bordered" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Divisão</th>
                        <th>Diretoria</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitacoes as $key => $solicitacao)
                    @php
                        $dataCriacao = strtotime($solicitacao->created_at);
                        $dataEdicao = strtotime($solicitacao->updated_at);
                    @endphp
                        <tr>
                            <td>{{$solicitacao->id}}</td>
                            <td>{{$solicitacao->nome_usuario}}</td>
                            <td>{{$solicitacao->nome_divisao ? $solicitacao->nome_divisao : 'Nenhuma'}}</td>
                            <td>{{$solicitacao->nome_diretoria}}</td>
                            <td>{{$solicitacao->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$solicitacao->id}}" class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        {{-- <form id="form_{{$solicitacao->id}}" action="{{route('solicitacoes.destroy', ['solicitacao' => $solicitacao->id])}}" method="post">
                                        @csrf
                                        @method('DELETE') --}}
                                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$solicitacao->id}})" title="Excluir">
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
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                </div>
            </div>
        </x-slot:footer>
    </x-box>
@stop