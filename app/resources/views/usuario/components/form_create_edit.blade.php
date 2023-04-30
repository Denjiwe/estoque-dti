@if (isset($usuario->id))
    <form method="post" action="{{ route('usuarios.update', ['usuario' => $usuario]) }}">
    @method('PUT') 
@else
    <form method="post" action="{{ route('usuarios.store') }}">
@endif
@csrf
    <div class="row">
        <div class="col-3">
            <label for="nome" class="fom-label">Nome</label>
            <input type="text" id="nome" name="nome" value="{{ $usuario->nome ?? old('nome') }}" placeholder="Nome" class="form-control @error('nome') is-invalid @enderror">
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        </div>

        <div class="col-3">
            <label for="email" class="fom-label">Email</label>
            <input type="text" id="email" name="email" value="{{ $usuario->email ?? old('email') }}" placeholder="Email" class="form-control @error('email') is-invalid @enderror">
            {{ $errors->has('email') ? $errors->first('email') : '' }}
        </div>

        <div class="col-2">
            <label for="user_interno" class="fom-label">Funcionário Interno</label>
            <select name="user_interno" id="user_interno" class="form-select @error('user_interno') is-invalid @enderror">
                <option selected>-- Usuário Interno? --</option>
                <option value="SIM" @php if(isset($usuario->user_interno) && $usuario->user_interno == 'SIM') echo 'selected'@endphp >Sim</option>
                <option value="NAO" @php if(isset($usuario->user_interno) && $usuario->user_interno == 'NAO') echo 'selected'@endphp >Não</option>
            </select>
            {{ $errors->has('user_interno') ? $errors->first('user_interno') : '' }}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-2">
            <label for="cpf" class="fom-label">CPF</label>
            <input type="text" name="cpf" id="cpf" maxlength="11" value="{{ $usuario->cpf ?? old('cpf') }}" placeholder="CPF" class="form-control @error('cpf') is-invalid @enderror">
            {{ $errors->has('cpf') ? $errors->first('cpf') : '' }}
        </div>

        <div class="col-2">
            <label for="senha" class="fom-label">Senha</label>
            <input type="password" name="senha" id="senha" maxlength="16" value="{{ old('senha') }}" placeholder="Senha" class="form-control @error('senha') is-invalid @enderror">
            {{ $errors->has('senha') ? $errors->first('senha') : '' }}
        </div>
    
        <div class="col-2">
            <label for="status" class="fom-label">Status</label>
            <select name="status" id="status" class="form-select @error('user_interno') is-invalid @enderror">
                <option selected>-- Selecione o Status --</option>
                <option value="ATIVO" @php if(isset($usuario->status) && $usuario->status == 'ATIVO') echo 'selected'@endphp >Ativo</option>
                <option value="INATIVO" @php if(isset($usuario->status) && $usuario->status == 'INATIVO') echo 'selected'@endphp >Inativo</option>
            </select>
            {{ $errors->has('status') ? $errors->first('status') : '' }}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-3">
            <label for="diretoria_id" class="fom-label">Diretoria</label>
            <select name="diretoria_id" id="diretoria_id" class="form-select @error('diretoria_id') is-invalid @enderror">
                <option selected>-- Selecione a Diretoria --</option>
                @foreach ($diretorias as $diretoria)
                    <option value="{{$diretoria->id}}" @php if(isset($usuario->diretoria->id) && $usuario->diretoria->id == $diretoria->id) echo 'selected'@endphp >{{$diretoria->nome}}</option>
                @endforeach
            </select>
            {{ $errors->has('diretoria_id') ? $errors->first('diretoria_id') : '' }}
        </div>

        <div class="col-3">
            <label for="divisao_id" class="fom-label">Divisão</label>
            <select name="divisao_id" id="divisao_id" class="form-select @error('divisao_id') is-invalid @enderror">
                <option value="0" selected>-- Selecione a Divisão --</option>
                @foreach ($divisoes as $divisao)
                    <option value="{{$divisao->id}}" @php if(isset($usuario->divisao->id) && $usuario->divisao->id == $divisao->id) echo 'selected'@endphp >{{$divisao->nome}}</option>
                @endforeach
            </select>
            {{ $errors->has('divisao_id') ? $errors->first('divisao_id') : '' }}
        </div>
    </div>

    <div class="pt-3 float-end">
        <a href="{{url()->previous() == route('usuarios.create') ? route('usuarios.index') : url()->previous()}}"><button type="button" class="btn btn-secondary me-2">Voltar</button></a>
        @if (isset($usuario->id))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
    </div>