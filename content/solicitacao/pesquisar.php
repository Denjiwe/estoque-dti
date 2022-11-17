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

            <div class='accordion' id='content'>
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
                    
            ?>
                    
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse<?=$obj->getId()?>' aria-expanded='false'>
                                Pedido <?=$obj->getEstadoSolicitacao()?> <strong> #<?=$obj->getId()?> </strong> de <?=$obj->getUsuarioNome()?> feito em <?=date_format($data, "d/m/Y")?>
                            </button>
                            </h2>
                            <div id='collapse<?=$obj->getId()?>' class='accordion-collapse collapse'>
                            <div class='accordion-body'>
                                <table class='table table-bordered'>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                    </tr>
            <?php
                                foreach ($itens as $item){
            ?>       
                                   <tr>
                                        <td><?=$item['modelo_produto']?></td>
                                        <td><?=$item['qntde_item']?></td>
                                    </tr>
            <?php
                                }
            ?>     
                                </table>

                                <!-- Button trigger modal -->
                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modal<?=$obj->getId()?>'>
                                Entrega
                                </button>

                                <!-- Modal -->
                                <div class='modal fade' id='modal<?=$obj->getId()?>' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h1 class='modal-title fs-5'>Realizar entrega do pedido <strong>#<?=$obj->getId()?></strong></h1>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='entrega.php?solicitacao=<?=$obj->getId()?>' method='post'>
                                            <div class='row'>
                                                <ul class='list-group col-lg-10 col-7'>
            <?php                    
                                foreach ($itens as $item) {
            ?>    
                                                    <li class='list-group-item ms-3'>
                                                        <label class='form-check-label' for='checkbox<?=$item['id']?>'><?=$item['modelo_produto']?></label>
                                                        <input class='form-check-input ms-3' type='checkbox' name='id' value='<?=$item['id']?>' id='checkbox<?=$item['id']?>'>

                                                        <input type='number' class='form-input ms-3 col-2 rounded border border-1 float-end' name='qntde' id='qntde' min='1' max='2' required>
                                                        <label for='qntde' class=' float-end'>Quantidade</label>
                                                    </li>
            <?php                                    
                                }
            ?>                            
                                                </ul>
                                            </div>

                                            

                                            <div class='form-group col-lg-5 col-7 mt-3 mb-3'>
                                                <label for='estado'>Estado da Solicitação</label>
                                                <select class='form-select' name='estado' id='estado' required>
                                                    <option value='' selected hidden></option>                             
                                                    <option value='aberto'>Aberto</option>            
                                                    <option value='aguardando'>Aguardando</option>            
                                                    <option value='atendido'>Atendido</option>            
                                                </select>
                                            </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                        <button type='submit' class='btn btn-primary'>Confirmar</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            </table>
        </div>
    </main>
    
    <!-- fazer request enviando id da solicitação, pegar itens cadastrados na solicitação e fazer a baixa conforme os itens selecionados e suas quantidades -->
   
</body>
</html>