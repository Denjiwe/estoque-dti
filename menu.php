<?php
  $home = '../../../home.php';
  $root = '../../../';
?>

<link rel="stylesheet" href="../../../css/menu.css">
<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="<?=$home?>">
      Estoque DTI
    </a>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
<?php
  if ($_SESSION['dti']) {
?>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Cadastros
              </a>
              <ul class="dropdown-menu bg-dark">
                  <li><a class="dropdown-item text-white" href="<?=$root?>content/produto/pesquisar.php">Produto</a></li>
                  <li><a class="dropdown-item text-white" href="<?=$root?>content/orgao/pesquisar.php">Órgãos</a></li>
                  <li><a class="dropdown-item text-white" href="<?=$root?>content/diretoria/pesquisar.php">Diretorias</a></li>
                  <li><a class="dropdown-item text-white" href="<?=$root?>content/divisao/pesquisar.php">Divisões</a></li>
                  <li><a class="dropdown-item text-white" href="<?=$root?>content/usuario/pesquisar.php">Usuário</a></li>
              </ul>
          </li>
          
          <li class="nav-item">
            <a class="nav-link text-white" href="<?=$root?>content/solicitacao/pesquisar.php" role="button">
                Solicitações
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="<?=$root?>content/solicitacao/produtosEntregues.php" role="button">
                Entregas
            </a>
          </li>
<?php            
  }
?>  
          <li class="nav-item">
            <a class="nav-link text-white" href="<?=$root?>content/solicitacao/cadastro.php" role="button">
                Solicitar
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="<?=$root?>content/solicitacao/minhasSolicitacoes.php" role="button">
                Minhas Solicitações
            </a>
          </li>
        </ul>    

        
    </div>  

    <div class="d-flex mt-3 me-3">
      <p class="text-white">Olá! <?=$_SESSION['usuario']?> | <a class="text-white" href="<?=$home?>?sair">Sair</a></p>
    </div>
  </div>
</nav>