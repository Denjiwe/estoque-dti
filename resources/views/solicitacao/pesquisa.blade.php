@extends('adminlte::page')

@section('title', 'Solicitações')

@section('content_header')
    <h1>Solicitações</h1>
@endsection

@section('content')
    {{-- Box de exibição --}}
    <x-adminlte-card theme="primary" theme-mode="outline">
        <h3>{{ $titulo }}</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach($errors->all() as $error)
                        <li class="m-0">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table text-center table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome do Usuário</th>
                    <th>Diretoria</th>
                    <th>Divisão</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Data de Atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitacoes as $solicitacao)
                @php
                    $dataCriacao = strtotime($solicitacao->created_at);
                    $dataEdicao = strtotime($solicitacao->updated_at);
                    $primeiroNome = explode(' ', $solicitacao->usuario->nome)[0];
                @endphp
                    <tr>
                        <td>{{$solicitacao->id}}</td>
                        <td>{{$primeiroNome}}</td>
                        <td>{{$solicitacao->diretoria->nome}}</td>
                        <td>{{$solicitacao->divisao != null ? $solicitacao->divisao->nome : 'Nenhuma'}}</td>
                        <td>{{ucfirst(strtolower($solicitacao->status))}}</td>
                        <td>{{(date('d/m/Y', $dataCriacao))}}</td>
                        <td>{{(date('d/m/Y', $dataEdicao))}}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('solicitacoes.update', ['id' => $solicitacao->id]) }}">
                                        <button class="btn btn-sm btn-default text-primary shadow" type="button" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </button>
                                    </a>
                                </div>
                                <div class="col">
                                    <form id="form_{{$solicitacao->id}}" action="{{route('solicitacoes.destroy', ['id' => $solicitacao->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                        <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$solicitacao->id}})" title="Excluir">
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

        <div class="row mt-3">
            <div class="col-6">
                <x-paginate>
                    <x-slot:content>
                        <li class="page-item"><a class="page-link {{ $solicitacoes->withQueryString()->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $solicitacoes->withQueryString()->previousPageUrl() }}">Anterior</a></li>
                            @for($i = 1; $i <= $solicitacoes->withQueryString()->lastPage(); $i++)
                                <li class="page-item {{ $solicitacoes->withQueryString()->currentPage() == $i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $solicitacoes->withQueryString()->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        <li class="page-item"><a class="page-link {{ $solicitacoes->withQueryString()->currentPage() == $solicitacoes->withQueryString()->lastPage() ? 'disabled' : ''}}" href="{{ $solicitacoes->withQueryString()->nextPageUrl() }}">Próxima</a></li>
                    </x-slot:content>
                </x-paginate>
            </div>
            <div class="col-6">
                <a href="{{ route('solicitacoes.store') }}"><button type="button" class="btn btn-primary float-end" >Criar</button></a>
                <a href="{{ route('solicitacoes.abertas') }}">
                    <button type="button" class="btn me-2 btn-secondary float-end">Voltar</button>
                </a>
            </div>
        </div>
    </x-adminlte-card>
@stop

@section('js')
    <script> 
        function excluir(id) {
            if (confirm('Tem certeza que quer excluir a solicitação? As entregas feitas serão excluídas também e o estoque será atualizado')) {                                                       
                document.getElementById('form_'+id).submit()                                                    
            }
        }

    </script>
@stop