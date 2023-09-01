@extends('adminlte::page')

@section('title', 'Entregas')

@section('content_header')
    <h1>Entregas Realizadas</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>Pesquisar</h3>
        <form action="{{ route('entregas.pesquisa') }}" method="GET">
            <div class="row">
                    <div class="col-7 col-sm-7 col-xl-3 col-lg-4 col-xxl-2">
                        <label for="campo">Campo de pesquisa</label>
                        <select id="campo" class="form-select">
                            <option value="id" selected>ID</option>
                            <option value="solicitacao">Código da Solicitação</option>
                            <option value="interno">Usuário Interno</option>
                            <option value="solicitante">Usuário Solicitante</option>
                            <option value="diretoria">Nome da Diretoria</option>
                            <option value="divisao">Nome da Divisão</option>
                            <option value="produto">Produto</option>
                            <option value="created_at">Data de Entrega</option>
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
        <h3>{{ $titulo }}</h3>

        @if (count($entregas) > 0)
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código da Solicitação</th>
                    <th>Funcionário Interno</th>
                    <th>Funcionário Solicitante</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data de Entrega</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entregas as $key => $entrega)
                @php
                    $dataCriacao = strtotime($entrega->created_at);
                @endphp
                    <tr>
                        <td>{{$entrega->id}}</td>
                        <td><a href="{{route('solicitacoes.update', ['id' => $entrega->solicitacao->id])}}">#{{$entrega->solicitacao->id}}</td>
                        <td>{{$entrega->usuario->nome}}</td>
                        <td>{{$entrega->solicitacao->usuario->nome}}</td>
                        <td>{{$entrega->produto->modelo_produto}}</td>
                        <td>{{$entrega->qntde}}</td>
                        <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <a href="{{route('entregas.show', ['entrega' => $entrega->id])}}">
                                        <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </button>
                                    </a>
                                </div>

                                <div class="col">
                                    <form id="form_{{$entrega->id}}" action="{{route('entregas.destroy', ['entrega' => $entrega->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                        <button class="btn btn-sm btn-default text-danger mx-1 shadow" type="button" onclick="excluir({{$entrega->id}})" title="Excluir">
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
                        <li class="page-item"><a class="page-link {{ $entregas->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $entregas->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $entregas->lastPage(); $i++)
                                <li class="page-item {{ $entregas->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $entregas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $entregas->currentPage() == $entregas->lastPage() ? 'disabled' : ''}}" href="{{ $entregas->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
        </div>
    </x-adminlte-card>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a entrega? O estoque será atualizado!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }
    </script>
    <script src="{{asset('js/pesquisaEntrega.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@stop