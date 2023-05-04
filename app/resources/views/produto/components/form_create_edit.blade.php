@if (isset($produto->id))
    <form method="post" action="{{ route('produtos.update', ['produto' => $produto]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('produtos.store') }}">
@endif
@csrf
    <div class="row">
        <div class="col-2">
            <label for="tipo_produto" class="fom-label">Tipo do Produto</label>
            <select name="tipo_produto" id="tipo_produto" class="form-select @error('tipo_produto') is-invalid @enderror" v-model="tipoProduto">
                <option selected>-- Selecione o Tipo do Produto --</option>
                <option value="IMPRESSORA" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'IMPRESSORA') echo 'selected'@endphp >Impressora</option>
                <option value="TONER" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'TONER') echo 'selected'@endphp >Toner</option>
                <option value="CILINDRO" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'CILINDRO') echo 'selected'@endphp >Cilíndro</option>
                <option value="OUTROS" @php if(isset($produto->tipo_produto) && $produto->tipo_produto == 'OUTROS') echo 'selected'@endphp >Outros</option>
            </select>
            {{ $errors->has('tipo_produto') ? $errors->first('tipo_produto') : '' }}
        </div>

        <div class="col-3">
            <label for="modelo_produto" class="fom-label">Modelo do Produto</label>
            <input type="text" id="modelo_produto" name="modelo_produto" value="{{ $produto->modelo_produto ?? old('modelo_produto') }}" placeholder="Modelo do Produto" class="form-control @error('modelo_produto') is-invalid @enderror">
            {{ $errors->has('modelo_produto') ? $errors->first('modelo_produto') : '' }}
        </div>

        <div class="col-1">
            <label for="qntde_estoque" class="fom-label">Quantidade</label>
            <input type="number" id="qntde_estoque" name="qntde_estoque" value="{{ $produto->qntde_estoque ?? old('qntde_estoque') }}" class="form-control @error('qntde_estoque') is-invalid @enderror">
            {{ $errors->has('qntde_estoque') ? $errors->first('qntde_estoque') : '' }}
        </div>

        <div class="col-2">
            <label for="status" class="fom-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option selected>-- Selecione o Status --</option>
                <option value="ATIVO" @php if(isset($produto->status) && $produto->status == 'ATIVO') echo 'selected'@endphp >Ativo</option>
                <option value="INATIVO" @php if(isset($produto->status) && $produto->status == 'INATIVO') echo 'selected'@endphp >Inativo</option>
            </select>
            {{ $errors->has('status') ? $errors->first('status') : '' }}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <label for="descricao" class="fom-label">Descrição</label>
            <textarea maxlength="150" name="descricao" id="descricao" rows="3" value="{{ $produto->Descrição ?? old('Descrição') }}" placeholder="Descrição" class="form-control @error('Descrição') is-invalid @enderror" style="resize:none"></textarea>
            {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
        </div>
    </div>

    <div class="pt-3 float-end">
        <a href="{{url()->previous() == route('produtos.create') ? route('produtos.index') : url()->previous()}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
        @if (isset($produto->id))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
    </div>

@section('js')
    <script src="{{ asset('js/produtos.js')}}"></script>
@stop