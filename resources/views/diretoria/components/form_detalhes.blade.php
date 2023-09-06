<ul class="nav nav-tabs" id="Tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="dados-gerais-tab" data-bs-toggle="tab" data-bs-target="#dados-gerais-tab-pane" type="button" role="tab" aria-controls="dados-gerais-tab-pane" aria-selected="true">Dados Gerais</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="divisoes-tab" data-bs-toggle="tab" data-bs-target="#divisoes-tab-pane" type="button" role="tab" aria-controls="divisoes-tab-pane" aria-selected="false">Divisões</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios-tab-pane" type="button" role="tab" aria-controls="usuarios-tab-pane" aria-selected="false">Usuários</button>
    </li>
</ul>

<div class="tab-content" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="dados-gerais-tab-pane" role="tabpanel" aria-labelledby="dados-gerais-tab" tabindex="0">
        <div class="row">
            <div class="col-4">
                <label for="nome" class="fom-label">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ $diretoria->nome ?? old('nome') }}" placeholder="Nome" class="form-control" disabled>
            </div>
            <div class="col-4">
                <label for="status" class="fom-label">E-mail</label>
                <input type="text" id="status" name="status" value="{{ $diretoria->email ?? old('email') }}" placeholder="Nenhum" class="form-control" disabled>
            </div>
            <div class="col-4">
                <label for="status" class="fom-label">Status</label>
                <input type="text" id="status" name="status" value="{{ ucfirst(strtolower($diretoria->status)) ?? old('status') }}" placeholder="Status" class="form-control" disabled>
            </div>
        </div>
    </div>

    <div class="tab-pane fade mt-2" id="divisoes-tab-pane" role="tabpanel" aria-labelledby="divisoes-tab" tabindex="0">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @if(count($diretoria->divisoes) == 0)
                    <tr>
                        <td colspan="4">Nenhuma divisão cadastrada</td>
                    </tr>
                @else 
                    @foreach($diretoria->divisoes as $divisao)
                        <tr>
                            <td>{{ $divisao->id }}</td>
                            <td>{{ $divisao->nome }}</td>
                            <td>{{ ucfirst(strtolower($divisao->status)) }}</td>
                            <td style="max-width: 150px">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{route('divisao.index')}}">
                                            <button class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('divisao.show', ['divisao' => $divisao->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade mt-2" id="usuarios-tab-pane" role="tabpanel" aria-labelledby="usuarios-tab" tabindex="0">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Divisão</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @if(count($diretoria->usuarios) == 0)
                    <tr>
                        <td colspan="3">Nenhum usuário cadastrado</td>
                    </tr>
                @else 
                    @foreach($diretoria->usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nome }}</td>
                            <td>{{ $usuario->divisao ? $usuario->divisao->nome : 'Nenhuma' }}</td>
                            <td>{{ ucfirst(strtolower($usuario->status)) }}</td>
                            <td style="width: 150px">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{route('usuarios.edit', ['usuario' => $usuario->id])}}">
                                            <button class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('usuarios.show', ['usuario' => $usuario->id])}}">
                                            <button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-end mt-3">
    <div class="col-auto">
        <a href="{{ route('diretorias.index') }}" class="btn btn-secondary me-2">Voltar</a>
    </div>
</div>