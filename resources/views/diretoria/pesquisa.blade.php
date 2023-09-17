@extends('adminlte::page')

@section('title', 'Diretorias')

@section('content_header')
    <h1>Cadastro de Diretorias</h1>
@endsection

@section('content')
    {{-- Box de exibição --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $titulo }}</h3>

        @if (count($diretorias) > 0)

        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Órgão</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diretorias as $key => $diretoria)
                    @php

                        $dataCriacao = strtotime($diretoria->created_at);
                        $dataEdicao = strtotime($diretoria->updated_at);
                    @endphp
                        <tr>
                            <td>{{$diretoria->id}}</td>
                            <td>{{$diretoria->nome}}</td>
                            <td>{{$diretoria->orgao->nome}}</td>
                            <td>{{ucfirst(strtolower($diretoria->status))}}</td>
                            <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y', $dataEdicao))}}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$diretoria->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('diretorias.show', ['diretoria' => $diretoria->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form id="form_{{$diretoria->id}}" action="{{route('diretorias.destroy', ['diretoria' => $diretoria->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-default text-danger mx-1 shadow" type="button" onclick="excluir({{$diretoria->id}})" title="Excluir">
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
                        <li class="page-item"><a class="page-link {{ $diretorias->withQueryString()->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $diretorias->withQueryString()->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $diretorias->withQueryString()->lastPage(); $i++)
                                <li class="page-item {{ $diretorias->withQueryString()->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $diretorias->withQueryString()->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $diretorias->withQueryString()->currentPage() == $diretorias->withQueryString()->lastPage() ? 'disabled' : ''}}" href="{{ $diretorias->withQueryString()->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                <a href="{{route('diretorias.index')}}">
                    <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                </a>
            </div>
    </x-adminlte-card>

    <x-adminlte-modal id="adicionarModal" title="Adicionar Diretoria" v-centered>
        @component('diretoria.components.form_create_edit', ['orgaos' => $orgaos])
        @endcomponent
        <x-slot name="footerSlot">
        </x-slot>
    </x-adminlte-modal>

    @foreach($diretorias as $diretoria)
        <x-adminlte-modal id="editarModal{{$diretoria->id}}" title="Editar {{$diretoria->nome}}" v-centered>
            @component('diretoria.components.form_create_edit', ['diretoria' => $diretoria, 'orgaos' => $orgaos])
            @endcomponent
            <x-slot name="footerSlot">
            </x-slot>
        </x-adminlte-modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a diretoria? As divisões e as impressoras ligadas serão excluídas!!!')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop