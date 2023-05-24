@if(count($produto->suprimentos) == 0)
    <form method="post" id="form" action="{{ route('suprimentos.store', ['id' => $produto->id]) }}">
@else
    <form method="post" id="form" action="{{ route('suprimentos.update', ['id' => $produto->id]) }}">
    @method('PUT')
@endif

<div class="tab-pane fade  active show mt-2" id="suprimentos-tab-pane" role="tabpanel" aria-labelledby="suprimentos-tab" tabindex="0">
    <div class="row">
        <h1>Insira os suprimentos compativeis com a impressora</h1>
        <div class="col-12" id="locais">
            <x-box-input>
                <x-slot:body>
                    <table class="table text-center table-bordered" style="background-color: #f3f3f3;">
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
                            <tr class="linha">
                                <td style="width:30%;"><input type="text" value="{{$produto->modelo_produto}}" disabled class="form-control"></td>
                                <td>
                                    <select name="tipo[]" id="tipo" class="form-select">
                                        <option value="" selected hidden>Selecione o Tipo do Suprimento</option>
                                        <option value="TONER" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'TONER') echo 'selected'@endphp >Toner</option>
                                        <option value="CILINDRO" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'CILINDRO') echo 'selected'@endphp >Cilíndro</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="suprimento[]" id="suprimento" class="form-select">
                                        <option value="">Selecione o suprimento</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="em_uso" id="em_uso" class="form-select">
                                        <option value="sim">Sim</option>
                                        <option value="nao" selected>Não</option>
                                    </select>
                                </td>
                                <td style="width: 10%"><a class="btn btn-danger remover">Remover</a></td>
                            </tr>
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

        <div class="mt-3 row justify-content-end">
            <div class="col-auto">
                <a href="{{url()->previous() == route('produtos.create') ? route('produtos.index') : url()->previous()}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
                @if (isset($produto->id))
                    <button type="submit" class="btn btn-primary">Editar</button>
                @else
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                @endif
            </div>
        </div>
    </div>
</div>

@section('js')
    <script src="{{ asset('js/suprimentos.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop