@if(count($produto->suprimentos) == 0)
    <form method="post" id="form" action="{{ route('suprimentos.store', ['id' => $produto->id]) }}">
@else
    <form method="post" id="form" action="{{ route('suprimentos.update', ['id' => $produto->id]) }}">
    @method('PUT')
@endif
@csrf
<div class="tab-pane fade  active show mt-2" id="suprimentos-tab-pane" role="tabpanel" aria-labelledby="suprimentos-tab" tabindex="0">
    <div class="row">
        <h1>Insira os suprimentos compativeis com a impressora</h1>
        <h4>{{ $errors->has('suprimento') ? $errors->first('suprimento') : '' }}</h4>
        <h4>{{ $errors->has('em_uso') ? $errors->first('em_uso') : '' }}</h4>
        <div class="col-12" id="locais">
            <x-box-input>
                <x-slot:body>
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th>Impressora</th>
                                <th>Tipo do Suprimento</th>
                                <th>Modelo do Suprimento</th>
                                <th>Em uso</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if (count($produto->suprimentos) != 0)
                                @foreach ($produto->suprimentos as $i => $suprimento)
                                <tr class="linha">
                                    <td style="width:15%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                    <td>
                                        <select name="tipo[]" id="tipo" class="form-select">
                                            <option value="" selected hidden>Selecione o Tipo do Suprimento</option>
                                            <option value="TONER" @php if($suprimento->tipo_suprimento == 'TONER') echo 'selected'@endphp >Toner</option>
                                            <option value="CILINDRO" @php if($suprimento->tipo_suprimento == 'CILINDRO') echo 'selected'@endphp >Cilíndro</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="suprimento[]" id="suprimento" class="form-select">
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
                                    <td style="width:15%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                    <td>
                                        <select name="tipo[]" id="tipo" class="form-select">
                                            <option value="" selected hidden>Selecione o Tipo do Suprimento</option>
                                            <option value="TONER">Toner</option>
                                            <option value="CILINDRO">Cilíndro</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="suprimento[]" id="suprimento" class="form-select">
                                            <option value="">Selecione o suprimento</option>
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
            <div class="col-auto">
                <a href="{{url()->previous() == route('suprimentos.create', ['id' => $produto->id]) ? route('locais.store', ['id' => $produto->id]) : url()->previous()}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
                <button type="submit" class="btn btn-primary">Finalizar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script src="{{ asset('js/suprimentos.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop