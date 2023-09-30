<ul class="nav nav-tabs" id="Tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="dados-gerais-tab" data-toggle="tab" data-target="#dados-gerais-tab-pane" type="button" role="tab" aria-controls="dados-gerais-tab-pane" aria-selected="true">Dados Gerais</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="solicitacoes-tab" data-toggle="tab" data-target="#solicitacoes-tab-pane" type="button" role="tab" aria-controls="solicitacoes-tab-pane" aria-selected="false">Solicitações</button>
    </li>
</ul>

<div class="tab-content" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="dados-gerais-tab-pane" role="tabpanel" aria-labelledby="dados-gerais-tab" tabindex="0">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <label for="nome" class="fom-label">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ $usuario->nome ?? old('nome') }}" placeholder="Nome" class="form-control" disabled>
            </div>

            <div class="col-sm-6 col-md-4 mt-3 mt-sm-0">
                <label for="email" class="fom-label">Email</label>
                <input type="text" id="email" name="email" value="{{ $usuario->email }}" placeholder="Email" class="form-control" disabled>
            </div>

            <div class="col-sm-6 col-md-4 mt-3 mt-md-0">
                <label for="user_interno" class="fom-label">Funcionário Interno</label>
                <input type="text" class="form-control" value="{{$usuario->user_interno == 'SIM' ? 'Sim' : 'Não'}}" disabled>
            </div>

            <div class="col-sm-6 col-md-6 mt-3">
                <label for="status" class="fom-label">Status</label>
                <input type="text" class="form-control" value="{{$usuario->status == 'ATIVO' ? 'Ativo' : 'Inativo'}}" disabled>
            </div>

            <div class="col-sm-12 col-md-6 mt-3">
                <label for="cpf" class="fom-label">CPF</label>
                <input type="text" name="cpf" id="cpf" maxlength="11" value="{{ $usuario->cpf ?? old('cpf') }}" placeholder="CPF" class="form-control" disabled>
            </div>

            <div class="col-sm-12 col-md-6 mt-3">
                <label for="diretoria_id" class="fom-label">Diretoria</label>
                <input type="text" class="form-control" value="{{$usuario->diretoria->nome}}" disabled>
            </div>

            <div class="col-sm-12 col-md-6 mt-3">
                <label for="divisao_id" class="fom-label">Divisão</label>
                <input type="text" class="form-control" value="{{isset($usuario->divisao->nome) ? $usuario->divisao->nome : 'Nenhuma'}}" disabled>
            </div>
        </div>
    </div>

    <div class="tab-pane fade mt-2" id="solicitacoes-tab-pane" role="tabpanel" aria-labelledby="solicitacoes-tab" tabindex="0">
    @if ($config['data'] == [])
        <h3>O usuário não criou nenhuma solicitação!</h3>
    @else
        <x-adminlte-datatable id="table" :heads="$heads" :config="$config" bordered beautify compressed/>
    @endif
    </div>

    <div class="mt-3 float-right">
        <a href="{{ route('usuarios.index') }}"><button type="button" class="btn btn-secondary float-end me-2">Voltar</button></a>
        <a href="{{route('usuarios.edit', ['usuario' => $usuario->id])}}"><button class="btn btn-primary float-end" id="btnSubmit" type="submit">Editar</button></a>
    </div>
</div>