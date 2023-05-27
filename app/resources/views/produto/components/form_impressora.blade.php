@if(count($suprimentos) == 0)
    <form method="post" id="form" action="{{ route('impressoras.store', ['id' => $produto->id]) }}">
@else
    <form method="post" id="form" action="{{ route('impressoras.update', ['id' => $produto->id]) }}">
    @method('PUT')
@endif

@csrf
<div class="tab-content mt-3" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="impressoras-tab-pane" role="tabpanel" aria-labelledby="impressoras-tab" tabindex="0">
        <h1>Defina as impressoras que o suprimento atende</h1>
        <h4>{{ $errors->has('diretoria_id') ? $errors->first('diretoria_id') : '' }}</h4>
        <h4>{{ $errors->has('divisao_id') ? $errors->first('divisao_id') : '' }}</h4>
        <div class="row">
            <div class="col-12" id="locais">
                <x-box-input>
                    <x-slot:body>
                        <table class="table text-center table-bordered" id="table" style="background-color: #f3f3f3;">
                            <thead>
                                <tr>
                                    <th>Tipo do Suprimento</th>
                                    <th>Modelo do Suprimento</th>
                                    <th>Impressoras</th>
                                    <th>Em Uso</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @if (count($suprimentos) != 0)
                                    @foreach ($suprimentos as $i => $suprimento)
                                    <tr class="linha">
                                        <td style="width:15%;"><input type="text" name="tipo[]" value="{{ucfirst(strtolower($produto->tipo_produto))}}" disabled class="form-control"></td>
                                        <td style="width:15%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                        <td>
                                            <select name="impressora[]" id="impressora" class="form-select">
                                                <option value="">Selecione a impressora</option>
                                                @foreach ($impressoras as $impressora)
                                                    <option value="{{$impressora->id}}" @php if($suprimento->produto_id == $impressora->id) echo 'selected'@endphp>{{$impressora->modelo_produto}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="em_uso[]" id="em_uso" class="form-select">
                                                <option value="SIM" @php if($suprimento->em_uso == 'SIM') echo 'selected'@endphp>Sim</option>
                                                <option value="NAO" @php if($suprimento->em_uso == 'NAO') echo 'selected'@endphp>Não</option>
                                            </select>
                                        </td>
                                        <td style="width: 10%"><a class="btn btn-danger remover">Remover</a></td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr class="linha">
                                    <td style="width:15%;"><input type="text" name="tipo[]" value="{{ucfirst(strtolower($produto->tipo_produto))}}" disabled class="form-control"></td>
                                    <td style="width:15%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                    <td>
                                        <select name="impressora[]" id="impressora" class="form-select">
                                            <option value="">Selecione a impressora</option>
                                            @foreach ($impressoras as $impressora)
                                                <option value="{{$impressora->id}}">{{$impressora->modelo_produto}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="em_uso[]" id="em_uso" class="form-select">
                                            <option value="SIM">Sim</option>
                                            <option value="NAO" selected>Não</option>
                                        </select>
                                    </td>
                                    <td style="width: 10%"><a class="btn btn-danger remover">Remover</a></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </x-slot:body>

                    <x-slot:footer>
                        <div class="mt-3 row justify-content-end">
                            <div class="col-auto">
                                <a id="adicionar" class="btn btn-primary">Adicionar</a>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-box-input>
            </div>

            <div class="mt-3 ms-2 row justify-content-end">
                <div class="col-auto ">
                    <a href="{{route('produtos.edit', ['produto' => $produto->id])}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
                    <button class="btn btn-primary" id="btnSubmit" type="submit">Finalizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@section('js')
    <script src="{{ asset('js/impressoras.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop