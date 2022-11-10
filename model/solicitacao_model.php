<?php

    include_once ("../../database/config.php");

    include_once ("../../entity/solicitacao.php");
    
    class SolicitacaoModel {

        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM solicitacao WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        function insert (Solicitacao $solicitacao) {

            $conexao = Conexao::getConexao();

            try {
            $conexao->beginTransaction();
            $con = $conexao->prepare("INSERT INTO solicitacao (estado_solicitacao, descricao, data_solicitacao, usuario_id) VALUES (:estado, :descricao, :data_solicitacao, :usuario_id)");
            $con->bindValue ("estado", $solicitacao->getEstadoSolicitacao(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $solicitacao?->getDescricao(), PDO::PARAM_STR);
            $con->bindValue ("data_solicitacao", $solicitacao->getDataSolicitacao());
            $con->bindValue ("usuario_id", 1 /*$solicitacao->getUsuarioId()*/, PDO::PARAM_INT);
            $con->execute();
            $lastId = $conexao->lastInsertId();
            $itens = $solicitacao->getItemSolicitacao();

            foreach ($itens as $item) {
                $solicitados = $conexao->prepare("INSERT INTO itens_solicitacao (solicitacao_id, produto_id, qntde_item) VALUES (:solicitacao, :produto, :qntde)");
                $solicitados->bindValue("solicitacao", $lastId, PDO::PARAM_INT);
                $solicitados->bindValue("produto", $item, PDO::PARAM_INT);
                $solicitados->bindValue("qntde", $solicitacao->getQntdeItem(), PDO::PARAM_INT);
                $solicitados->execute();
            }

            $conexao->commit();

            } catch (PDOException $e) {
                $conexao->rollBack();
                throw $e;

            }           
        }

        //update
        function update (Solicitacao $solicitacao){
            $conexao = Conexao::getConexao();
            $itensForm = $solicitacao->getItens();
            
            $getItensDb = $conexao->prepare("SELECT solicitacao_vinculado_id FROM itens_solicitacao WHERE solicitacao_id=:id");
            $getItensDb->bindValue("id", $solicitacao->getId(), PDO::PARAM_INT);
            $getItensDb->execute();
            $itensDb= [];
            
            while ($linha = $getItensDb->fetch(PDO::FETCH_ASSOC)) {
                $item = $linha['solicitacao_vinculado_id'];
                $itensDb[] = $item;
            }

            try {
                $conexao->beginTransaction();
                $con = $conexao->prepare("UPDATE solicitacao SET estado_solicitacao = :estado, descricao = :descricao, data_solicitacao = :data_solicitacao, usuario_id = :usuario_id WHERE id = :id");
                $con->bindValue ("estado", $solicitacao->getEstadoSolicitacao(), PDO::PARAM_STR);
                $con->bindValue ("descricao", $solicitacao?->getDescricao(), PDO::PARAM_STR);
                $con->bindValue ("data_solicitacao", $solicitacao->getDataSolicitacao());
                $con->bindValue ("usuario_id", 1 /*$solicitacao->getUsuarioId()*/, PDO::PARAM_INT);
                $con->bindValue ("id", $solicitacao->getId(), PDO::PARAM_INT);
                $con->execute();

                
                
                $itensInsert = array_diff($itensForm, $itensDb);
                if ($itensInsert!= null) {
                    foreach ($itensInsert as $item) {
                        $insert = $conexao->prepare("INSERT INTO itens_solicitacao (solicitacao_id, solicitacao_vinculado_id) VALUES (:proprietario , :suprimento)");
                        $insert->bindValue("proprietario", $solicitacao->getId(), PDO::PARAM_INT);
                        $insert->bindValue("suprimento",$item, PDO::PARAM_INT);
                        $insert->execute();
                    }
                }

                $itensDelete = array_diff($itensDb, $itensForm);
                if ($itensDelete!= null) {
                    foreach ($itensDelete as $item) {
                        $delete = $conexao->prepare("delete from itens_solicitacao where solicitacao_id = :proprietario and solicitacao_vinculado_id = :suprimento");
                        $delete->bindValue("proprietario", $solicitacao->getId(), PDO::PARAM_INT);
                        $delete->bindValue("suprimento",$item, PDO::PARAM_INT);
                        $delete->execute();
                    }
                }

                $conexao->commit();


            } catch (PDOException $e) {
                $conexao->rollback();
                throw $e;
            }

        }

        //select all
        function select () {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM solicitacao;");
            $con->execute();
            
            $solicitacoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $solicitacao = new Solicitacao;
            $solicitacao->setId($linha['id']);
            $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
            $solicitacao->setDescricao($linha['descricao']);
            $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
            $solicitacao->setUsuarioId($linha['usuario_id']);
            $solicitacoes[] = $solicitacao; 
            
            }

            return $solicitacoes;
            
        }
        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM solicitacao WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $solicitacao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $solicitacao = new Solicitacao;
                $solicitacao->setId($linha['id']);
                $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
                $solicitacao->setDescricao($linha['descricao']);
                $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
                $solicitacao->setUsuarioId($linha['usuario_id']);

            }

            return $solicitacao;
        }

        function findByName(string $estado) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM solicitacao WHERE estado_solicitacao = :estado;");
            $con->bindValue ("estado", $estado, PDO::PARAM_STR);
            $con->execute();

            $solicitacao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $solicitacao = new Solicitacao;
                $solicitacao->setId($linha['id']);
                $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
                $solicitacao->setDescricao($linha['descricao']);
                $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
                $solicitacao->setUsuarioId($linha['usuario_id']);
                
            }

            return $solicitacao;
        }

        function selectItemSolicitacao(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select solicitacao.id, solicitacao.estado_solicitacao from solicitacao inner join itens_solicitacao on solicitacao.id = itens_solicitacao.solicitacao_vinculado_id where itens_solicitacao.solicitacao_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();
            $stmt = $con->fetchAll();

            return $stmt;

        }
    }
