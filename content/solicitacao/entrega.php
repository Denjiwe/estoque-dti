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

    $produtos = $_POST['id'];
    $qntdes = $_POST['qntde'];
    $estado = $_POST['estado'];
    $usuario = $_POST['usuario'];

    $solicitacao_model = new SolicitacaoModel;

    $produto_model = new ProdutoModel;

    $entrega_model = new EntregaModel;

    $solicitacao_itens = $solicitacao_model->selectItemSolicitacao($id);
    
    
    

    try {
        $novo_estado = $solicitacao_model->updateEstado($estado, $id);
    } catch (PDOException $e) {
        print "Não foi possível atualizar o estado da solicitação: ". $e->getMessage();
        die();
    }

    foreach ($produtos as $i => $produto){
        // $produto = id do produto

        $qntde = (int)$qntdes[$i];

        foreach ($solicitacao_itens as $key => $item) {
            if ($produto == $item['id']){
                $idItemSolicitacao = $item['is_id'];

                if ($qntde <= $item['qntde_item']){
                    $qntdeEstoque = $produto_model->getEstoque($produto);

                    $novaQntde = $qntdeEstoque - $qntde;

                    $entrega = new Entrega;
                    $entrega->setQtnde($qntde);
                    $entrega->setUsuarioId($usuario);
                    $entrega->setItensId($idItemSolicitacao);

                    try {
                        $produto_model->updateEstoque($novaQntde, $produto);

                        $entrega_model->insert($entrega);
                    } catch (PDOException $e) {
                        print "Não foi possível atualizar quantidade de itens no estoque: ". $e->getMessage();
                        die();
                    }
                }
            }
        }






        // //$id_item se refere ao id do produto em si
        // $id_item = $item['id'];
        // print " ";
        // print($id_item);
        
        // if (isset($qntdes[$i]) && isset($produtos[$i])){
        //     $qntde = $qntdes[$i];
        //     print " ";
        //     print($qntde);
        //     //$idItemSolicitacao se refere ao id da tabela itens_solicitacao em si, que é necessario para ser realizada 
        //     //a inserção na tabela de entregas
        //     $idItemSolicitacao = $item['is_id'];

        //     if (@$produto[$i] == $id_item){

        //         if ($qntde <= $item['qntde_item']){

        //             $qntde_estoque = $produto_model->getEstoque($id_item);

        //             $nova_qntde = $qntde_estoque->getQntde() - $qntde;

        //             $entrega = new Entrega;
        //             $entrega->setQtnde($qntde);
        //             $entrega->setUsuarioId($usuario);
        //             $entrega->setItensId($idItemSolicitacao);

        //             try {
        //                 $produto_model->updateEstoque($nova_qntde, $id_item);

        //                 $entrega_model->insert($entrega);

        //             } catch (PDOException $e) {
        //                 print "Não foi possível atualizar quantidade de itens no estoque: ". $e->getMessage();
        //                 die();
        //             }

        //         }
        //     }
        // } 
    }  

    header("Location: ./pesquisar.php?entregue=".$id);