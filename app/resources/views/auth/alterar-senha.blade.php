@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Altere sua senha')

@section('auth_body')
    <form action="{{ route('alterar-senha.update', ['usuarioId' => $usuario->id]) }}" method="post">
        @csrf
        @method('PATCH')

        {{-- Alerts --}}
        
        @if($errors->has('error'))
        <span class="text-red" role="alert">
            <strong>{{$errors->first('error')}}</strong>
        </span>
        @endif

        {{-- CPF field --}}
        <div class="input-group mb-3">
            
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    value="{{ old('password') }}" placeholder="Senha" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('cpf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Confirme sua Senha">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Login field --}}
        <div class="row justify-content-end">
            <div class="col-auto">
                <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    Alterar Senha
                </button>
            </div>
        </div>

    </form>
@stop