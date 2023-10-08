@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
    <form action="{{ $login_url }}" id="form" method="post">
        @csrf
        <div>
            @if(isset($_GET['sucesso']))
            <span class="text-success" role="alert">
                <strong>{{ $_GET['sucesso'] }}</strong>
            </span>
            @endif
            
            @if($errors->has('error'))
            <span class="text-red" role="alert">
                <strong>{{$errors->first('error')}}</strong>
            </span>
            @endif
        </div>

        {{-- CPF field --}}
        <label for="cpf" class="form-label">CPF</label>
        <div class="input-group mb-3">
            <input type="text" id="cpf" name="cpf" maxlength="14" class="form-control @error('cpf') is-invalid @enderror"
            value="{{ old('cpf') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-address-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('cpf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <label for="password" class="form-label">Senha</label>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

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
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>

    </form>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if($password_reset_url)
        <p class="my-0">
            <a href="#">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif
@stop

@section('js')
    <script>
        const input = document.getElementById("cpf");
        input.addEventListener("keypress", somenteNumeros);

        function somenteNumeros(e) {
            var charCode = (e.which) ? e.which : e.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            e.preventDefault();
        }

        input.addEventListener("keyup", formatarCPF);

        function formatarCPF(e){
            var v=e.target.value.replace(/\D/g,"");
            v=v.replace(/(\d{3})(\d)/,"$1.$2");
            v=v.replace(/(\d{3})(\d)/,"$1.$2");
            v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
            e.target.value = v;
        } 
    </script>
@stop