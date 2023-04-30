@extends('adminlte::page')

@section('title', 'Órgãos')

@section('content_header')
    <h1>Cadastro de Órgãos</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <Box titulo="Pesquisar">
        <template v-slot:body>
            <div class="row">
                <div class="col-3">
                    <label for="IdOrgao">Id do Órgão</label>
                    <input type="text" id="IdOrgao" class="form-control">
                </div>
                <div class="col-3">
                    <label for="nomeOrgao">Nome do Órgão</label>
                    <input type="text" id="nomeOrgao" class="form-control">
                </div>
                <div class="col-3 pt-4 mt-2">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>                 
                <div>
            </div>

        </template>

        <template v-slot:footer>
                
        </template>
    </Box>

    {{-- Box de exibição --}}
    <Box titulo="{{ $titulo }}">
        <template v-slot:body>
            @if (count($orgaos) > 0)
            <table class="table text-center table-hover table-bordered" >
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
                            <td>{{$orgao->status}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataCriacao))}}</td>
                            <td>{{(date('d/m/Y H:i:s', $dataEdicao))}}</td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <button data-bs-toggle="modal" data-bs-target="#editarModal{{$orgao->id}}" class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
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
            @endif
        </template>

        <template v-slot:footer>
            <div class="row mt-3">
                <div class="col-6">
                    <Paginate>
                        <li class="page-item"><a class="page-link {{ $orgaos->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $orgaos->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $orgaos->lastPage(); $i++)
                                <li class="page-item {{ $orgaos->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $orgaos->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $orgaos->currentPage() == $orgaos->lastPage() ? 'disabled' : ''}}" href="{{ $orgaos->nextPageUrl() }}">Próxima</a></li>
                    </Paginate>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar</button>
                </div>
            </div>
        </template>
    </Box>

    <Modal id="adicionarModal" titulo="Adicionar Órgão">
        <template v-slot:body>
            @component('orgao._components.form_create_edit')
            @endcomponent
        </template>
    </Modal>

    @foreach($orgaos as $orgao)
        <Modal id="editarModal{{$orgao->id}}" titulo="Editar{{$orgao->nome}}">
            <template v-slot:body>
                @component('orgao._components.form_create_edit', ['orgao' => $orgao])
                @endcomponent
            </template>
        </Modal>
    @endforeach
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir o órgão?')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop