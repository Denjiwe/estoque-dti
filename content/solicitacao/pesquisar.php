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
                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquise a solicitação">
                        <button type="submit" class="btn btn-secondary">Pesquisar</button> 
                    </div>
                </form>
            </div>

            <div class="col-2">
            <a href="cadastro.php" class="btn btn-primary">Novo</a>
            </div>

        </div>
        
        <div class="mt-5">

            <h1 class="mb-4">Solicitações Cadastradas</h1>
            
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

                $model = new SolicitacaoModel;

                $solicitacao = new Solicitacao;

                $solicitacao = $model->select();

                
                foreach ($solicitacao as $obj) {

                    $itens = $model->selectItemSolicitacao($obj->getId());
                    $data =  new DateTime($obj->getDataSolicitacao());
                    

                    print 
                    "<div class='accordion'>
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse".$obj->getId()."' aria-expanded='false'>
                                Pedido ".$obj->getEstadoSolicitacao()." &nbsp<strong> #". $obj->getId() ."</strong>&nbsp de ".$obj->getUsuarioNome()." feito em ".date_format($data, "d/m/Y")."
                            </button>
                            </h2>
                            <div id='collapse".$obj->getId()."' class='accordion-collapse collapse'>
                            <div class='accordion-body'>
                                <table class='table table-bordered'>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                    </tr>";
                                foreach ($itens as $item){
                                    print 
                                   "<tr>
                                        <td>".$item['modelo_produto']."</td>
                                        <td>".$item['qntde_item']."</td>
                                    </tr>";
                                }
                    print               
                                "</table>
                            </div>
                        </div>
                    </div>";
                }

            ?>
            </table>
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