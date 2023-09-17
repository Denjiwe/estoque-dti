@extends('adminlte::page')

@section('title', 'Órgãos')

@section('content_header')
    <h1>Cadastro de Órgãos</h1>
@endsection

@section('content')
    {{-- Box de exibição --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $titulo }}</h3>

        @if (count($orgaos) > 0)
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orgaos as $key => $orgao)
                    @php
                        $dataCriacao = strtotime($orgao->created_at);
                        $dataEdicao = strtotime($orgao->updated_at);
                    @endphp
                        <tr>
                            <td>{{$orgao->id}}</td>
                            <td>{{$orgao->nome}}</td>
                            <td>{{ucfirst(strtolower($orgao->status))}}</td>
                            <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$orgao->id}}" class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('orgaos.show', ['orgao' => $orgao->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$orgao->id}}" action="{{route('orgaos.destroy', ['orgao' => $orgao->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$orgao->id}})" title="Excluir">
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
        </div>
        @endif

        <div class="row mt-3">
            <div class="col-6">
                <x-paginate>
                    <x-slot:content>
                        <li class="page-item"><a class="page-link {{ $orgaos->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $orgaos->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $orgaos->lastPage(); $i++)
                                <li class="page-item {{ $orgaos->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $orgaos->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $orgaos->currentPage() == $orgaos->lastPage() ? 'disabled' : ''}}" href="{{ $orgaos->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                <a href="{{route('orgaos.index')}}">
                    <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                </a>
            </div>
    </x-adminlte-card>

    <x-adminlte-modal id="adicionarModal" title="Adicionar Órgão" v-centered>
        @component('orgao.components.form_create_edit')
        @endcomponent
        <x-slot name="footerSlot">
        </x-slot>
    </x-adminlte-modal>

    @foreach($orgaos as $orgao)
        <x-adminlte-modal id="editarModal{{$orgao->id}}" title="Editar {{$orgao->nome}}" v-centered>
            @component('orgao.components.form_create_edit', ['orgao' => $orgao])
            @endcomponent
            <x-slot name="footerSlot">
            </x-slot>
        </x-adminlte-modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o órgão? Todas as diretorias criadas nesse órgão serão excluídas, além das divisões e impressoras a elas atreladas!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop