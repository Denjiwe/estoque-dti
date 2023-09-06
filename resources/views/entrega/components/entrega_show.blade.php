<div class="row">
    <div class="col-6 col-md-2">
        <label for="id" class="fom-label">Id</label>
        <input type="text" id="id" name="id" value="{{ $entrega->id ?? old('id') }}" placeholder="id" class="form-control" readonly>
    </div>

    <div class="col-6 col-md-3 col-xxl-2">
        <label for="solicitacao_id" class="fom-label">Código da Solicitacao</label>
        <input type="text" id="solicitacao_id" name="solicitacao_id" value="{{ $entrega->solicitacao->id }}" class="form-control" readonly>
    </div>

    <div class="col-6 col-md-4 col-xxl-6">
        <label for="modelo_produto" class="fom-label">Produto</label>
        <input type="text" class="form-control" value="{{ $entrega->produto->modelo_produto }}" readonly>
    </div>

    <div class="col-6 col-md-3 col-xxl-2">
        <label for="quantidade" class="fom-label">Quantidade Entregue</label>
        <input type="text" id="quantidade" name="solicitacao_id" value="{{ $entrega->qntde }}" class="form-control" readonly>
    </div>

@php
    $dataCriacao = strtotime($entrega->created_at);
    $dataAtualizado = strtotime($entrega->updated_at);
@endphp

    <div class="col-6 col-md-3 mt-3">
        <label for="user_interno" class="fom-label">Funcionário Interno</label>
        <input type="text" class="form-control" value="{{ $entrega->usuario->nome }}" readonly>
    </div>

    <div class="col-6 col-md-3 mt-3">
        <label for="user_solicitante" class="fom-label">Funcionário Solicitante</label>
        <input type="text" value="{{ $entrega->solicitacao->usuario->nome }}" class="form-control" readonly>
    </div>

    <div class="col-6 col-md-3 mt-3">
        <label for="status" class="fom-label">Data de Entrega</label>
        <input type="text" class="form-control" value="{{ date('d/m/Y H:i:s', $dataCriacao) }}" readonly>
    </div>

    <div class="col-6 col-md-3 mt-3">
        <label for="status" class="fom-label">Data de Atualização</label>
        <input type="text" class="form-control" value="{{ date('d/m/Y H:i:s', $dataAtualizado)}}" readonly>
    </div>
</div>

<div class="mt-3 row justify-content-end">
    <div class="col-auto">
        <a href="{{ route('entregas.index') }}"><button class="btn btn-secondary me-2">Voltar</button></a>

        <a href="{{route('solicitacoes.update', ['id' => $entrega->solicitacao->id])}}">
            <button class="btn btn-primary">Ir para a Solicitação</button>
        </a>
    </div>
</div>