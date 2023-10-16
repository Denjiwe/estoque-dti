@if (isset($produto->id))
    <form method="post" id="form" action="{{ route('produtos.update', ['produto' => $produto]) }}">
    @method('PUT')
@else
    <form method="post" id="form" action="{{ route('produtos.store') }}">
@endif
@csrf
<div class="tab-content mt-3" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="dados-gerais-tab-pane" role="tabpanel" aria-labelledby="dados-gerais-tab" tabindex="0">
        <input type="hidden" name="proximo" id="proximoInput" value="nenhum">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-sm-0">
                <label for="tipo_produto">Tipo do Produto</label>
                <select name="tipo_produto" id="tipo_produto" class="form-control @if(isset($produto->tipo_produto)) custom-select @endif @error('tipo_produto') is-invalid @enderror" @if(isset($produto->tipo_produto)) disabled @endif>
                    <option selected hidden>Selecione o Tipo</option>
                    <option value="IMPRESSORA" @if(isset($produto->tipo_produto) && $produto->tipo_produto == 'IMPRESSORA') selected @endif >Impressora</option>
                    <option value="TONER" @if(isset($produto->tipo_produto) && $produto->tipo_produto == 'TONER') selected @endif >Toner</option>
                    <option value="CILINDRO" @if(isset($produto->tipo_produto) && $produto->tipo_produto == 'CILINDRO') selected @endif >Cilíndro</option>
                    <option value="OUTROS" @if(isset($produto->tipo_produto) && $produto->tipo_produto == 'OUTROS') selected @endif >Outros</option>
                </select>
                {{ $errors->has('tipo_produto') ? $errors->first('tipo_produto') : '' }}
            </div>

            <div class="col-12 col-sm-6 col-md-3 mt-3 mt-sm-0">
                <label for="modelo_produto">Modelo do Produto</label>
                <input type="text" id="modelo_produto" name="modelo_produto" value="{{ $produto->modelo_produto ?? old('modelo_produto') }}" placeholder="Modelo do Produto" class="form-control @error('modelo_produto') is-invalid @enderror">
                {{ $errors->has('modelo_produto') ? $errors->first('modelo_produto') : '' }}
            </div>

            @if(isset($produto) && ($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO'))
                <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-md-0">
                    <label for="qntde_solicitada">Quantidade Solicitada</label>
                    <input type="text" id="qntde_solicitada" name="qntde_solicitada" value="{{ $produto->qntde_solicitada }}" placeholder="Quantidade solicitada" class="custom-select" disabled>
                    {{ $errors->has('qntde_solicitada') ? $errors->first('qntde_solicitada') : '' }}
                </div>
            @endif

            <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-md-0">
                <div class="row">
                    <div class="col-12" id="divTipoProduto">
                        <div class="d-flex flex-row">
                            <label for="qntde_estoque">Quantidade</label>
                            <div class="ml-2" id="tooltip" style="display: none; margin-top: 2.9px">
                                <p class="fa fa-sm fa-info-circle align-middle" data-bs-toggle="tooltip" data-bs-placement="right" title="A quantidade é 0 pois na próxima tela serão cadastrados os locais da impressora"></p>
                            </div>
                        </div>
                        <input type="number" id="qntde_estoque" name="qntde_estoque" min="0" value="{{ $produto->qntde_estoque ?? old('qntde_estoque') }}" @if(isset($produto->status) && $produto->tipo_produto == 'IMPRESSORA') disabled @endif placeholder="Quantidade em estoque" class="form-control @if(isset($produto) && $produto->tipo_produto == 'IMPRESSORA') custom-select @endif @error('qntde_estoque') is-invalid @enderror">
                        {{ $errors->has('qntde_estoque') ? $errors->first('qntde_estoque') : '' }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3 col-xxl-2 mt-3 mt-md-0 @if(isset($produto) && ($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO')) mt-md-3 mt-xl-0 @endif">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option selected hidden>Selecione o Status</option>
                    <option value="ATIVO" @php if(isset($produto->status) && $produto->status == 'ATIVO') echo 'selected'@endphp >Ativo</option>
                    <option value="INATIVO" @php if(isset($produto->status) && $produto->status == 'INATIVO') echo 'selected'@endphp >Inativo</option>
                </select>
                {{ $errors->has('status') ? $errors->first('status') : '' }}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-sm-8 col-md-6" id="divDescricao">
                <div class="form-floating">
                    <label for="descricao">Descrição (opcional)</label>
                    <textarea maxlength="150" name="descricao" id="descricao" placeholder="Descrição" class="form-control @error('Descrição') is-invalid @enderror" style="resize:none; height:100px">{{ $produto->descricao ?? old('descricao') }}</textarea>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </div>
            </div>

        </div>

        <div class="mt-3 row justify-content-end">
            <div class="col-auto">
                <a href="{{url()->previous() == route('produtos.create') || (isset($produto) && route('produtos.edit', ['produto' => $produto->id])) ? route('produtos.index') : url()->previous()}}" class="btn btn-secondary me-2">Voltar</a>
                <button class="btn btn-primary handle_aba me-2" id="primeiro-handle" type="button" @php if(!isset($produto->id) || $produto->tipo_produto == 'OUTROS') echo 'style="display: none;"' @endphp>Próximo</button>
            @if (isset($produto->id))
                <button type="submit" id="btnSubmit" class="btn btn-primary">Editar</button>
            @else
                <button type="submit" id="btnSubmit" class="btn btn-primary" style="display:none;">Cadastrar</button>
            @endif
            </div>
        </div>
    </div>
</div>
</form>

@section('css')
    <link href="{{asset('css/custom-select.css')}}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('js/produtos.js')}}"></script>
@stop
