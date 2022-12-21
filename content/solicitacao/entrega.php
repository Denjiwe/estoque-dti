<?php
session_start();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include($path . "verificaLogin.php");

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include ($entityPath . "solicitacao.php"); 
    include ($entityPath . "produto.php");  
    include ($entityPath . "entrega.php");

    include ($modelPath . "solicitacao_model.php");
    include ($modelPath . "produto_model.php");
    include ($modelPath . "entrega_model.php");

    $id = $_REQUEST['solicitacao'];

    if (isset($_POST['id'])) {
        $produtos = $_POST['id'];
        $qntdes = $_POST['qntde'];
        $estado = $_POST['estado'];
        $usuario = $_POST['usuario'];

        $solicitacaoModel = new SolicitacaoModel;

        $produtoModel = new ProdutoModel;

        $entregaModel = new EntregaModel;

        $solicitacaoItens = $solicitacaoModel->selectItemSolicitacao($id);
        
        $entregas = $solicitacaoModel-> comparaEntrega($id);
        

        try {
            $novo_estado = $solicitacaoModel->updateEstado($estado, $id);
            
        } catch (PDOException $e) {
            print "Não foi possível atualizar o estado da solicitação! Erro na atualização do estado da solicitação";
            die();
        }

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
                            $entrega->setUsuarioId($usuario);
                            $entrega->setItensId($idItemSolicitacao);
                            
                            try {
                                
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $entregaModel->update($entrega);
                            } catch(PDOException $e) {
                                print "Não foi possível atualizar o estado da solicitação! Erro na atualização das entregas";
                                die();
                            }
                        } else {
                            $qntdeEstoque = $produtoModel->getEstoque($produto);

                            $novaQntde = $qntdeEstoque - $qntde;
                            
                            $entrega = new Entrega;
                            $entrega->setId($entregas[$key]['id']);
                            $entrega->setQtnde($qntde);
                            $entrega->setUsuarioId($usuario);
                            $entrega->setItensId($idItemSolicitacao);
                            
                            try {
                                
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $entregaModel->update($entrega);
                            } catch(PDOException $e) {
                                print "Não foi possível atualizar o estado da solicitação! Erro na atualização das entregas";
                                die();
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
                            $entrega->setUsuarioId($usuario);
                            $entrega->setItensId($idItemSolicitacao);

                            try {
                                $produtoModel->updateEstoque($novaQntde, $produto);

                                $entregaModel->insert($entrega);
                            } catch (PDOException $e) {
                                print "Não foi possível atualizar quantidade de itens no estoque! Erro na entrega do produto";
                                die();
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
            print "Não foi possível atualizar quantidade de itens no estoque! Erro na atualização do estado da solicitação";
            die();
        }
    }

    header("Location: ./pesquisar.php?entregue=".$id);      