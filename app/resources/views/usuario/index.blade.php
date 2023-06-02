@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Cadastro de Usuários</h1>
@endsection

@section('content')
    @if(isset($sucesso))
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
        </svg>
        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Successo:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                <p>{{$sucesso}}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar">
        <x-slot:body>
            <div class="row">
                <div class="col-3">
                    <label for="IdOrgao">Id do Usuário</label>
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
            @if (count($usuarios) > 0)
            <table class="table text-center table-hover table-bordered" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Usuário Interno</th>
                        <th>Diretoria</th>
                        <th>Divisão</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $key => $usuario)
                    @php
                        $dataCriacao = strtotime($usuario->created_at);
                        $dataEdicao = strtotime($usuario->updated_at);
                    @endphp
                        <tr>
                            <td>{{$usuario->id}}</td>
                            <td>{{$usuario->nome}}</td>
                            <td>{{$usuario->status}}</td>
                            <td>{{$usuario->user_interno == 'SIM' ? 'Sim' : 'Não'}}</td>
                            <td>{{$usuario->diretoria->nome}}</td>
                            <td>{{$usuario->divisao ? $usuario->divisao->nome : 'Não possui'}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{route('usuarios.edit', ['usuario' => $usuario->id])}}">
                                            <button class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('usuarios.show', ['usuario' => $usuario->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$usuario->id}}" action="{{route('usuarios.destroy', ['usuario' => $usuario->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$usuario->id}})" title="Excluir">
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
                            <li class="page-item"><a class="page-link {{ $usuarios->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $usuarios->previousPageUrl() }}">Anterior</a></li>
                                @for($i = 1; $i <= $usuarios->lastPage(); $i++)
                                    <li class="page-item {{ $usuarios->currentPage() == $i ? 'active' : ''}}">
                                        <a class="page-link" href="{{ $usuarios->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            <li class="page-item"><a class="page-link {{ $usuarios->currentPage() == $usuarios->lastPage() ? 'disabled' : ''}}" href="{{ $usuarios->nextPageUrl() }}">Próxima</a></li>
                        </x-slot:content>
                    </x-paginate>
                </div>
                <div class="col-6">
                    <a href="{{route('usuarios.create')}}"><button type="button" class="btn btn-primary float-end">Adicionar</button></a>
                </div>
            </div>
        </x-slot:footer>
    </x-box>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o usuário?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop