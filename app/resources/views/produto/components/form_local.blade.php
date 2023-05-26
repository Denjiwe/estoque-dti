@if(count($produto->locais) == 0)
    <form method="post" id="form" action="{{ route('locais.store', ['id' => $produto->id]) }}">
@else
    <form method="post" id="form" action="{{ route('locais.update', ['id' => $produto->id]) }}">
    @method('PUT')
@endif

@csrf
<div class="tab-content mt-3" id="TabContent">
    <div class="tab-pane fade show active mt-2" id="locais-tab-pane" role="tabpanel" aria-labelledby="locais-tab" tabindex="0">
        <h1>Defina os locais em que a impressora está alocada</h1>
        <h4>{{ $errors->has('diretoria_id') ? $errors->first('diretoria_id') : '' }}</h4>
        <h4>{{ $errors->has('divisao_id') ? $errors->first('divisao_id') : '' }}</h4>
        <div class="row">
            <div class="col-12" id="locais">
                <x-box-input>
                    <x-slot:body>
                        <table class="table text-center table-bordered" id="table" style="background-color: #f3f3f3;">
                            <thead>
                                <tr>
                                    <th>Impressora</th>
                                    <th>Divisão</th>
                                    <th>Diretoria</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @if (count($produto->locais) != 0)
                                    @foreach ($produto->locais as $i => $local)
                                        <tr class="linha">
                                            <td style="width:30%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                            <td>
                                                <select name="diretoria[]" id="diretoria" class="form-select">
                                                    <option value="" selected hidden>Selecione a Diretoria</option>
                                                    @foreach($diretorias as $diretoria)
                                                        <option value="{{$diretoria->id}}" @php if($local->diretoria_id == $diretoria->id) echo 'selected' @endphp>{{$diretoria->nome}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="divisao[]" id="divisao" class="form-select">
                                                    <option value="" selected hidden>Selecione a Divisão</option>
                                                    @foreach($divisoes as $divisao)
                                                        <option value="{{$divisao->id}}" @php if($local->divisao_id == $divisao->id) echo 'selected' @endphp>{{$divisao->nome}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="width: 10%"><a class="btn btn-danger remover">Remover</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="linha">
                                        <td style="width:30%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                        <td>
                                            <select name="diretoria[]" id="diretoria" class="form-select">
                                                <option value="" selected hidden>Selecione a Diretoria</option>
                                                @foreach($diretorias as $diretoria)
                                                    <option value="{{$diretoria->id}}">{{$diretoria->nome}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="divisao[]" id="divisao" class="form-select">
                                                <option value="" selected hidden>Selecione a Divisão</option>
                                                @foreach($divisoes as $divisao)
                                                    <option value="{{$divisao->id}}">{{$divisao->nome}}</option>
                                                @endforeach
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
                    <button class="btn btn-primary" type="submit">Próximo</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@section('js')
    <script src="{{ asset('js/locais.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop