<?php

    include_once ("../../database/config.php");

    include_once ("../../entity/entrega.php");

    class EntregaModel 
        {

           function select() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM entrega");
            $con->execute();

            $entregas = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){

                $entrega = new Entrega;
                $entrega->setId($linha['id']);
                $entrega->setQtnde($linha['qntde']);
                $entrega->setDataEntrega($linha['data_entrega']);
                $entrega->setObservacao($linha['observacao']);
                $entrega->setUsuarioId($linha['usuario_id']);
                $entrega->setItensId($linha['itens_solicitacao_id']);

                $entregas[] = $entrega;
            }

            return $entregas;

           } 

           function insert(Entrega $entrega) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("INSERT INTO entrega (qntde, data_entrega, usuario_id, itens_solicitacao_id) VALUES (:qntde, now(), :usuario_id , :itens_id)");
            $con->bindValue("qntde", $entrega->getQntde(), PDO::PARAM_INT);
            $con->bindValue("usuario_id", $entrega->getUsuarioId(), PDO::PARAM_INT);
            $con->bindValue("itens_id", $entrega->getItensId(), PDO::PARAM_INT);
           }

        }