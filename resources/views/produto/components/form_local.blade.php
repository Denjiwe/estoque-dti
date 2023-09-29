@if(count($produto->locais) == 0)
    <form method="post" id="form" action="{{ route('locais.store', ['id' => $produto->id]) }}">
@else
    <form method="post" id="form" action="{{ route('locais.update', ['id' => $produto->id]) }}">
    @method('PUT')
@endif

@csrf
    <div class="tab-pane fade show active mt-2" id="locais-tab-pane" role="tabpanel" aria-labelledby="locais-tab" tabindex="0">
        <h1>Defina os locais em que a impressora está alocada</h1>
        <h4>{{ $errors->has('diretoria_id') ? $errors->first('diretoria_id') : '' }}</h4>
        <h4>{{ $errors->has('divisao_id') ? $errors->first('divisao_id') : '' }}</h4>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-xl-10 col-xxl-7" id="locais">
                <x-box-input>
                    <x-slot:body>
                        <div class="table-responsive">
                            <table class="table text-center table-bordered w-auto" id="table">
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
                                                <td>
                                                    <input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control w-auto">
                                                </td>
                                                <td>
                                                    <select name="diretoria[]" id="diretoria" disabled class="form-control w-auto diretoria" required>
                                                        <option value="" selected hidden>Selecione a Diretoria</option>
                                                        @foreach($diretorias as $diretoria)
                                                            <option value="{{$diretoria->id}}" @if($local->diretoria_id == $diretoria->id) selected @endif>{{$diretoria->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="divisao[]" id="divisao" disabled class="form-control w-auto divisao">
                                                        <option value="" selected>Nenhuma</option>
                                                        @foreach($divisoes as $divisao)
                                                            <option value="{{$divisao->id}}" @if($local->divisao_id == $divisao->id)selected @endif>{{$divisao->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><a class="btn btn-danger remover">Remover</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="linha">
                                            <td>
                                                <input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control w-auto">
                                            </td>
                                            <td>
                                                <select name="diretoria[]" id="diretoria" class="form-control w-auto" required>
                                                    <option value="" selected hidden>Selecione a Diretoria</option>
                                                    @foreach($diretorias as $diretoria)
                                                        <option value="{{$diretoria->id}}">{{$diretoria->nome}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="divisao[]" id="divisao" class="form-control w-auto">
                                                    <option value="" selected>Nenhuma</option>
                                                    @foreach($divisoes as $divisao)
                                                        <option value="{{$divisao->id}}">{{$divisao->nome}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><a class="btn btn-danger remover">Remover</a></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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
                    <button class="btn btn-primary handle_aba" type="submit">Próximo</button>
                </div>
            </div>
        </div>
    </div>
</form>

@section('js')
    <script src="{{ asset('js/locais.js')}}" type="module"></script>
@stop
