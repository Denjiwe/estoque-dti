<?php
    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include_once ($entityPath . 'entrega.php');

    include_once ($modelPath . 'entrega_model.php');

    class EntregaController
    {

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

        /* ========================================================= Pesquisa ========================================================= */



        function exibeEntregas() {
            $model = new EntregaModel;

            $entregas = $model->select();

            if ($entregas != null) {
            ?>
                <h1>Produtos Entregues</h1>

                <table class='container table table-hover table-striped table-bordered text-center'>

                <tr>
                    <td>Nº Solicitação</td>
                    <td>Produto</td>
                    <td>Quantidade Entrege</td>
                    <td>Detalhes da Entrega</td>
                </tr>
            <?php
                foreach ($entregas as $i => $entrega) {
                    
                    $usuarioEntrega = $model->getUsuarioNome($entrega->getUsuarioEntrega())['nome'];
                    $usuarioSolicitacao = $model->getUsuarioNome($entrega->getUsuarioId())['nome'];
                    $dataEntrega = new DateTime($entrega->getDataEntrega());
                    $produtoNome = $model->getProdutoNome($entrega->getItensId())['modelo_produto'];
                    ?>
                        <tr>
                            <td><?=$entrega->getSolicitacaoId()?></td>
                            <td><?=$produtoNome?></td>
                            <td><?=$entrega->getQntde()?></td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type='button' class='btn btn-primary' data-bs-toggle='modal'
                                data-bs-target='#modal<?=$entrega->getSolicitacaoId()?>'>
                                    Detalhes
                                </button>

                                <!-- Modal -->
                                <div class='modal fade' id='modal<?=$entrega->getSolicitacaoId()?>' data-bs-backdrop='static'
                                data-bs-keyboard='false' style="display: none;" tabindex='-1' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h4 class='modal-title fs-5'>Detalhes da Entrega, Solicitação 
                                                    <strong>#<?=$entrega->getSolicitacaoId()?></strong>
                                                </h4>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                            </div>

                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <ul class='list-group col-10'>
                                                        <li class='list-group-item ms-3'>
                                                            <label class="float-start"><?=$produtoNome?></label>

                                                            <input type="tel"
                                                            class="form-input ms-3 col-2 rounded border border-1 float-end"
                                                            value="<?=$entrega->getQntde()?>" disabled>
                                                            <label for="qntde" class=" float-end">Quantidade</label>
                                                        </li>
                                                    </ul>
                                                    
                                                </div>

                                                <div class="mt-3 ms-3">
                                                    <span class="float-start">Solicitação feita por: <?=$usuarioSolicitacao?></span> <br>
                                                    <span class="float-start">Entregue por: <?=$usuarioEntrega?></span> <br>
                                                    <span class="float-start">Entregue no dia: <?=date_format($dataEntrega, 'd/m/Y')?></span>
                                                </div>
                                                
                                            </div>

                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary'
                                                data-bs-dismiss='modal'>OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    <?php
                }
            ?>
                </table>
            <?php
            }
        }
    }
?>