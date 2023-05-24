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
            <div class="col-2">
                <div class="form-floating">
                    <select name="tipo_produto" id="tipo_produto" @php if(isset($produto->tipo_produto)) echo 'disabled' @endphp class="form-select @error('tipo_produto') is-invalid @enderror">
                        <option selected hidden>Selecione o Tipo do Produto</option>
                        <option value="IMPRESSORA" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'IMPRESSORA') echo 'selected'@endphp >Impressora</option>
                        <option value="TONER" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'TONER') echo 'selected'@endphp >Toner</option>
                        <option value="CILINDRO" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'CILINDRO') echo 'selected'@endphp >Cilíndro</option>
                        <option value="OUTROS" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'OUTROS') echo 'selected'@endphp >Outros</option>
                    </select>
                    <label for="tipo_produto">Tipo do Produto</label>
                    {{ $errors->has('tipo_produto') ? $errors->first('tipo_produto') : '' }}
                </div>
            </div>

            <div class="col-3">
                <div class="form-floating">
                    <input type="text" id="modelo_produto" name="modelo_produto" value="{{ $produto->modelo_produto ?? old('modelo_produto') }}" placeholder="Modelo do Produto" class="form-control @error('modelo_produto') is-invalid @enderror">
                    <label for="modelo_produto">Modelo do Produto</label>
                    {{ $errors->has('modelo_produto') ? $errors->first('modelo_produto') : '' }}
                </div>
            </div>

            <div class="col-2">
                <div class="row">
                    <div class="col-12" id="divTipoProduto">
                        <div class="form-floating">
                            <input type="number" id="qntde_estoque" name="qntde_estoque" min="0" value="{{ $produto->qntde_estoque ?? old('qntde_estoque') }}" @php if(isset($produto->status) && $produto->tipo_produto == 'IMPRESSORA') echo 'disabled' @endphp placeholder="Quantidade em estoque" class="form-control @error('qntde_estoque') is-invalid @enderror">
                            <label for="qntde_estoque">Quantidade</label>
                            {{ $errors->has('qntde_estoque') ? $errors->first('qntde_estoque') : '' }}
                        </div>
                    </div>
                    <div class="col-3 mt-4" id="tooltip" style="display: none">
                            <p class="fa fa-lg fa-info-circle align-middle" data-bs-toggle="tooltip" data-bs-placement="right" title="A quantidade é 0 pois na próxima tela serão cadastrados os locais da impressora"></p>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="form-floating">
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option selected hidden>Selecione o Status</option>
                        <option value="ATIVO" @php if(isset($produto->status) && $produto->status == 'ATIVO') echo 'selected'@endphp >Ativo</option>
                        <option value="INATIVO" @php if(isset($produto->status) && $produto->status == 'INATIVO') echo 'selected'@endphp >Inativo</option>
                    </select>
                    {{ $errors->has('status') ? $errors->first('status') : '' }}
                    <label for="status">Status</label>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6" id="divDescricao">
                <div class="form-floating">
                    <textarea maxlength="150" name="descricao" id="descricao" placeholder="Descrição" class="form-control @error('Descrição') is-invalid @enderror" style="resize:none; height:100px">{{ $produto->descricao ?? old('descricao') }}</textarea>
                    <label for="descricao">Descrição (opcional)</label>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </div>
            </div>

        </div>

        <div class="mt-3 row justify-content-end">
            <div class="col-auto">
                <a href="{{url()->previous() == route('produtos.create') || (isset($produto) && route('produtos.edit', ['produto' => $produto->id])) ? route('produtos.index') : url()->previous()}}">
                    <button type="button" class="btn btn-secondary me-2">Voltar</button>
                </a>
                <button class="btn btn-primary handle_aba me-2" id="primeiro-handle" type="button" @php if(!isset($produto->id) || $produto->tipo_produto == 'OUTROS') echo 'style="display: none;"' @endphp>Próximo</button>
            @if (isset($produto->id))
                <button type="submit" id="btnSubmit" class="btn btn-primary">Editar</button>
            @else
                <button type="submit" id="btnSubmit" class="btn btn-primary" style="display:none;">Cadastrar</button>
            @endif
            </div>
        </div>
    </div>

    <div class="tab-pane fade show mt-2" id="impressoras-tab-pane" role="tabpanel" aria-labelledby="impressoras-tab" tabindex="0">
        <div class="row">
            <h1>Insira as impressoras que o suprimento abastece</h1>
            <div class="col-12" id="locais">
                <x-box-input>
                    <x-slot:body>
                        <table class="table text-center table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Impressora</th>
                                    <th>Divisão</th>
                                    <th>Diretoria</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="nome-impressora"></td>
                                    <td>
                                        <select name="diretoria" id="diretoria1" class="form-select">
                                            <option value="tal">Tal</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="divisao" id="divisao1" class="form-select">
                                            <option value="tal">Tal</option>
                                        </select>
                                    </td>
                                    <td style="width: 20%"><button class="btn btn-danger">Remover</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </x-slot:body>

                    <x-slot:footer>
                        <div class="mt-3 row justify-content-end">
                            <div class="col-auto">
                                <button class="btn btn-primary">Adicionar</button>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-box-input>
            </div>

            <div class="mt-3 row justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-secondary handle_aba me-2" type="button">Voltar</button>
                    @if (isset($produto->id))
                        <button type="submit" class="btn btn-primary">Editar</button>
                    @else
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@section('js')
    <script src="{{ asset('js/produtos.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop