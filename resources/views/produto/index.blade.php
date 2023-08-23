@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@endsection

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
            <form action="{{ route('produtos.pesquisa') }}" method="GET">
                <div class="row ">
                    <div class="col-2">
                        <label for="campo">Selecione o campo de pesquisa</label>
                        <select id="campo" class="form-select">
                            <option value="id" selected>ID</option>
                            <option value="tipo">Tipo</option>
                            <option value="modelo">Modelo</option>
                            <option value="quantidade">Quantidade</option>
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
            @if (count($produtos) > 0)
            <table class="table text-center table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
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
                            <td>{{ucfirst(strtolower($produto->tipo_produto))}}</td>
                            <td>{{$produto->modelo_produto}}</td>
                            <td>{{$produto->qntde_estoque}}</td>
                            <td>{{ucfirst(strtolower($produto->status))}}</td>
                            <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y', $dataEdicao))}}</td>
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
        </x-slot:body>

        <x-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <x-paginate>
                        <x-slot:content>
                        <li class="page-item"><a class="page-link {{ $produtos->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $produtos->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $produtos->lastPage(); $i++)
                                <li class="page-item {{ $produtos->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $produtos->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $produtos->currentPage() == $produtos->lastPage() ? 'disabled' : ''}}" href="{{ $produtos->nextPageUrl() }}">Próxima</a></li>
                        </x-slot:content>
                    </x-paginate>
                </div>
                <div class="col-6 justify-content-end">
                    <a href="{{route('produtos.create')}}" class="float-end"><button type="button" class="btn btn-primary">Adicionar</button></a>
                </div>
            </div>
        </x-slot:footer>
    </x-box>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o produto?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

        url = new URL(window.location.href);
        url.searchParams.delete("mensagem");
        url.searchParams.delete("color");
        window.history.pushState('object or string', 'Title', url)
    </script>

    <script src="{{asset('js/pesquisaProduto.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop