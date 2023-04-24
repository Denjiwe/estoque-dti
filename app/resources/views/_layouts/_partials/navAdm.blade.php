<nav class="navbar navbar-expand-lg bg-dark">
<div class="container-fluid">
    <a class="navbar-brand text-white" href="">
        Estoque DTI
    </a>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cadastros
                </a>
                <ul class="dropdown-menu bg-dark">
                    <li><a class="dropdown-item text-white" href="{{ route('produtos.index') }}">Produto</a></li>
                    <li><a class="dropdown-item text-white" href="{{ route('orgaos.index') }}">Órgãos</a></li>
                    <li><a class="dropdown-item text-white" href="{{ route('diretorias.index') }}">Diretorias</a></li>
                    <li><a class="dropdown-item text-white" href="{{ route('divisoes.index') }}">Divisões</a></li>
                    <li><a class="dropdown-item text-white" href="{{ route('usuarios.index') }}">Usuário</a></li>
                </ul>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('solicitar.index') }}" role="button">
                    Solicitações
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('entregas.index') }}" role="button">
                    Entregas
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('solicitar.create') }}" role="button">
                    Solicitar
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('minhas-solicitacoes') }}" role="button">
                    Minhas Solicitações
                </a>
            </li>
        </ul>    
    </div>  

    <div class="d-flex mt-3 me-3">
        {{-- <p class="text-white">Olá! {{auth()->user()->nome}}?> | <a class="text-white" href="<?=$home?>?sair">Sair</a></p> --}}
    </div>
    </div>
</nav>