@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <Box titulo="Pesquisar">
        <template v-slot:body>
            <div class="row ">
                <div class="col-3">
                    <label for="IdDivisao">Id do Produto</label>
                    <input type="text" id="IdDivisao" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeDivisao">Nome do Produto</label>
                    <input type="text" id="nomeDivisao" class="form-control">
                </div>
                <div class="col-3 pt-4 mt-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                <div>
            </div>
        </template>
    </Box>

    {{-- Box de exibição --}}
    <Box titulo="{{ $titulo }}">
        <template v-slot:body>
            @if (count($produtos) > 0)
            <table class="table text-center table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Quantidade</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $key => $produto)
                    @php
                        $dataCriacao = strtotime($produto->created_at);
                        $dataEdicao = strtotime($produto->updated_at);
                    @endphp
                        <tr>
                            <td>{{$produto->id}}</td>
                            <td>{{$produto->modelo_produto}}</td>
                            <td>{{$produto->qntde_estoque}}</td>
                            <td>{{$produto->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{route('produtos.edit', ['produto' => $produto->id])}}">
                                            <button class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('produtos.show', ['produto' => $produto->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$produto->id}}" action="{{route('produtos.destroy', ['produto' => $produto->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$produto->id}})" title="Excluir">
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
        </template>

        <template v-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <Paginate>
                        <li class="page-item"><a class="page-link {{ $produtos->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $produtos->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $produtos->lastPage(); $i++)
                                <li class="page-item {{ $produtos->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $produtos->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $produtos->currentPage() == $produtos->lastPage() ? 'disabled' : ''}}" href="{{ $produtos->nextPageUrl() }}">Próxima</a></li>
                    </Paginate>
                </div>
                <div class="col-6">
                    <a href="{{route('produtos.create')}}"><button type="button" class="btn btn-primary float-end">Adicionar</button></a>
                </div>
            </div>
        </template>
    </Box>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o produto?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop