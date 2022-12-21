<?php 

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include_once ($entityPath . "solicitacao.php");

    include_once ($modelPath . "solicitacao_model.php");

    include_once ($entityPath . "produto.php");

    include_once ($modelPath . "produto_model.php");

    class SolicitacaoController 
    {

        /* ========================================================= Cadastro ========================================================= */



        function adicionaProduto() {
            $model = new SolicitacaoModel;

            $nomeImpressora = $_POST['nomeImpressora'];
            $idImpressora = $_POST['selectImpressora'];
            $qntde = $_POST['qntde'];    

            switch ($_POST['selectTC']) {
                case "toner":
                    $model = new ProdutoModel;
                    $toner = new Produto;
                    $toner = $model->getToner($idImpressora);
                    $cilindro = null;
                    if (!isset($_SESSION['qntde'])){
                        $_SESSION['qntde'] = [];
                    }
                    array_push($_SESSION['qntde'], $qntde);
                    break;
                case "cilindro":
                    $model = new ProdutoModel;
                    $cilindro = new Produto;
                    @$cilindro = $model?->getCilindro($idImpressora);
                    if ($cilindro == null) {
                ?>
                <div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>
                <?php        
                    $toner = null;
                    unset($nomeImpressora);
                    unset($idImpressora);
                    unset($qntde);
                    break;
                    }

                    if (!isset($_SESSION['qntde'])){
                        $_SESSION['qntde'] = [];
                    }
                    array_push($_SESSION['qntde'], $qntde);
                    $toner = null;
                    break;
                case "conjunto":
                    $model = new ProdutoModel;
                    $toner = new Produto;
                    $toner= $model->getToner($idImpressora);
                    $cilindro = new Produto;
                    @$cilindro = $model?->getCilindro($idImpressora);
                    for ($i = 0; $i <= 1; $i++){
                        if (!isset($_SESSION['qntde'])){
                            $_SESSION['qntde'] = [];
                        }
                        array_push($_SESSION['qntde'], $qntde);
                    }
                    if ($cilindro == null) {
                ?>
                <div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>
                <?php        
                    $toner = null;
                    unset($nomeImpressora);
                    unset($idImpressora);
                    unset($qntde);
                    break;
                    }
                    break;
            }

            if (isset($idImpressora)) {
                if (!isset($_SESSION['produtos'])) {
                    $_SESSION['produtos'] = [];
                }

                if (!isset($_SESSION['nomeImpressora'])){
                    $_SESSION['nomeImpressora'] = [];
                }
                array_push($_SESSION['nomeImpressora'], $nomeImpressora);
                
                if (!isset($_SESSION['idImpressora'])){
                    $_SESSION['idImpressora'] = [];
                }
                array_push($_SESSION['idImpressora'], $idImpressora);
                
                if (!isset($_SESSION['qntdeExibicao'])){
                    $_SESSION['qntdeExibicao'] = [];
                }
                array_push($_SESSION['qntdeExibicao'], $qntde);
                
                if ($toner != null) {
                    if (!isset($_SESSION['toner'])){
                        $_SESSION['toner'] = [];
                    }
                    array_push($_SESSION['toner'],$toner?->getModelo());
                    array_push($_SESSION['produtos'], $toner?->getId());
                }
                if ($cilindro != null) {
                    if (!isset($_SESSION['cilindro'])){
                        $_SESSION['cilindro'] = [];
                    }
                    array_push($_SESSION['cilindro'],$cilindro?->getModelo());
                    array_push($_SESSION['produtos'], $cilindro?->getId());
                }
            }
        }

        function excluiProduto() {
            $model = new ProdutoModel;
            $toner = new Produto;
            $cilindro = new Produto;

            $indexImpressora = $_GET['excluir'];

            array_splice($_SESSION['nomeImpressora'], $indexImpressora, 1);

            array_splice($_SESSION['qntdeExibicao'], $indexImpressora, 1);

            $idImpressora = $_SESSION['idImpressora'][$indexImpressora];

            $toner = $model?->getToner($idImpressora);

            @$cilindro = $model?->getCilindro($idImpressora);

            $chaveToner = array_search($toner?->getModelo(), $_SESSION['toner']);     

            $chaveIdToner = array_search($toner?->getId(), $_SESSION['produtos']);

            $chaveCilindro = array_search($cilindro?->getModelo(), $_SESSION['cilindro']);

            $chaveIdCilindro = array_search($cilindro?->getId(), $_SESSION['produtos']);

            if ($chaveToner !==false || $chaveCilindro !==false){
                array_splice($_SESSION['toner'], $chaveToner, 1);
                array_splice($_SESSION['cilindro'], $chaveToner, 1);
            }

            if ($chaveIdToner !==false){
                array_splice($_SESSION['produtos'], $chaveIdToner, 1);
                array_splice($_SESSION['qntde'], $chaveIdToner, 1);
            }
            
            if ($chaveIdCilindro !==false){
                array_splice($_SESSION['produtos'], $chaveIdCilindro, 1);
                array_splice($_SESSION['qntde'], $chaveIdCilindro, 1);
            }

            array_splice($_SESSION['idImpressora'], $indexImpressora, 1);
            
            header("Location: ./cadastro.php");
        }

        function exibeImpressora() {
            $model = new ProdutoModel;

            $select_impressora = $model->selectImpressora();
            
            foreach ($select_impressora as $impressora) {
                print "<option value=\"".$impressora['id']."\">".$impressora['modelo_produto']."</option>";
            };
        }

        function exibeListaProduto() {
            ?>
            <table class="table table-hover table-striped table-bordered mt-5 row" id="content">
                <tr>
                    <th class="col-4 text-center">Modelo da Impressora</th>
                    <th class="col-1 text-center">Quantidade</th>
                    <th class="col-5 text-center" colspan="2">Produto(s)</th>
                    <th class="col-2 text-center">Ações</th>
                </tr>
                <?php
                        for ($i=0; $i<count($_SESSION['nomeImpressora']);$i++) {
                            ?>
                <tr>
                    <td hidden><?=$_SESSION['idImpressora'][$i]?></td>
                    <td class="text-center"><?=$_SESSION['nomeImpressora'][$i]?></td>
                    <td class="text-center"><?=$_SESSION['qntdeExibicao'][$i]?></td>
                    <?php
                                    if (isset($_SESSION['toner'][$i]) && !isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['toner'][$i]."</td>";
                                        print '<td style="padding: 0px; margin: 0px;"></td>';
                                        $_SESSION['cilindro'][$i] = null;

                                    } elseif (!isset($_SESSION['toner'][$i]) && isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['cilindro'][$i]."</td>";
                                        print '<td style="padding: 0px; margin: 0px;"></td>';
                                        $_SESSION['toner'][$i] = null;
                                        

                                    } elseif (isset($_SESSION['toner'][$i]) && isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['toner'][$i]."</td>";
                                        print "<td class='text-center'>".$_SESSION['cilindro'][$i]."</td>";

                                    }             
                            ?>
                    <td class='text-center'><a href="cadastro.php?excluir=<?=$i?>" type="button"
                            class="btn btn-danger">Excluir</a></td>
                </tr>
                <?php        
                        }
                            ?>
            </table>
            <?php
        }

        function modalSolicitacao($solicitacaoId, $itensEmFalta, $qntdeEmFalta, $itensOk, $qntdeOk) {
            ?>
            <div class="modal fade show" id="solicitacaoModal"  style="display: block;" aria-modal="true" tabindex="-1" aria-labelledby="solitacaoModal" data-bs-keyboard="false" role="dialog" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resumo da solicitação #<?=$solicitacaoId?></h5>
                    </div>
                    <div class="modal-body">
                        <div class='row'>
                            <ul class='list-group col-10'>
                        <?php
                            if ($itensEmFalta != null) {
                                ?>
                                <h5 class="ms-3 text-danger">Produtos Em Falta!</h5>
                                <?php
                                foreach ($itensEmFalta as $i => $itemEmFalta){
                                    $model = new ProdutoModel;
                                    $produto = new Produto;
                                    $produto = $model->findById($itemEmFalta);
                                ?>
                                <li class='list-group-item ms-3'>
                                    <label class='form-check-label'><?=$produto->getModelo()?></label>
                                    
                                    <input type="tel"
                                        class="form-input ms-3 col-2 rounded border border-1 float-end"
                                        maxlength="1" value="<?=$qntdeEmFalta[$i]?>" disabled>
                                    <label for='qntde' class=' float-end'>Quantidade</label>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                            <?php
                            }

                            if ($itensOk != null) {
                        ?>
                                <h5 class="ms-3 text-success">Produtos Em Estoque</h5>
                                <?php
                                foreach ($itensOk as $i => $itemOk){
                                    $model = new ProdutoModel;
                                    $produtoOk = new Produto;
                                    $produtoOk = $model->findById($itemOk);
                                ?>
                                <li class='list-group-item ms-3'>
                                    <label class='form-check-label'><?=$produtoOk->getModelo()?></label>
                                    
                                    <input type="tel"
                                        class="form-input ms-3 col-2 rounded border border-1 float-end"
                                        maxlength="1" value="<?=$qntdeOk[$i]?>" disabled>
                                    <label for='qntde' class=' float-end'>Quantidade</label>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <a href="pesquisar.php" class="btn btn-secondary">OK</a>
                    </div>
                    </div>
                </div>
            </div>
            <?
        }

        function cadastraSolicitacao() {
            $model = new SolicitacaoModel;

            $solicitacao = new Solicitacao;

            $observacao = $_POST['observacao'];
            $solicitacao?->setDescricao($observacao);

            $qntdeItem = $_SESSION['qntde'];
            $solicitacao->setQntdeItem($qntdeItem);

            $usuarioId = $_SESSION['usuarioId'];
            $solicitacao->setUsuarioId($usuarioId);

            $local = $model->findLocalUsuario($usuarioId);

            if ($local['divisao_id'] == null) {
                $solicitacao->setUsuarioDiretoria($local['diretoria_id']);
            } else {
                $solicitacao->setUsuarioDivisao($local['divisao_id']);
            }

            $produtos = $_SESSION['produtos'];

            $solicitacao->setItemSolicitacao($produtos); 

            if (!isset($itensOk)) {
                $itensOk = [];
            }
            if (!isset($qntdeOk)) {
                $qntdeOk = [];
            }

            if (!isset($itensEmFalta)) {
                $itensEmFalta = [];
            }
            if (!isset($qntdeEmFalta)) {
                $qntdeEmFalta = [];
            }

            foreach ($produtos as $key => $produto) {
                $qntdeSolicitada = $model->verificaQntdeSolicitado($produto);
                
                $qntdeEstoque = $model->getEstoque($produto);

                $disponivel = $qntdeEstoque - $qntdeSolicitada;

                if ($disponivel <= 0) {
                    array_push($itensEmFalta, $produto);
                    array_push($qntdeEmFalta, $qntdeItem[$key]);
                } else {
                    array_push($itensOk, $produto);
                    array_push($qntdeOk, $qntdeItem[$key]);
                }
            }

            if (isset($itensEmFalta) && $itensEmFalta != null) {
                $estado = 'Aguardando';
            } else {
                $estado = $_POST['estado'];
            }
            
            $solicitacao->setEstadoSolicitacao($estado);
            

            try {
                $model->insert($solicitacao);
                $this->modalSolicitacao($model->LastId()['id'], $itensEmFalta, $qntdeEmFalta, $itensOk, $qntdeOk);

                unset($_SESSION['qntde']);
                unset($_SESSION['produtos']);
                unset($_SESSION['idImpressora']);
                unset($_SESSION['toner']);
                unset($_SESSION['cilindro']);
                unset($_SESSION['qntdeExibicao']);
                unset($_SESSION['nomeImpressora']);
            } catch (PDOException $e){
                echo "<div class=' container alert alert-danger mt-5'>Não foi possível cirar a solicitação! Erro de banco de dados.</div>";
            }
        }

        
        /* ========================================================= Pesquisa ========================================================= */



        function exibeSolicitacao(bool $atendidos) {
            $model = new SolicitacaoModel;

            $solicitacao = new Solicitacao;

            if (!isset($_GET['pesquisa']) && $_SERVER["REQUEST_URI"] != '/content/solicitacao/minhasSolicitacoes.php') {
                $solicitacao = $model->select($atendidos);
            } elseif($_SERVER["REQUEST_URI"] == '/content/solicitacao/minhasSolicitacoes.php') {
                $solicitacao = $model->selectUsuario();
        
                if (count($solicitacao) == 0) {
                    ?>
                    <div class='container'>
                        <h3 class='mt-5'>Você não possui nenhuma solicitação criada!</h3>
                        <a class='btn btn-primary mt-2' href='cadastro.php'>Cadastrar solicitação</a>
                        <a class='btn btn-light mt-2' href='../../../home.php'>Voltar para Home</a>
                    </div>

                    <body>

                    </html>
                    <?php
                    exit();
                }
            } else {
                $solicitacao = $model->findById($_GET['pesquisa']);
                if (count($solicitacao) == 0) {
                    ?>
                    <div class='container'>
                        <h3 class='mt-5'>Nenhuma solicitação foi encontrada!</h3>
                        <a class='btn btn-light mt-2' href='pesquisar.php'>Voltar</a>
                    </div>

                    <body>

                    </html>
                    <?php
                    exit();
                }
            }

                    
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
                            [<?php
                                switch ($obj->getEstadoSolicitacao()) {
                                    case 'Aguardando':
                                        print "<span class='text-warning'>".$obj->getEstadoSolicitacao()."</span>";
                                        break;
                                    case 'Atendido':
                                        print "<span class='text-primary'>".$obj->getEstadoSolicitacao()."</span>";
                                        break;
                                    case 'Aberto':
                                        print "<span class='text-success'>".$obj->getEstadoSolicitacao()."</span>";
                                        break;
                                    case 'Liberado':
                                        print "<span class='text-info'>".$obj->getEstadoSolicitacao()."</span>";
                                        break;
                                }
                            ?>] <strong>&nbsp #<?=$obj->getId()?> &nbsp</strong> de
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
                                                            <input  type='checkbox'
                                                                name='id[]' 
                                                                id='checkbox<?=$item['is_id']?>'
                                                                <?php
                                                                    if ($itensEntregues != null) {
                                                                        foreach ($itensEntregues as $x => $entregue){
                                                                            if ((isset($entregue) && $entregue['solicitacaoId'] == $obj->getId() && $entregue['produtoId'] == $item['id'])){
                                                                                print "checked disabled ";
                                                                                print "value='".$item['id']."' ";
                                                                                print "class='form-check-input ms-3 entregue'";
                                                                            }
                                                                        } 
                                                                    } else {
                                                                        print "class='form-check-input ms-3' ";
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
                                                                                print "value='".$entregue['qntdeEntregue']."' ";  
                                                                                print 'required'; 
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
                <?php
                                        if ($obj->getEstadoSolicitacao() == "Aguardando" || $obj->getEstadoSolicitacao() == "Atendido" || $obj->getEstadoSolicitacao() == "Liberado"){
                                            echo "<button type='button' class='btn btn-primary btn-editar' onclick='edita()'>Editar</button>";
                                        }
                ?>
                                            <button type='button' class='btn btn-secondary'
                                                data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-primary' disabled>Confirmar</button>
                                        </div>
                                        </form>
                                    </div> <!-- modal-content -->
                                </div><!-- modal-dialog -->
                            </div><!-- modal -->
                <?php
                    }
                ?>
                        </div><!-- accordion-body -->
                    </div><!-- collapse -->
                </div><!-- accordion-item -->
                <?php
                    }
        }

        /* ========================================================= Entrega ========================================================= */

        function modalErroEntrega($exception) {
            ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
            </script>
            
            <div class="modal fade show" id="solicitacaoModal"  style="display: block;" aria-modal="true" tabindex="-1" aria-labelledby="solitacaoModal" data-bs-keyboard="false" role="dialog" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Erro na Entrega!</h5>
                        </div>
                        <div class="modal-body">
                            <?php
                                if (str_contains($exception, 'chk_produto_positivo')){
                                    print "Não foi possível realizar a entrega pois existe um ou vários produtos sem estoque!";
                                } else {
                                    print "Não foi possível reaizar a entrega!";
                                }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <a href="pesquisar.php" class="btn btn-secondary">OK</a>
                        </div>
                    </div>
                </div>
            </div>

            <script language="javascript">
                let modal = document.querySelector(".modal");
                let body = document.querySelector("body");

                if (modal.classList.contains("show")) {
                    body.classList.add("modal-open");
                    body.style.overflow = "hidden";
                    let div = document.createElement("div");
                    div.classList.add("modal-backdrop");
                    div.classList.add("fade");
                    div.classList.add("show");

                    body.appendChild(div);
                }
            </script>
        <?php
        }

    }