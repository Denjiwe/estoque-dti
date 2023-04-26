@if (isset($orgao->id))
    <form method="post" action="{{ route('orgaos.update', ['orgao' => $orgao]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('orgaos.store') }}">
@endif
@csrf

    <div class="row">
        <div class="col-6">
            <input type="text" name="nome" value="{{ $orgao->nome ?? old('nome') }}" placeholder="Nome" class="form-control">
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        </div>

        <div class="col-6">
            <select name="status" class="form-control">
                <option selected>-- Selecione o Status --</option>
                <option value="ATIVO" <?php if(isset($orgao->status) && $orgao->status == 'ATIVO') echo 'selected'?> >Ativo</option> {{-- {{ $orgao->status ? old('status') == $orgao->id ? 'selected' : '' }}   --}}
                <option value="INATIVO" <?php if(isset($orgao->status) && $orgao->status == 'INATIVO') echo 'selected'?> >Inativo</option>
            </select>
            {{ $errors->has('status') ? $errors->first('status') : '' }}
        </div>
    </div>

    <div class="pt-3 float-end">
        @if (isset($orgao->id))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
    </div>
</form>