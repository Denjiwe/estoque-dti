@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Pesquisa de Usuários</h1>
@endsection

@section('content')
    {{-- Box de exibição --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $titulo }}</h3>

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
                        <td>{{ucfirst(strtolower($usuario->status))}}</td>
                        <td>{{$usuario->user_interno == 'SIM' ? 'Sim' : 'Não'}}</td>
                        <td>{{$usuario->diretoria->nome}}</td>
                        <td>{{$usuario->divisao ? $usuario->divisao->nome : 'Não possui'}}</td>
                        <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                        <td>{{(date('d/m/Y', $dataEdicao))}}</td>
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

        <div class="row mt-3">
            <div class="col-6">
                <x-paginate>
                    <x-slot:content>
                        <li class="page-item"><a class="page-link {{ $usuarios->withQueryString()->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $usuarios->withQueryString()->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $usuarios->withQueryString()->lastPage(); $i++)
                                <li class="page-item {{ $usuarios->withQueryString()->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $usuarios->withQueryString()->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $usuarios->withQueryString()->currentPage() == $usuarios->withQueryString()->lastPage() ? 'disabled' : ''}}" href="{{ $usuarios->withQueryString()->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
            <div class="col-6">
                <a href="{{route('usuarios.create')}}"><button type="button" class="btn btn-primary float-end">Adicionar</button></a>
                <a href="{{route('usuarios.index')}}">
                    <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                </a>
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
@stop