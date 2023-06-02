<form method="post" action="{{ route('solicitacoes.store') }}">
@csrf
    <div class="row justify-content-center">
        <div class="col-4">
            <label for="diretoria">Diretoria</label>
            <select name="diretoria_id" id="diretoria" class="form-select">
                @foreach($diretorias as $diretoria)
                    <option value="{{$diretoria->id}}" @if($usuario->diretoria_id == $diretoria->id) selected @endif>{{$diretoria->nome}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-4">
            <label for="divisao">Divisão</label>
            <select name="divisao_id" id="divisao" class="form-select">
                @foreach($divisoes as $divisao)
                <option value="{{$divisao->id}}" @if(isset($usuario->divisao_id) && $usuario->divisao_id == $divisao->id) selected @endif>{{$divisao->nome}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-4">
            <label for="usuario">Usuario</label>
            <select name="usuario_id" id="usuario" class="form-select">
                @foreach($usuarios as $usuarioSelect)
                <option value="{{$usuarioSelect->id}}" @if($usuario->id == $usuarioSelect->id) selected @endif>{{$usuarioSelect->nome}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-4">
            <label for="impressora" class="fom-label">Selecione o modelo da impressora</label>
            <select name="impressora" id="impressora" class="form-select">
                <option value="0" selected hidden>-- Impressora --</option>
                @foreach ($impressoras as $impressora)
                    <option value="{{$impressora->id}}">{{$impressora->modelo_produto}}</option>
                @endforeach
            </select>
            {{ $errors->has('impressora') ? $errors->first('impressora') : '' }}
        </div>

        <div class="col-3">
            <label for="suprimento" class="fom-label">Selecione o tipo do suprimento</label>
            <select name="suprimento" id="suprimento" class="form-select">
                <option value="0" selected hidden>-- Suprimento --</option>
                <option value="TONER">Toner</option>
                <option value="CILINDRO">Cilindro</option>
                <option value="CONJUNTO">Conjunto</option>
            </select>
        </div>
        
        <div class="col-3">
            <label for="quantidade" class="form-label">Informe a quatidade</label>
            <input type="number" name="quantidade" min="1" max="2" id="quantidade" class="form-control">
        </div>

        <div class="col-2 mt-2">
            <button type="button" class="btn btn-primary mt-4" id="adicionar">Adicionar</button>
        </div>
    </div>

    <div id="produtos" class="mt-3">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Impressora</th>
                    <th id="produtoTr">Produtos</th>
                    <th>Quantidade</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>

    <label for="observacao">Observação(opcional)</label>
    <input type="text" name="observacao" id="observacao" class="form-control">

    <div class="row justify-content-end mt-3">
        <div class="col-auto">
            <a href="{{url()->previous() == route('solicitacoes.create') ? route('solicitacoes.index') : url()->previous()}}" class="btn btn-secondary me-2">Voltar</a>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </div>
</form>

@section('js')
    <script src="{{ asset('js/solicitacao.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop