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
            <th>Divisão</th>
            <th>Diretoria</th>
            <th>Status</th>
            <th>Data de Criação</th>
            <th>Data de Atualização</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitacoes->data as $solicitacao)
        @php
            $dataCriacao = strtotime($solicitacao->created_at);
            $dataEdicao = strtotime($solicitacao->updated_at);
            $primeiroNome = explode(' ', $solicitacao->nome_usuario)[0];
        @endphp
        @if($solicitacao->status == $status)
            <tr>
                <td>{{$solicitacao->id}}</td>
                <td>{{$primeiroNome}}</td>
                <td>{{$solicitacao->nome_divisao ? $solicitacao->nome_divisao : 'Nenhuma'}}</td>
                <td>{{$solicitacao->nome_diretoria}}</td>
                <td>{{$solicitacao->status}}</td>
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
                            {{-- <form id="form_{{$solicitacao->id}}" action="{{route('solicitacoes.destroy', ['solicitacao' => $solicitacao->id])}}" method="post">
                            @csrf
                            @method('DELETE') --}}
                                <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir({{$solicitacao->id}})" title="Excluir">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endif
        @endforeach
    </tbody>
</table>