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
            $con = $conexao->prepare("INSERT INTO solicitacao (estado_solicitacao, descricao, data_solicitacao, usuario_id, diretoria_id) VALUES (:estado, :descricao, :data_solicitacao, :usuario_id, :diretoria)");
            $con->bindValue ("estado", $solicitacao->getEstadoSolicitacao(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $solicitacao?->getDescricao(), PDO::PARAM_STR);
            $con->bindValue ("data_solicitacao", $solicitacao->getDataSolicitacao());
            $con->bindValue ("usuario_id", 1 /*$solicitacao->getUsuarioId()*/, PDO::PARAM_INT);
            $con->bindValue ("diretoria", 1, PDO::PARAM_INT);
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

        //select all
        function select () {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select solicitacao.* ,usuario.nome from solicitacao inner join usuario on usuario_id = usuario.id order by solicitacao.id desc");
            $con->execute();
            
            $solicitacoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $solicitacao = new Solicitacao;
            $solicitacao->setId($linha['id']);
            $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
            $solicitacao->setDescricao($linha['descricao']);
            $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
            $solicitacao->setUsuarioId($linha['usuario_id']);
            $solicitacao->setUsuarioNome($linha['nome']);

            $solicitacoes[] = $solicitacao; 
            
            }

            return $solicitacoes;
            
        }

        /*
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
        }*/

        function selectItemSolicitacao(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select produto.modelo_produto, itens_solicitacao.qntde_item from produto inner join itens_solicitacao on itens_solicitacao.produto_id = produto.id where itens_solicitacao.solicitacao_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();
            $stmt = $con->fetchAll();

            return $stmt;
        }
    }
