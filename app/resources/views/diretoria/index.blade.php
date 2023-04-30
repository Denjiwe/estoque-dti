@extends('adminlte::page')

@section('title', 'Diretorias')

@section('content_header')
    <h1>Cadastro de Diretorias</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <Box titulo="Pesquisar">
        <template v-slot:body>
            <div class="row">
                <div class="col-3">
                    <label for="IdDiretoria">Id da Diretoria</label>
                    <input type="text" id="IdDiretoria" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeDiretoria">Nome da Diretoria</label>
                    <input type="text" id="nomeDiretoria" class="form-control">
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
            @if (count($diretorias) > 0)
            <table class="table text-center table-hover table-bordered">
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
                            <td>{{$diretoria->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$diretoria->id}}" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
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
            @endif
        </template>

        <template v-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <Paginate>
                        <li class="page-item"><a class="page-link {{ $diretorias->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $diretorias->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $diretorias->lastPage(); $i++)
                                <li class="page-item {{ $diretorias->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $diretorias->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $diretorias->currentPage() == $diretorias->lastPage() ? 'disabled' : ''}}" href="{{ $diretorias->nextPageUrl() }}">Próxima</a></li>
                    </Paginate>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                </div>
            </div>
        </template>
    </Box>

    <Modal id="adicionarModal" titulo="Adicionar Diretoria">
        <template v-slot:body>
            @component('diretoria._components.form_create_edit', ['orgaos' => $orgaos])
            @endcomponent
        </template>
    </Modal>

    @foreach($diretorias as $diretoria)
        <Modal id="editarModal{{$diretoria->id}}" titulo="Editar{{$diretoria->nome}}">
            <template v-slot:body>
                @component('diretoria._components.form_create_edit', ['diretoria' => $diretoria, 'orgaos' => $orgaos])
                @endcomponent
            </template>
        </Modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a diretoria?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop