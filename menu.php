<?php
  $home = '../../../home.php';
?>

<link rel="stylesheet" href="../../../css/menu.css">
<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="<?=$home?>">
      Estoque DTI
    </a>
    <div class="d-flex">
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Cadastros
                  </a>
                  <ul class="dropdown-menu bg-dark">
                      <li><a class="dropdown-item text-white" href="../../../content/produto/pesquisar.php">Produto</a></li>
                      <li><a class="dropdown-item text-white" href="../../../content/orgao/pesquisar.php">Órgãos</a></li>
                      <li><a class="dropdown-item text-white" href="../../../content/diretoria/pesquisar.php">Diretorias</a></li>
                      <li><a class="dropdown-item text-white" href="../../../content/divisao/pesquisar.php">Divisões</a></li>
                      <li><a class="dropdown-item text-white" href="../../../content/usuario/pesquisar.php">Usuário</a></li>
                  </ul>
              </li>
              
              <li class="nav-item">
                <a class="nav-link text-white" href="../../../content/solicitacao/pesquisar.php" role="button">
                    Solicitar
                </a>
              </li>

              <li class="nav-item">
                <p class="nav-link text-white">Olá! <?=$_SESSION['usuario']?> | <a class="text-white" href="<?=$home?>?sair">Sair</a></p>
              </li>
              
          </ul>    
      </div> 
    </div>  
  </div>
</nav>