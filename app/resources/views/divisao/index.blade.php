@extends('adminlte::page')

@section('title', 'Divisões')

@section('content_header')
    <h1>Cadastro de Divisões</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="Pesquisar">
        <x-slot:body>
            <div class="row ">
                <div class="col-3">
                    <label for="IdDivisao">Id da Divisão</label>
                    <input type="text" id="IdDivisao" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeDivisao">Nome da Divisao</label>
                    <input type="text" id="nomeDivisao" class="form-control">
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
                            <td>{{$divisao->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$divisao->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
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
        <x-modal id="editarModal{{$divisao->id}}" titulo="Editar{{$divisao->nome}}">
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
            if (confirm('Tem certeza que quer excluir a divisão?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop