@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro(s):</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach    
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<form action="{{ route('solicitacoes.update', ['id' => $solicitacao->id]) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="nome_usuario">Nome do Usuário</label>
                <input type="text" class="form-control" id="nome_usuario" value="{{ $solicitacao->usuario->nome }}" readonly>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label for="divisao_id">Divisão</label>
                <input type="text" class="form-control" value="{{ $solicitacao->divisao != null ? $solicitacao->divisao->nome : 'Nenhuma' }}" readonly/>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label for="diretoria_id">Diretoria</label>
                <input type="text" class="form-control" value="{{ $solicitacao->diretoria->nome }}" readonly/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label>Data de Criação</label>
            <div class="form-group">
                <input type="text" class="form-control" id="data_criacao" value="{{ date('d/m/Y H:i:s', strtotime($solicitacao->created_at)) }}" readonly>
            </div>
        </div>

        <div class="col-6">
            <label>Data de Atualização</label>
            <div class="form-group">
                <input type="text" class="form-control" id="data_atualizacao" value="{{ date('d/m/Y H:i:s', strtotime($solicitacao->updated_at)) }}" readonly>
            </div>
        </div>
    </div>

    <div class="row pt-2">
        <div class="col-2">
            <label>Produtos</label>
        </div>

        <div class="col-2">
            <label>Quantidade em Estoque</label>
        </div>

        <div class="col-2">
            <label>Quantidade Total Solicitada</label>
        </div>

        <div class="col-2">
            <label>Quantidade Solicitada</label>
        </div>

        <div class="col-2">
            <label>Quantidade a ser atendida</label>
        </div>
    </div>

    @foreach($solicitacao->produtos as $key => $produto)
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <input type="hidden" name="produto[]" value="{{$produto->id}}">
                    <input type="text" class="form-control" id="produto[]" value="{{$produto->modelo_produto}}" readonly>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <input type="text" class="form-control" value="{{$produto->qntde_estoque}}" readonly>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <input type="text" class="form-control" id="qntde_total_solicitada[]" value="{{$produto->qntde_solicitada}}" readonly>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <input type="text" class="form-control" id="qntde_solicitada[]" value="{{$produto->pivot->qntde}}" readonly>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <input type="number" class="form-control" id="qntde_atendida[]" name="qntde_atendida[]" value="{{  count($solicitacao->entregas) > 0 && isset($solicitacao->entregas[$key]) ? $solicitacao->entregas[$key]->qntde : '0'}}" min="0" max="{{$produto->pivot->qntde}}" >
                </div>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-12">
            <label>Observação da Solicitação</label>
            <div class="form-group">
                <textarea class="form-control" rows="3" maxlength="255" style="resize: none;" readonly>{{ $solicitacao->observacao != null ? $solicitacao->observacao : '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <label>Observação da Entrega</label>
            <div class="form-group">
                <textarea class="form-control" id="observacao" name="observacao" rows="3" maxlength="255" style="resize: none;">{{ count($solicitacao->entregas) > 0 && isset($solicitacao->observacaoEntrega) ? $solicitacao->observacaoEntrega : ''}}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" id="status" name="status" >
                    <option value="{{ $solicitacao->status }}">{{ ucfirst(strtolower($solicitacao->status)) }}</option>
                    @if($solicitacao->status != 'ABERTO')<option value="ABERTO">Aberto</option>@endif
                    @if($solicitacao->status != 'AGUARDANDO') <option value="AGUARDANDO">Aguardando</option>@endif
                    @if($solicitacao->status != 'ENCERRADO') <option value="ENCERRADO">Encerrado</option>@endif
                </select>
            </div>
        </div>
    </div>

    <div class="row justify-content-end mt-3">
        <div class="col-auto">
            <a href="{{url()->previous() == route('solicitacoes.update', ['id' => $solicitacao->id]) ? route('solicitacoes.abertas') : url()->previous()}}" class="btn btn-secondary me-2">Voltar</a>
            <button type="submit" class="btn btn-primary">Aplicar</button>
        </div>
    </div>

</form>