<form action="{{ route('solicitacoes.update', ['id' => $solicitacao->id]) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nome_usuario">Nome do Usuário</label>
        <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" value="{{ $solicitacao->nome_usuario }}" readonly>
    </div>
    <div class="form-group">
        <label for="divisao_id">Divisão</label>
        <select class="form-control" id="divisao_id" name="divisao_id" readonly>
            <option value="{{ $solicitacao->divisao_id }}">{{ $solicitacao->nome_divisao }}</option>
        </select>
    </div>
    <div class="form-group">
        <label for="diretoria_id">Diretoria</label>
        <select class="form-control" id="diretoria_id" name="diretoria_id" readonly>
            <option value="{{ $solicitacao->diretoria_id }}">{{ $solicitacao->nome_diretoria }}</option>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-select" id="status" name="status" >
            <option value="{{ $solicitacao->status }}">{{ ucfirst(strtolower($solicitacao->status)) }}</option>
            @if($solicitacao->status != 'ABERTO')<option value="ABERTO">Aberto</option>@endif
            @if($solicitacao->status != 'AGUARDANDO') <option value="AGUARDANDO">Aguardando</option>@endif
            @if($solicitacao->status != 'ENCERRADO') <option value="ENCERRADO">Encerrado</option>@endif
        </select>
    </div>

    <div class="row justify-content-end mt-3">
        <div class="col-auto">
            <a href="{{url()->previous() == route('solicitacoes.update', ['id' => $solicitacao->id]) ? route('solicitacoes.index') : url()->previous()}}" class="btn btn-secondary me-2">Voltar</a>
            <button type="submit" class="btn btn-primary">Aplicar</button>
        </div>
    </div>

</form>