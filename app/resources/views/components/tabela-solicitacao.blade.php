@props(['solicitacoes', 'status'])
@php
    $solicitacoes = htmlspecialchars_decode($solicitacoes);
    $solicitacoes = json_decode($solicitacoes);
@endphp
<table class="table text-center table-hover">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome do Usuário</th>
            <th>Diretoria</th>
            <th>Divisão</th>
            <th>Status</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitacoes->data as $solicitacao)
        @php
            $dataCriacao = strtotime($solicitacao->created_at);
            $dataEdicao = strtotime($solicitacao->updated_at);
            $primeiroNome = explode(' ', $solicitacao->usuario->nome)[0];
            $liberado = false;
        @endphp
            <tr>
                <td>{{$solicitacao->id}}</td>
                <td>{{$primeiroNome}}</td>
                <td>{{$solicitacao->diretoria->nome}}</td>
                <td>{{$solicitacao->divisao != null ? $solicitacao->divisao->nome : 'Nenhuma'}}</td>
                <td>{{ucfirst(strtolower($solicitacao->status))}}</td>
                <td>{{(date('d/m/Y', $dataCriacao))}}</td>
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