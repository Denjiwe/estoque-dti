@if (isset($diretoria->id))
    <form method="post" action="{{ route('diretorias.update', ['diretoria' => $diretoria]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('diretorias.store') }}">
@endif
@csrf

    <div class="row">
        <div class="col-6">
            <input type="text" name="nome" value="{{ $diretoria->nome ?? old('nome') }}" placeholder="Nome" class="form-control">
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        </div>

        <div class="col-6">
            <select name="status" class="form-select">
                <option selected>-- Selecione o Status --</option>
                <option value="ATIVO" <?php if(isset($diretoria->status) && $diretoria->status == 'ATIVO') echo 'selected'?> >Ativo</option> {{-- {{ $diretoria->status ? old('status') == $diretoria->id ? 'selected' : '' }}   --}}
                <option value="INATIVO" <?php if(isset($diretoria->status) && $diretoria->status == 'INATIVO') echo 'selected'?> >Inativo</option>
            </select>
            {{ $errors->has('status') ? $errors->first('status') : '' }}
        </div>
    </div>

    <select name="orgao_id" class="form-select mt-3">
        <option selected>-- Selecione um Órgão --</option>
        @foreach ($orgaos as $chave => $orgao)
            <option value="{{$orgao->id}}" <?php if(isset($diretoria->orgao_id) && $diretoria->orgao_id == $orgao->id) echo 'selected'?> >{{$orgao->nome}}</option>
        @endforeach
    </select>
    {{ $errors->has('orgao_id') ? $errors->first('orgao_id') : '' }}

    <div class="pt-3 float-end">
        @if (isset($diretoria->id))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
    </div>
</form>