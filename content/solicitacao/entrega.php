<?php

    include ("../../entity/solicitacao.php");   

    include ("../../model/solicitacao_model.php");

    include ("../../entity/produto.php");

    include ("../../model/produto_model.php");

    include ("../../entity/entrega.php");

    include ("../../model/entrega_model.php");

    $id = $_REQUEST['solicitacao'];

    $produtos[] = $_POST['id'];
    $qntdes[] = $_POST['qntde'];
    $estado = $_POST['estado'];

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
    foreach ($produtos as $produto) {
        $cont = 0;
        foreach ($solicitacao_itens as $item){
            $id_item = $item['id'];
            $qntde = $qntdes[0][$cont];

            if (@$produto[$cont] == $id_item){

                if ($qntde <= $item['qntde_item']){

                    $qntde_estoque = $produto_model->getEstoque($id_item);

                    $nova_qntde = $qntde_estoque->getQntde() - $qntde;

                    try {
                        $produto_model->updateEstoque($nova_qntde, $id_item);


                    } catch (PDOException $e) {
                        print "Não foi possível atualizar quantidade de itens no estoque: ". $e->getMessage();
                        die();
                    }

                }
            }    
            $cont++;
        }   
    }

    header("Location: ./pesquisar.php?entregue=".$id);