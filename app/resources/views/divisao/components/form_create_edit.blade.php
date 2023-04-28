@if (isset($divisao->id))
    <form method="post" action="{{ route('divisao.update', ['divisao' => $divisao]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('divisao.store') }}">
@endif
@csrf

    <div class="row">
        <div class="col-6">
            <input type="text" name="nome" value="{{ $divisao->nome ?? old('nome') }}" placeholder="Nome" class="form-control">
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        </div>

        <div class="col-6">
            <select name="status" class="form-select">
                <option selected>-- Selecione o Status --</option>
                <option value="ATIVO" <?php if(isset($divisao->status) && $divisao->status == 'ATIVO') echo 'selected'?> >Ativo</option> {{-- {{ $divisao->status ? old('status') == $divisao->id ? 'selected' : '' }}   --}}
                <option value="INATIVO" <?php if(isset($divisao->status) && $divisao->status == 'INATIVO') echo 'selected'?> >Inativo</option>
            </select>
            {{ $errors->has('status') ? $errors->first('status') : '' }}
        </div>
    </div>

    <select name="diretoria_id" class="form-select mt-3">
        <option selected>-- Selecione uma Diretoria --</option>
        @foreach ($diretorias as $chave => $diretoria)
            <option value="{{$diretoria->id}}" <?php if(isset($divisao->diretoria_id) && $divisao->diretoria_id == $diretoria->id) echo 'selected'?> >{{$diretoria->nome}}</option>
        @endforeach
    </select>
    {{ $errors->has('diretoria_id') ? $errors->first('diretoria_id') : '' }}

    <div class="pt-3 float-end">
        @if (isset($divisao->id))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
    </div>
</form>