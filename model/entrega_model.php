<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "entrega.php");

    class EntregaModel 
        {

            function select() {
                $conexao = Conexao::getConexao();
                $con = $conexao->prepare("SELECT entrega.*, itens_solicitacao.solicitacao_id FROM entrega INNER JOIN itens_solicitacao ON entrega.itens_solicitacao_id = itens_solicitacao.id");
                $con->execute();

                $entregas = [];

                while ($linha = $con->fetch(PDO::FETCH_ASSOC)){

                    $entrega = new Entrega;
                    $entrega->setId($linha['id']);
                    $entrega->setQtnde($linha['qntde']);
                    $entrega->setDataEntrega($linha['data_entrega']);
                    $entrega->setUsuarioId($linha['usuario_id']);
                    $entrega->setItensId($linha['itens_solicitacao_id']);
                    $entrega->setUsuarioEntrega($linha['usuario_entrega']);
                    $entrega->setSolicitacaoId($linha['solicitacao_id']);

                    $entregas[] = $entrega;
                }

                return $entregas;

            } 

            function insert(Entrega $entrega) {
                $conexao = Conexao::getConexao();
                $con = $conexao->prepare("INSERT INTO entrega (qntde, data_entrega, usuario_id, itens_solicitacao_id, usuario_entrega) VALUES (:qntde, now(), :usuario_id , :itens_id, :usuario_entrega)");
                $con->bindValue("qntde", $entrega->getQntde(), PDO::PARAM_INT);
                $con->bindValue("usuario_id", $entrega->getUsuarioId(), PDO::PARAM_INT);
                $con->bindValue("itens_id", $entrega->getItensId(), PDO::PARAM_INT);
                $con->bindValue("usuario_entrega", $entrega->getUsuarioEntrega(), PDO::PARAM_INT);
                $con->execute();
            }

            function update(Entrega $entrega) {
                $conexao = Conexao::getConexao();
                $con = $conexao->prepare("UPDATE entrega set qntde = :qntde, data_entrega = now(), usuario_id = :usuario_id, itens_solicitacao_id = :itens_id, usuario_entrega = :usuario_entrega WHERE id = :id");
                $con->bindValue("qntde", $entrega->getQntde(), PDO::PARAM_INT);
                $con->bindValue("usuario_id", $entrega->getUsuarioId(), PDO::PARAM_INT);
                $con->bindValue("itens_id", $entrega->getItensId(), PDO::PARAM_INT);
                $con->bindValue("id", $entrega->getId(), PDO::PARAM_INT);
                $con->bindValue("usuario_entrega", $entrega->getUsuarioEntrega(), PDO::PARAM_INT);
                $con->execute();
            }

            function getUsuarioNome(int $id) {
                $conexao = Conexao::getConexao();
                $con = $conexao->prepare("SELECT usuario.nome FROM usuario WHERE id = :id");
                $con->bindValue("id", $id, PDO::PARAM_INT);
                $con->execute();

                $nome = $con->fetch(PDO::FETCH_ASSOC);

                return $nome;
            }

            function getProdutoNome(int $id) {
                $conexao = Conexao::getConexao();
                $con = $conexao->prepare("SELECT modelo_produto FROM produto INNER JOIN itens_solicitacao on itens_solicitacao.produto_id = produto.id WHERE itens_solicitacao.id = :id");
                $con->bindValue("id", $id, PDO::PARAM_INT);
                $con->execute();

                $modelo = $con->fetch(PDO::FETCH_ASSOC);

                return $modelo;
            }
        }