<?php
session_start();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include_once ($path . "verificaLogin.php");

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

    include_once ($controllerPath . 'entrega_controller.php');


    include_once ($entityPath . "solicitacao.php"); 
    include_once ($entityPath . "produto.php");  
    include_once ($entityPath . "entrega.php");

    include_once ($modelPath . "solicitacao_model.php");
    include_once ($modelPath . "produto_model.php");
    include_once ($modelPath . "entrega_model.php");

    $entregaController = new EntregaController;

    $id = $_REQUEST['solicitacao'];

    if (isset($_POST['id'])) {
        $produtos = $_POST['id'];
        $qntdes = $_POST['qntde'];
        $estado = $_POST['estado'];
        $usuarioId = $_POST['usuario'];
        $usuarioEntrega = $_SESSION['usuarioId'];

        $solicitacaoModel = new SolicitacaoModel;

        $produtoModel = new ProdutoModel;

        $entregaModel = new EntregaModel;

        $solicitacaoItens = $solicitacaoModel->selectItemSolicitacao($id);
        
        $entregas = $solicitacaoModel-> comparaEntrega($id);

        foreach ($produtos as $i => $produto){
            // $produto = id do produto
            
            $qntde = (int)$qntdes[$i];

            if ($entregas != null) {
                foreach ($solicitacaoItens as $key => $item) {
                    
                    if ($item['is_id'] == $entregas[$key]['is_id']) {
                        
                        $idItemSolicitacao = $item['is_id'];
                        
                        if ($qntde <= $entregas[$key]['qntdeEntregue']){
                            $qntdeEstoque = $produtoModel->getEstoque($produto);

                            $novaQntde = $qntdeEstoque + $qntde;
                            
                            $entrega = new Entrega;
                            $entrega->setId($entregas[$key]['id']);
                            $entrega->setQtnde($qntde);
                            $entrega->setUsuarioId($usuarioId);
                            $entrega->setItensId($idItemSolicitacao);
                            $entrega->setUsuarioEntrega($usuarioEntrega);
                            
                            try {
                                
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $solicitacaoModel->updateEstado($estado, $id);

                                $entregaModel->update($entrega);
                            } catch(PDOException $e) {
                                $entregaController->modalErroEntrega($e);
                            }
                        } else {
                            $qntdeEstoque = $produtoModel->getEstoque($produto);

                            $novaQntde = $qntdeEstoque - $qntde;
                            
                            $entrega = new Entrega;
                            $entrega->setId($entregas[$key]['id']);
                            $entrega->setQtnde($qntde);
                            $entrega->setUsuarioId($usuarioId);
                            $entrega->setItensId($idItemSolicitacao);
                            $entrega->setUsuarioEntrega($usuarioEntrega);
                            
                            try {
                                
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $solicitacaoModel->updateEstado($estado, $id);

                                $entregaModel->update($entrega);
                            } catch(PDOException $e) {
                                $entregaController->modalErroEntrega($e);
                            }
                        }
                    } 
                }
            } else {
                foreach ($solicitacaoItens as $key => $item) {
                    if ($produto == $item['id']){
                        $idItemSolicitacao = $item['is_id'];

                        if ($qntde <= $item['qntde_item']){
                            $qntdeEstoque = $produtoModel->getEstoque($produto);

                            $novaQntde = $qntdeEstoque - $qntde;

                            $entrega = new Entrega;
                            $entrega->setQtnde($qntde);
                            $entrega->setUsuarioId($usuarioId);
                            $entrega->setItensId($idItemSolicitacao);
                            $entrega->setUsuarioEntrega($usuarioEntrega);

                            try {
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $solicitacaoModel->updateEstado($estado, $id);

                                $entregaModel->insert($entrega);
                            } catch (PDOException $e) {
                                $entregaController->modalErroEntrega($e);
                            }
                        }
                    }
                }
            }
        } 
    } else {
        $estado = $_POST['estado'];

        $solicitacaoModel = new SolicitacaoModel;

        try {
            $solicitacaoModel->updateEstado($estado, $id);
        } catch (PDOException $e){
            $entregaController->modalErroEntrega($e);
        }
    }

    @header("Location: ./pesquisar.php?entregue=".$id);      