<ul class="nav nav-tabs" id="Tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="dados-gerais-tab" data-bs-toggle="tab" data-bs-target="#dados-gerais-tab-pane" type="button" role="tab" aria-controls="dados-gerais-tab-pane" aria-selected="true">Dados Gerais</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="solicitacoes-tab" data-bs-toggle="tab" data-bs-target="#solicitacoes-tab-pane" type="button" role="tab" aria-controls="solicitacoes-tab-pane" aria-selected="false">Solicitações</button>
    </li>
</ul>

<div class="tab-content" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="dados-gerais-tab-pane" role="tabpanel" aria-labelledby="dados-gerais-tab" tabindex="0">
        <div class="row">
            <div class="col-3">
                <label for="nome" class="fom-label">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ $usuario->nome ?? old('nome') }}" placeholder="Nome" class="form-control" disabled>
            </div>

            <div class="col-3">
                <label for="email" class="fom-label">Email</label>
                <input type="text" id="email" name="email" value="{{ $usuario->email }}" placeholder="Email" class="form-control" disabled>
            </div>

            <div class="col-2">
                <label for="user_interno" class="fom-label">Funcionário Interno</label>
                <input type="text" class="form-control" value="{{$usuario->user_interno == 'SIM' ? 'Sim' : 'Não'}}" disabled>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-2">
                <label for="cpf" class="fom-label">CPF</label>
                <input type="text" name="cpf" id="cpf" maxlength="11" value="{{ $usuario->cpf ?? old('cpf') }}" placeholder="CPF" class="form-control" disabled>
            </div>

            <div class="col-2">
                <label for="status" class="fom-label">Status</label>
                <input type="text" class="form-control" value="{{$usuario->status == 'ATIVO' ? 'Ativo' : 'Inativo'}}" disabled>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-3">
                <label for="diretoria_id" class="fom-label">Diretoria</label>
                <input type="text" class="form-control" value="{{$usuario->diretoria->nome}}" disabled>
            </div>

            <div class="col-3">
                <label for="divisao_id" class="fom-label">Divisão</label>
                <input type="text" class="form-control" value="{{isset($usuario->divisao->nome) ? $usuario->divisao->nome : 'Nenhuma'}}" disabled>
            </div>
        </div>

        
    </div>
    <div class="tab-pane fade mt-2" id="solicitacoes-tab-pane" role="tabpanel" aria-labelledby="solicitacoes-tab" tabindex="0">
    @if ($solicitacoes == null)
        <h3>O usuário não criou nenhuma solicitação!</h3>
    @else
        <table class="table text-center table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Divisão</th>
                    <th>Diretoria</th>
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
                    $liberado = false;
                @endphp
                <tr>
                    <td>{{$solicitacao->id}}</td>
                    <td>{{$solicitacao->divisao != null ? $solicitacao->divisao->nome : 'Nenhuma'}}</td>
                    <td>{{$solicitacao->diretoria->nome}}</td>
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
            @endforeach
        </tbody>
    </table>
        @endif
    </div>

    <div class="mt-3 row">
        <div class="col-6" id="paginate" style="display: none">
            <x-paginate>
                <x-slot:content>
                    <li class="page-item"><a class="page-link {{ $solicitacoes->currentPage() == 1 ? 'disabled' : ''}}" href="{{ $solicitacoes->previousPageUrl() }}">Anterior</a></li>
                        @for($i = 1; $i <= $solicitacoes->lastPage(); $i++)
                            <li class="page-item {{ $solicitacoes->currentPage() == $i ? 'active' : ''}}">
                                <a class="page-link" href="{{ $solicitacoes->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    <li class="page-item"><a class="page-link {{ $solicitacoes->currentPage() == $solicitacoes->lastPage() ? 'disabled' : ''}}" href="{{ $solicitacoes->nextPageUrl() }}">Próxima</a></li>
                </x-slot:content>
            </x-paginate>
        </div>
        <div class="col-12" id='voltarDiv'>
            <a href="{{ route('usuarios.index') }}"><button type="button" class="btn btn-secondary float-end me-2">Voltar</button></a>
        </div>
    </div>
</div>

@section('js')
    <script>
        let paginate = document.getElementById('paginate'); 
        $('#solicitacoes-tab').on('click', function(){
            paginate.style.display = '';
            $('#voltarDiv').removeClass('col-12').addClass('col-6');
        });

        $('#dados-gerais-tab').on('click', function(){
            paginate.style.display = 'none';
            $('#voltarDiv').removeClass('col-6').addClass('col-12');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop