@extends('adminlte::page')

@section('title', 'Divisões')

@section('content_header')
    <h1>Cadastro de Divisões</h1>
@endsection

@section('content')
    {{-- Box de exibição --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $titulo }}</h3>
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

        <div class="row mt-3">
            <div class="col-6">
                <x-paginate>
                    <x-slot:content>
                        <li class="page-item"><a class="page-link {{ $divisoes->withQueryString()->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $divisoes->withQueryString()->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $divisoes->withQueryString()->lastPage(); $i++)
                                <li class="page-item {{ $divisoes->withQueryString()->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $divisoes->withQueryString()->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $divisoes->withQueryString()->currentPage() == $divisoes->withQueryString()->lastPage() ? 'disabled' : ''}}" href="{{ $divisoes->withQueryString()->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                <a href="{{route('divisao.index')}}">
                    <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                </a>
            </div>
            
        </div>
    </x-adminlte-card>

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
            if (confirm('Tem certeza que quer excluir a divisão? As impressoras a ela cadastradas serão excluídas também!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop