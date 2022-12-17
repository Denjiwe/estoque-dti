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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
                        $itensEntregues = $model->comparaEntrega($obj->getId());
                        $data =  new DateTime($obj->getDataSolicitacao());
                        if ($itensEntregues != null) {
                            $dataEntregue = new DateTime($itensEntregues[0]['dataEntregue']);
                        }
                    
            ?>

                <div class='accordion-item'>
                    <h2 class='accordion-header'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse'
                            data-bs-target='#collapse<?=$obj->getId()?>' aria-expanded='false'>
                            [<?=$obj->getEstadoSolicitacao()?>] <strong>&nbsp #<?=$obj->getId()?> &nbsp</strong> de
                            <?=$obj->getUsuarioNome()?>, <?=$obj->getUsuarioDivisao() != 0 ? $model->getDivisaoNome($obj->getUsuarioDivisao())['nome'] : $model->getDiretoriaNome($obj->getUsuarioDiretoria())['nome']?> feito em <?=date_format($data, "d/m/Y")?>
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
                            <input disabled id='observacao<?=$obj->getId()?>' class="form-control bg-white"
                                value="<?=$obj->getDescricao()?>">
                            <?php
                }

                if ($_SESSION['dti']) {
            ?>
                            <!-- Button trigger modal -->
                            <button type='button' class='btn btn-primary mt-4' data-bs-toggle='modal'
                                data-bs-target='#modal<?=$obj->getId()?>'>
                                Entrega
                            </button>

                            <!-- Modal -->
                            <div class='modal fade' id='modal<?=$obj->getId()?>' data-bs-backdrop='static'
                                data-bs-keyboard='false' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h1 class='modal-title fs-5'>Realizar entrega do pedido
                                                <strong>#<?=$obj->getId()?></strong>
                                            </h1>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form action='entrega.php?solicitacao=<?=$obj->getId()?>' method='post'>
                                                <div class='row'>
                                                    <ul class='list-group col-10'>
                                                        <?php                    
                                foreach ($itens as $i => $item) {
            ?>
                                                        <li class='list-group-item ms-3'>
                                                            <label class='form-check-label'
                                                                for='checkbox<?=$item['is_id']?>'><?=$item['modelo_produto']?></label>
                                                            <input class='form-check-input ms-3' type='checkbox'
                                                                name='id[]' 
                                                                id='checkbox<?=$item['is_id']?>'
                                                                <?php
                                                                    if ($itensEntregues != null) {
                                                                        foreach ($itensEntregues as $x => $entregue){
                                                                            if ((isset($entregue) && $entregue['solicitacaoId'] == $obj->getId() && $entregue['produtoId'] == $item['id'])){
                                                                                print "checked disabled";
                                                                                print " value=''";
                                                                            } else {
                                                                                print "value='".$item['id']."'";
                                                                            }
                                                                        } 
                                                                    } else {
                                                                        print "value='".$item['id']."'";
                                                                    }
                                                                ?>
                                                            >
                                                            
                                                            <input type="tel"
                                                                class="form-input ms-3 col-2 rounded border border-1 float-end"
                                                                name="qntde[]" id="qntde<?=$item['is_id']?>" min="1"
                                                                max="<?=$item['qntde_item']?>" maxlength="1" disabled
                                                                <?php
                                                                    if ($itensEntregues != null) {
                                                                        foreach ($itensEntregues as $x => $entregue){
                                                                            if (isset($entregue) && $entregue['solicitacaoId'] == $obj->getId() && $entregue['produtoId'] == $item['id']){
                                                                                print "value='".$entregue['qntdeEntregue']."'";   
                                                                            }
                                                                        }
                                                                    }
                                                                ?>>
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
                                                        <?php
                                                            if ($itensEntregues != null) {
                                                                switch($obj->getEstadoSolicitacao()) {
                                                                    case 'Aberto':
                                                                        ?>
                                                                            <option value='Aberto' selected>Aberto</option>
                                                                            <option value='Aguardando'>Aguardando</option>
                                                                            <option value='Atendido'>Atendido</option>
                                                                        <?php
                                                                        break;
                                                                    case 'Aguardando':
                                                                        ?>
                                                                            <option value='Aguardando' selected>Aguardando</option>
                                                                            <option value='Aberto'>Aberto</option>
                                                                            <option value='Atendido'>Atendido</option>
                                                                        <?php
                                                                        break;
                                                                    case 'Atendido':
                                                                        ?>
                                                                            <option value='Aberto'>Aberto</option>
                                                                            <option value='Aguardando'>Aguardando</option>
                                                                            <option value='Atendido' selected>Atendido</option>
                                                                        <?php
                                                                        break;
                                                                }
                                                            } else {
                                                        ?>
                                                        <option value='' selected hidden></option>
                                                        <option value='Aberto'>Aberto</option>
                                                        <option value='Aguardando'>Aguardando</option>
                                                        <option value='Atendido'>Atendido</option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <input type="hidden" name="usuario" value="<?=$obj->getUsuarioId() ?>" />
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary'
                                                data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-primary' disabled>Confirmar</button>
                                        </div>
                                        </form>
                                    </div> <!-- modal-content -->
                                </div><!-- modal-dialog -->
                            </div><!-- modal -->
                        </div><!-- accordion-body -->
                    </div><!-- collapse -->
                </div><!-- accordion-item -->
                    <?php
                }
            }
?>
                </div>
            </div>
        </div>
        <?php
?>
    </div>
</main>

</table>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>
<script language='javascript'>
let check = document.querySelectorAll(".form-check-input");
let qntde = document.querySelectorAll(".form-input");
let modal = document.querySelectorAll(".modal-body ul");
let confirmar = document.querySelectorAll(".modal-footer button[type=submit]");

function verifica() {
    for (let x = 0; x < modal.length; x++) {
        confirmar[x].setAttribute('disabled', '');
        if (modal[x].querySelectorAll("input[type=checkbox]:checked").length > 0) {
            confirmar[x].removeAttribute('disabled');
        } else {
            confirmar[x].setAttribute('disabled', '');
        }
    }
}

for (let i = 0; i < check.length; i++) {
    check[i].addEventListener("change", () => {
        qntde[i].toggleAttribute('required');
        qntde[i].toggleAttribute('disabled');
        verifica();
    });
}
</script>
</body>

</html>