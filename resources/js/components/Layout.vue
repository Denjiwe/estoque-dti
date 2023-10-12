<template>
    <header>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand text-light fs-3" :href="url+'minhas-solicitacoes'">Estoque DTI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Rotas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link text-light fs-3" :href="url+'/minhas-solicitacoes'">Minhas Solicitações</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link text-light fs-3" :href="url+'/solicitar'">Solicitar</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light fs-4" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Olá, {{ nome }} 
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" :href="url+'/logout'">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container" id="content">
        <slot></slot>
    </div>
</template>

<script>

export default {
    props: {
        nome: String
    },
    setup() {
        return {
            url: window.location.origin
        };
    }
};
</script>

<style>
header {
    width: 100%;
    background-color: #343c49;
    margin-bottom: 20px;
}

.offcanvas {
    background-color: #343c49;
}

.card-box {
    padding: 1.5rem;
    border-radius: .25rem;
    background-color: #fff;
    margin-bottom: 1.5rem;
    box-shadow: 0px 0px 28px 0px rgba(0,0,0,0.1);
}
</style>