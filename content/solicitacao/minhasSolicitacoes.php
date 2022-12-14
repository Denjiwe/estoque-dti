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
    <title>CRUD 2.0 - Solicitação</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/menu.css">
</head>
<body>
    <?php 

        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        include($path . "menu.php");
        
        include_once ($entityPath . "solicitacao.php");

        include_once ($modelPath . "solicitacao_model.php");

        $model = new SolicitacaoModel;

        $solicitacao = new Solicitacao;

        $solicitacao = $model->selectUsuario();
        
        if (count($solicitacao) == 0) {
    ?>  
            <div class='container'>
                <h3 class='mt-5'>Você não possui nenhuma solicitação criada!</h3>
                <a class='btn btn-primary mt-2' href='cadastro.php'>Cadastrar solicitação</a>
                <a class='btn btn-light mt-2' href='<?=$home?>'>Voltar para Home</a>
            </div>
        <body>
    </html>
    <?php
        exit();
        }
    ?>
<main class='container mt-5'>
    <div class='accordion' id='content'>
    <?php
        foreach ($solicitacao as $obj) {

            $itens = $model->selectItemSolicitacao($obj->getId());
            $data =  new DateTime($obj->getDataSolicitacao());
    
    ?>
    
        <div class='accordion-item'>
            <h2 class='accordion-header'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse<?=$obj->getId()?>' aria-expanded='false'>
                Pedido <?=$obj->getEstadoSolicitacao()?> <strong>&nbsp #<?=$obj->getId()?> &nbsp</strong> de <?=$obj->getUsuarioNome()?> feito em <?=date_format($data, "d/m/Y")?>
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
<?php
            if ($obj->getDescricao() != null) {
?>
                <label for='observacao<?=$obj->getId()?>'>Observação</label>
                <input disabled id='observacao<?=$obj->getId()?>' class="form-control bg-white" value="<?=$obj->getDescricao()?>">
<?php
            }

            if ($_SESSION['dti']) {
?>                    
                <!-- Button trigger modal -->
                <button type='button' class='btn btn-primary mt-4' data-bs-toggle='modal' data-bs-target='#modal<?=$obj->getId()?>'>
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
                                <ul class='list-group col-10'>
<?php                    
                foreach ($itens as $item) {
?>    
                                    <li class='list-group-item ms-3'>
                                        <label class='form-check-label' for='checkbox<?=$item['id']?>'><?=$item['modelo_produto']?></label>
                                        <input class='form-check-input ms-3' type='checkbox' name='id[]' value='<?=$item['id']?>' id='checkbox<?=$item['id']?>'>

                                        <input type='number' class='form-input ms-3 col-2 rounded border border-1 float-end' name='qntde[]' id='qntde' min='1' max='<?=$item['qntde_item']?>' required>
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
                                    <option value='Aberto'>Aberto</option>            
                                    <option value='Aguardando'>Aguardando</option>            
                                    <option value='Atendido'>Atendido</option>            
                                </select>
                            </div>
                    </div>
                    <input type="hidden" name="usuario" value="<?=$obj->getUsuarioId() ?>"/>
                    <div class='modal-footer'> 
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-primary'>Confirmar</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>
<?php
            }
?>
            </div>
        </div>
    </div>
</main>
<?php
}
?>
</table>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>