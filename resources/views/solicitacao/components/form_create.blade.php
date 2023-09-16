<form method="post" action="{{ route('solicitacoes.store') }}">
@csrf
    <h3 style="color: red">{{$errors != []? $errors->first() : ''}}</h3>
    @if(auth()->user()->user_interno == 'SIM')
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                <label for="diretoria">Diretoria</label>
                <select name="diretoria_id" id="diretoria" class="form-select">
                    @foreach($diretorias as $diretoria)
                        <option value="{{$diretoria->id}}" @if($usuario->diretoria_id == $diretoria->id) selected @endif>{{$diretoria->nome}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                <label for="divisao">Divisão</label>
                <select name="divisao_id" id="divisao" class="form-select">
                    <option value="">Nenhuma</option>
                    @foreach($divisoes as $divisao)
                        <option value="{{$divisao->id}}" @if(isset($usuario->divisao_id) && $usuario->divisao_id == $divisao->id) selected @endif>{{$divisao->nome}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 mt-3 mt-md-0">
                <label for="usuario">Usuario</label>
                <select name="usuario_id" id="usuario" class="form-select">
                    <option value="{{$usuario->id}}">{{$usuario->nome}}</option>
                    @foreach($usuarios as $usuarioSelect)
                        @if($usuarioSelect->id != $usuario->id)
                            <option value="{{$usuarioSelect->id}}">{{$usuarioSelect->nome}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mt-3">
        <div class="col-6 col-md-4">
            <label for="impressora" class="fom-label">Modelo da impressora</label>
            <select id="impressora" class="form-select">
                <option value="0" selected hidden>-- Impressora --</option>
                @foreach ($impressoras as $impressora)
                    <option value="{{$impressora->id}}">{{$impressora->modelo_produto}}</option>
                @endforeach
            </select>
            {{ $errors->has('impressora') ? $errors->first('impressora') : '' }}
        </div>

        <div class="col-6 col-md-3">
            <label for="suprimento" class="fom-label">Tipo do suprimento</label>
            <select id="suprimento" class="form-select">
                <option value="0" selected hidden>-- Suprimento --</option>
                <option value="TONER">Toner</option>
                <option value="CILINDRO">Cilindro</option>
                <option value="CONJUNTO">Conjunto</option>
            </select>
        </div>

        <div class="col-6 col-md-3 mt-3 mt-md-0">
            <label for="quantidade" class="form-label">Informe a quatidade</label>
            <input type="number" name="quantidade" min="1" max="2" id="quantidade" class="form-control">
        </div>

        <div class="col-6 col-md-2 mt-4 mt-md-2">
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

    <label for="observacao">Observação (opcional)</label>
    <input type="text" name="observacao" id="observacao" class="form-control">

    <div class="row justify-content-end mt-3">
        <div class="col-auto">
            <a href="{{url()->previous() == route('solicitacoes.create') ? route('solicitacoes.abertas') : url()->previous()}}" class="btn btn-secondary me-2">Voltar</a>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </div>
</form>

@section('js')
    <script src="{{asset('js/solicitacao.js')}}" type="module"></script>
@stop
