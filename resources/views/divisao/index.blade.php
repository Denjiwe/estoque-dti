@extends('adminlte::page')

@section('title', 'Divisões')

@section('content_header')
    <h1>Cadastro de Divisões</h1>
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
            <form action="{{ route('divisoes.pesquisa') }}" method="GET">
                <div class="row ">
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
                        <input type="number" name="id" min="1" placeholder="Informe o ID" class="form-control" required>
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
            @if (count($divisoes) > 0)
            <table class="table text-center table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Diretoria</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($divisoes as $key => $divisao)
                    @php
                        $dataCriacao = strtotime($divisao->created_at);
                        $dataEdicao = strtotime($divisao->updated_at);
                    @endphp
                        <tr>
                            <td>{{$divisao->id}}</td>
                            <td>{{$divisao->nome}}</td>
                            <td>{{$divisao->diretoria->nome}}</td>
                            <td>{{ucfirst(strtolower($divisao->status))}}</td>
                            <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$divisao->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('divisao.show', ['divisao' => $divisao->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$divisao->id}}" action="{{route('divisao.destroy', ['divisao' => $divisao->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger mx-1 shadow" type="button" onclick="excluir({{$divisao->id}})" title="Excluir">
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
                            <li class="page-item"><a class="page-link {{ $divisoes->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $divisoes->previousPageUrl() }}">Anterior</a></li>
                                @for($i = 1; $i <= $divisoes->lastPage(); $i++)
                                    <li class="page-item {{ $divisoes->currentPage() == $i ? 'active' : ''}}">
                                        <a class="page-link" href="{{ $divisoes->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            <li class="page-item"><a class="page-link {{ $divisoes->currentPage() == $divisoes->lastPage() ? 'disabled' : ''}}" href="{{ $divisoes->nextPageUrl() }}">Próxima</a></li>
                        </x-slot:content>
                    </x-paginate>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                </div>
            </div>
        </x-slot:footer>
    </x-box>

    <x-modal id="adicionarModal" titulo="Adicionar Divisão">
        <x-slot:body>
            @component('divisao.components.form_create_edit', ['diretorias' => $diretorias])
            @endcomponent
        </x-slot:body>
    </x-modal>

    @foreach($divisoes as $divisao)
        <x-modal id="editarModal{{$divisao->id}}" titulo="Editar {{$divisao->nome}}">
            <x-slot:body>
                @component('divisao.components.form_create_edit', ['divisao' => $divisao, 'diretorias' => $diretorias])
                @endcomponent
            </x-slot:body>
        </x-modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a divisão? O vínculo com as impressoras dessa divisão serão excluídas também!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }
    </script>
    <script src="{{asset('js/handleToasts.js')}}"></script>
    <script src="{{asset('js/pesquisa.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop