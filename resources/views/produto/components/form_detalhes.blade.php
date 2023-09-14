<div class="mt-2" id="dados-gerais">
    <input type="hidden" name="proximo" id="proximoInput" value="nenhum">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-sm-0">
            <div class="form-floating">
                <input type="text" value="{{ucfirst(strtolower($produto->tipo_produto))}}" class="form-control" disabled>
                <label for="tipo_produto">Tipo do Produto</label>
                {{ $errors->has('tipo_produto') ? $errors->first('tipo_produto') : '' }}
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mt-3 mt-sm-0">
            <div class="form-floating">
                <input type="text" id="modelo_produto" name="modelo_produto" value="{{ $produto->modelo_produto }}" class="form-control" disabled>
                <label for="modelo_produto">Modelo do Produto</label>
                {{ $errors->has('modelo_produto') ? $errors->first('modelo_produto') : '' }}
            </div>
        </div>

        @if($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO')
            <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-md-0">
                <div class="form-floating">
                    <input type="text" id="qntde_solicitada" name="qntde_solicitada" value="{{ $produto->qntde_solicitada }}" placeholder="Quantidade solicitada" class="form-control" readonly>
                    <label for="qntde_solicitada">Quantidade Solicitada</label>
                    {{ $errors->has('qntde_solicitada') ? $errors->first('qntde_solicitada') : '' }}
                </div>
            </div>
        @endif

        <div class="col-12 col-sm-6 col-md-3 col-xl-2 mt-3 mt-md-0">
            <div class="row">
                <div class="col-12" id="divTipoProduto">
                    <div class="form-floating">
                        <input type="text" id="qntde_estoque" name="qntde_estoque" min="0" value="{{ $produto->qntde_estoque }}" class="form-control" disabled/>
                        <label for="qntde_estoque">Quantidade</label>
                    </div>
                </div>
                <div class="col-3 mt-4" id="tooltip" style="display: none">
                        <p class="fa fa-lg fa-info-circle align-middle" data-bs-toggle="tooltip" data-bs-placement="right" title="A quantidade é 0 pois na próxima tela serão cadastrados os locais da impressora"></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 col-xxl-2 mt-3 mt-md-0 @if(isset($produto) && ($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO')) mt-md-3 mt-xl-0 @endif">
            <div class="form-floating">
                <select name="status" id="status" class="form-control" disabled>
                    <option selected hidden>Selecione o Status</option>
                    <option value="ATIVO" @php if(isset($produto->status) && $produto->status == 'ATIVO') echo 'selected'@endphp >Ativo</option>
                    <option value="INATIVO" @php if(isset($produto->status) && $produto->status == 'INATIVO') echo 'selected'@endphp >Inativo</option>
                </select>
                <label for="status">Status</label>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-sm-8 col-md-6" id="divDescricao">
            <div class="form-floating">
                <textarea maxlength="150" name="descricao" id="descricao" placeholder="Descrição" class="form-control @error('Descrição') is-invalid @enderror" style="resize:none; height:100px" disabled>{{ $produto->descricao ?? old('descricao') }}</textarea>
                <label for="descricao">Descrição (opcional)</label>
                {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
            </div>
        </div>
    </div>

    @if($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO')
    @if(count($suprimentos) != 0)
        <div class="mt-3" id="impressoras">
            <h3>Impressoras que o suprimento atende</h3>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-5 col-xl-3" id="impressoras">
                    <x-box-input>
                        <x-slot:body>
                            <div class="table-responsive d-flex justify-content-center">
                                <table class="table text-center table-bordered w-auto" id="table">
                                    <thead>
                                        <tr>
                                            <th>Impressoras</th>
                                            <th>Em Uso</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach ($suprimentos as $i => $suprimento)
                                            <tr class="linha">
                                                <td>
                                                    <select name="impressora[]" id="impressora" class="form-control w-auto" disabled>
                                                        @foreach ($impressoras as $impressora)
                                                            <option value="{{$impressora->id}}" @php if($suprimento->produto_id == $impressora->id) echo 'selected'@endphp>{{$impressora->modelo_produto}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="em_uso[]" id="em_uso" class="form-control w-auto" disabled>
                                                        <option value="SIM" @php if($suprimento->em_uso == 'SIM') echo 'selected'@endphp>Sim</option>
                                                        <option value="NAO" @php if($suprimento->em_uso == 'NAO') echo 'selected'@endphp>Não</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-slot:body>
                    </x-box-input>
                </div>
            </div>
        </div>
    @endif
    @elseif($produto->tipo_produto == 'IMPRESSORA')
    <div class="row d-flex justify-content-center">
        @if (count($produto->locais) != 0)
            <div class="col-12 col-md-6 col-xxl-4 mt-3">
                <h3>Locais em que a impressora está locada</h3>
                <x-box-input>
                    <x-slot:body>
                        <div class="table-responsive">
                            <table class="table text-center table-bordered w-auto" id="table">
                                <thead>
                                    <tr>
                                        <th>Divisão</th>
                                        <th>Diretoria</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                        @foreach ($produto->locais as $i => $local)
                                            <tr class="linha">
                                                <td>
                                                    <select name="diretoria[]" id="diretoria" class="form-control w-auto" disabled>
                                                        @foreach($diretorias as $diretoria)
                                                            <option value="{{$diretoria->id}}" @if($local->diretoria_id == $diretoria->id) selected @endif>{{$diretoria->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="divisao[]" id="divisao" class="form-control w-auto" disabled>
                                                        @foreach($divisoes as $divisao)
                                                            <option value="{{$divisao->id}}" @if($local->divisao_id == $divisao->id)selected @endif>{{$divisao->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </x-slot:body>
                </x-box-input>
            </div>
        @endif
        @if (count($produto->suprimentos) != 0)
            <div class="col-12 col-md-6 col-xxl-4 mt-3" id="suprimentos">
                <h3>Suprimentos da Impressora</h3>
                <x-box-input>
                    <x-slot:body>
                        <div class="table-responsive">
                            <table class="table text-center table-bordered w-auto">
                                <thead>
                                    <tr>
                                        <th>Tipo do Suprimento</th>
                                        <th>Modelo do Suprimento</th>
                                        <th>Em uso</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                        @foreach ($produto->suprimentos as $i => $suprimento)
                                        <tr class="linha">
                                            <td>
                                                <select name="tipo[]" id="tipo" class="form-control w-auto" disabled>
                                                    <option value="" selected hidden>Selecione o Tipo do Suprimento</option>
                                                    <option value="TONER" @php if($suprimento->tipo_suprimento == 'TONER') echo 'selected'@endphp >Toner</option>
                                                    <option value="CILINDRO" @php if($suprimento->tipo_suprimento == 'CILINDRO') echo 'selected'@endphp >Cilíndro</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="suprimento[]" id="suprimento" class="form-control w-auto" disabled>
                                                    <option value="">Selecione o suprimento</option>
                                                    @if ($suprimento->tipo_suprimento == 'TONER')
                                                        @foreach ($toners as $toner)
                                                            <option value="{{$toner->id}}" @php if($suprimento->suprimento_id == $toner->id) echo 'selected'@endphp>{{$toner->modelo_produto}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($cilindros as $cilindro)
                                                            <option value="{{$cilindro->id}}" @php if($suprimento->suprimento_id == $cilindro->id) echo 'selected'@endphp>{{$cilindro->modelo_produto}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="em_uso[]" id="em_uso" class="form-control w-auto" disabled>
                                                    <option value="SIM" @php if($suprimento->em_uso == 'SIM') echo 'selected'@endphp>Sim</option>
                                                    <option value="NAO" @php if($suprimento->em_uso == 'NAO') echo 'selected'@endphp>Não</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </x-slot:body>
                </x-box-input>
            </div>
        @endif
    </div>
    @endif
    <div class="mt-3 ms-2 row justify-content-end">
        <div class="col-auto ">
            <a href="{{route('produtos.index')}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
            <a href="{{route('produtos.edit', ['produto' => $produto->id])}}"><button class="btn btn-primary" id="btnSubmit" type="submit">Editar</button></a>
        </div>
    </div>
</div>