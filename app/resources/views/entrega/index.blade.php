@extends('adminlte::page')

@section('title', 'Entregas')

@section('content_header')
    <h1>Entregas Realizadas</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar">
        <x-slot:body>
            <div class="row ">
                <div class="col-3">
                    <label for="idEntrega">Id da Entrega</label>
                    <input type="text" id="idEntrega" class="form-control">
                </div>
                <div class="col-3">
                    <label for="produtoEntrega">Produto da Entrega</label>
                    <input type="text" id="produtoEntrega" class="form-control">
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
            @if (count($entregas) > 0)
            <table class="table text-center table-hover table-bordered">
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
        </x-slot:body>

        <x-slot:footer>
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
        </x-slot:footer>
    </x-box>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a entrega? O estoque será atualizado!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }
    </script>
@stop