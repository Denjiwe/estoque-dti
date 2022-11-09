<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Pesquisar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../../css/menu.css">
</head>
<body>
    <?php include("../../menu.php"); ?>
    <main class="container mt-5">
        <div class="row">
            
            <div class="col-10">
                <form action="pesquisar.php" method="get" id="formPesquisa">
                    <div class="input-group">
                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquise o nome do órgão">
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

                include_once ("../../entity/solicitacao.php");

                include_once ("../../model/solicitacao_model.php");

                if(@$_REQUEST['delete']) {
                    try{
                        $model = new SolicitacaoModel;
                        $model ->delete($_REQUEST["delete"]);
                        echo "<div class='alert alert-success'>Registro excluído com sucesso</div>";
                    } catch (PDOException $e) {
                        echo "<div class='alert alert-danger'>Não foi possível excluir o registro: ". $e->getMessage()."</div>";
                    }
                }

                if (isset($_GET['pesquisa'])) {
                    $model = new SolicitacaoModel;
                    
                    $pesquisa = $_GET['pesquisa'];

                    $solicitacao = $model->findByName($pesquisa);

                    print "<h1>Solicitações cadastrados com nome: \"".$pesquisa."\"</h1>";

                    if ($solicitacao == null ) {
                        echo "<h3>Nenhum órgão encontrado!</h3>";
                        print "<a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>";

                    } else {
                        print "<table class=' container table table-hover table-striped table-bordered'>";

                        print 
                        "<tr>
                            <th style='display:none;'>id</th>
                            <th>Estado da Solicitação</th>
                            <th>Descrição</th>
                            <th>Data de Solicitação</th>
                            <thCódigo do Usuário</th>
                            <th>Ações</th>
                        </tr>";
                    
                        print "<tr>";
                        print "<td style='display:none;'>".$solicitacao->getId()."</td>";
                        print "<td>".$solicitacao->getEstadoSolicitacao()."</td>";
                        print "<td>".$solicitacao-getDescricao()."</td>";
                        print "<td>".$solicitacao->getDataSolicitacao()."</td>";
                        print "<td>".$solicitacao->getUsarioId()."</td>";
                        print "<td>
                         <a href=\"cadastro.php?id=".$solicitacao->getId()."\"class='btn btn-success'>Editar</a>
                         <a href=\"pesquisar.php?delete=".$solicitacao->getId()."\" class='btn btn-danger excluir'>Excluir</a>
                              </td>";
                        print "</tr>";
                    
                        print "</table>";

                        print "<a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>";
                    }
                    
                } else {
                    print "<h1>Solicitações Cadastradas</h1>";

                    print "<table class='mt-5 container table table-hover table-striped table-bordered'>";

                    
                    print 
                    "<tr>
                        <th style='display:none;'>#</th>
                        <th>Estado da Solicitação</th>
                        <th>Descrição</th>
                        <th>Data de Solicitação</th>
                        <th>Código do Usuário</th>
                        <th>Ações</th>
                    </tr>";

                    $model = new SolicitacaoModel;

                    $solicitacao = $model->select();
                    
                    foreach ($solicitacao as $obj) {
                        print "<tr>";
                        print "<td style='display:none;'>".$obj->getId()."</td>";
                        print "<td>".$obj->getEstadoSolicitacao()."</td>";
                        print "<td>".$obj->getDescricao()."</td>";
                        print "<td>".$obj->getDataSolicitacao()."</td>";
                        print "<td>".$obj->getUsuarioId()."</td>";

                        print "<td>
                         <a href=\"pesquisar.php?delete=".$obj->getId()."\" class='btn btn-danger excluir'>Excluir</a>
                              </td>";
                        print "</tr>";
                    }
                    print "</table>";
                }

            ?>
        </div>
    </main>

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