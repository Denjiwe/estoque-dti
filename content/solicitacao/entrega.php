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
    foreach ($produtos as $produto) {
        $cont = 0;
        foreach ($solicitacao_itens as $item){
            //$id_item se refere ao id do produto em si, presente na tabela itens_solicitacao
            $id_item = $item['id'];
            //$qntde se refere a quantidade do produto da determinada item, $cont define qual dos itens é o atual, 
            //0 está presente somente para pegar o primeiro elemento do array que será retornado, sendo a quantidade
            $qntde = $qntdes[0][$cont];
            //$idItemSolicitacao se refere ao id da tabela itens_solicitacao em si, que é necessario para ser realizada 
            //a inserção na tabela de entregas
            $idItemSolicitacao = $solicitacao_itens[$cont]['is_id'];

            if (@$produto[$cont] == $id_item){

                if ($qntde <= $item['qntde_item']){

                    $qntde_estoque = $produto_model->getEstoque($id_item);

                    $nova_qntde = $qntde_estoque->getQntde() - $qntde;

                    $entrega = new Entrega;
                    $entrega->setQtnde($qntde);
                    $entrega->setUsuarioId($usuario);
                    $entrega->setItensId($idItemSolicitacao);

                    try {
                        $produto_model->updateEstoque($nova_qntde, $id_item);

                        $entrega_model->insert($entrega);

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