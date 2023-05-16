@if (isset($produto->id))
    <form method="post" action="{{ route('produtos.update', ['produto' => $produto]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('produtos.store') }}">
@endif
@csrf
<div class="tab-content mt-3" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="dados-gerais-tab-pane" role="tabpanel" aria-labelledby="dados-gerais-tab" tabindex="0">
        <div class="row">
            <div class="col-2">
                <div class="form-floating">
                    <select name="tipo_produto" id="tipo_produto" class="form-select @error('tipo_produto') is-invalid @enderror">
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
                            <input type="number" id="qntde_estoque" name="qntde_estoque" value="{{ $produto->qntde_estoque ?? old('qntde_estoque') }}" placeholder="Quantidade em estoque" class="form-control @error('qntde_estoque') is-invalid @enderror">
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
                    <textarea maxlength="150" name="descricao" id="descricao" placeholder="Descrição" value="{{ $produto->Descrição ?? old('Descrição') }}" class="form-control @error('Descrição') is-invalid @enderror" style="resize:none; height:100px"></textarea>
                    <label for="descricao">Descrição</label>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </div>
            </div>

            <div class="col-2">
                <div class="form-floating" id="divToner" style="display: none">
                    <select name="toner" id="toner" class="form-select @error('toner') is-invalid @enderror">
                        <option selected hidden>Selecione o toner</option>
                        <option value="TAL" @php if(isset($produto->toner) && $produto->toner == 'TAL') echo 'selected'@endphp >TAL</option>
                        <option value="Toner tal" @php if(isset($produto->toner) && $produto->toner == 'Toner tal') echo 'selected'@endphp >Toner tal</option>
                    </select>
                    {{ $errors->has('toner') ? $errors->first('toner') : '' }}
                    <label for="toner">Toner</label>
                </div>
            </div>

            <div class="col-2">
                <div class="form-floating" id="divCilindro" style="display: none">
                    <select name="cilindro" id="cilindro" class="form-select @error('cilindro') is-invalid @enderror">
                        <option selected hidden>Selecione o cilindro</option>
                        <option value="Nenhum" @php if(isset($produto->cilindro) && $produto->cilindro == 'Nenhum') echo 'selected'@endphp >Nenhum</option>
                        <option value="Cilíndro tal" @php if(isset($produto->cilindro) && $produto->cilindro == 'Cilíndro tal') echo 'selected'@endphp >Cilíndro tal</option>
                    </select>
                    {{ $errors->has('cilindro') ? $errors->first('cilindro') : '' }}
                    <label for="cilindro">Cilíndro</label>
                </div>
            </div>
        </div>

        <div class="mt-3 row justify-content-end">
            <div class="col-auto">
            <a href="{{url()->previous() == route('produtos.create') ? route('produtos.index') : url()->previous()}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
            @if (isset($produto->id))
                <button type="submit" class="btn btn-primary">Editar</button>
            @else
                {{-- <button type="submit" class="btn btn-primary">Cadastrar</button> --}}
                <button class="btn btn-primary prox_aba" type="button">Próximo</button>
            @endif
            </div>
        </div>
    </div>
</div>

@section('js')
    <script src="{{ asset('js/produtos.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop