<?php
    session_start();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include($path . "verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Diretorias</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/menu.css">
</head>
<body>
    <?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        include_once ($path . "menu.php");
        
        include($path . "verificaDti.php");

        include_once ($entityPath . "diretoria.php");

        include_once ($modelPath . "diretoria_model.php");

        
     ?>
    <main class="container mt-5">
        <div class="row">
            
            <div class="col-10">
                <form action="pesquisar.php" method="get" id="formPesquisa">
                    <div class="input-group">
                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquise o nome da diretoria" required>
                        <button type="submit" class="btn btn-secondary">Pesquisar</button> 
                    </div>
                </form>
            </div>

            <div class="col-2">
            <a href="cadastro.php" class="btn btn-primary">Novo</a>
            </div>

        </div>
        
        <div class="mt-5">
            
            <?php

                if (isset($_GET['delete'])) {
                    try{
                        $model = new DiretoriaModel;
                        $model ->delete($_GET["delete"]);
                        echo "<div class='alert alert-success'>Registro excluído com sucesso</div>";
                    } catch (PDOException $e) {
                        echo "Não foi possível excluir o registro: ". $e->getMessage();
                    }
                }

                if (isset($_GET['pesquisa'])) {
                    $model = new DiretoriaModel;
                    
                    $pesquisa = $_GET['pesquisa'];

                    $diretoria = $model->findByName($pesquisa);

                    print "<h1>Diretorias cadastradas com nome: \"".$pesquisa."\"</h1>";

                    if ($diretoria == null ) {
            ?>            
                        <h3>Nenhuma diretoria encontrada!</h3>
                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    } else {
                        $dataCriacao = new DateTime($diretoria->getDataCriacao());
                        @$dataDesativo = new DateTime($diretoria->getDataDesativo());
            ?>            
                        <table class='container table table-hover table-striped table-bordered text-center'>

                        <tr>
                        <th style='display:none;'>id</th>
                        <th>Nome</th>
                        <th>Ativo</th>
                        <th>Data de Criação</th>
                        <th>Data de Desativação</th>
                        <th>Órgão</th> 
                        <th>Ações</th>
                        </tr>
                    
                        <tr>
                        <td style='display:none;'><?=$diretoria->getId()?></td>
                        <td><?=$diretoria->getNome()?></td>
                        <td><?=($diretoria->getAtivo() ? 'Sim' : 'Não')?></td>
                        <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                        <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Diretoria Ativa")?></td>
                        <td><?=$diretoria->getOrgaoNome()?></td>
                        <td>
                         <a href="cadastro.php?id=<?=$diretoria->getId()?>" class='btn btn-success'>Editar</a>
                         <a href="pesquisar.php?delete=<?=$diretoria->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                              </td>
                        </tr>
                    
                        </table>

                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    }
                    
                } else {
            ?>        
                    <h1>Diretorias cadastradas</h1>

                    <table class=' container table table-hover table-striped table-bordered text-center'>

                    <tr>
                    <th style='display:none;'>#</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Data de Criação</th>
                    <th>Data de Desativação</th>
                    <th>Órgão</th>
                    <th>Ações</th>
                    </tr>
            <?php        

                    $model = new DiretoriaModel;

                    $diretoria = $model->select();
                    
                    foreach ($diretoria as $obj) {
                        $dataCriacao = new DateTime($obj->getDataCriacao());
                        if ($obj->getDataDesativo() == null){
                            $dataDesativo = null;
                        } else {
                            $dataDesativo = new DateTime($obj->getDataDesativo());
                        }
            ?>            
                        <tr>
                        <td style='display:none;'><?=$obj->getId()?></td>
                        <td><?=$obj->getNome()?></td>
                        <td><?=($obj->getAtivo() ? 'Sim' : 'Não')?></td>
                        <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                        <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Diretoria Ativa")?></td>
                        <td><?=$obj->getOrgaoNome()?></td>
                        <td>
                         <a href="cadastro.php?id=<?=$obj->getId()?>" class='btn btn-success'>Editar</a>
                         <a href="pesquisar.php?delete=<?=$obj->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                              </td>
                        </tr>
            <?php            
                    }
                    print "</table>";
                }

            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".excluir").click(function (e) {
            if(confirm("Tem certeza que quer excluir o registro?") == true) {
            } else {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>