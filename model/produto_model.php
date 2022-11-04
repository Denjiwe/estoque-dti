<?php

    include_once ("../../database/config.php");

    include_once ("../../entity/produto.php");
    
    class ProdutoModel {
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM produto WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        function insert (Produto $produto) {

            //abrir transação, fazer prepare do insert, depois armazenar o lastinserid, depois criar foreach do array de itens o insert do itens produto, 
            //usando o lastinsertid para o produto proprietario e o item do array para o produto vinculado
            $conexao = Conexao::getConexao();

            try {
            $conexao->beginTransaction();
            $con = $conexao->prepare("INSERT INTO produto (modelo_produto, descricao, qntde_estoque, ativo) VALUES (:modelo, :descricao, :qntde, :ativo)");
            $con->bindValue ("modelo", $produto->getModelo(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $produto?->getDescricao(), PDO::PARAM_STR);
            $con->bindValue ("qntde", $produto->getQntde(), PDO::PARAM_INT);
            $con->bindValue ("ativo", $produto->getAtivo(), PDO::PARAM_INT);
            $con->execute();
            $lastId = $conexao->lastInsertId();
            $itens = $produto->getItens();

            foreach ($itens as $item) {
                //mudar produto_vinculado_id para sprimento
                $vinculados = $conexao->prepare("INSERT INTO itens_produto (produto_id, produto_vinculado_id) VALUES (:produto_id, :produto_vinculado_id)");
                $vinculados->bindValue("produto_id", $lastId, PDO::PARAM_INT);
                $vinculados->bindValue("produto_vinculado_id", $item, PDO::PARAM_INT);
                $vinculados->execute();
            }

            $conexao->commit();

            } catch (PDOException $e) {
                $conexao->rollBack();
                throw $e;
                
            }

            
        }

        //update
        function update (Produto $produto){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("UPDATE produto SET modelo_produto = :modelo, descricao = :descricao, qntde_estoque = :qntde, ativo = :ativo WHERE id = :id");
            $con->bindValue ("modelo", $produto->getModelo(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $produto?->getDescricao(), PDO::PARAM_STR);
            $con->bindValue ("qntde", $produto->getQntde(), PDO::PARAM_INT);
            $con->bindValue ("ativo", $produto->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("id", $produto->getId(), PDO::PARAM_INT);
            $con->execute();
        }

        //select all
        function select () {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto;");
            $con->execute();
            $con->rowCount();
            
            $produtos = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $produto = new Produto;
            $produto->setId($linha['id'])."</td>";
            $produto->setModelo($linha['modelo_produto'])."</td>";
            $produto->setDescricao($linha['descricao'])."</td>";
            $produto->setQntde($linha['qntde_estoque'])."</td>";
            $produto->setAtivo($linha['ativo'])."</td>";
            $produtos[] = $produto; 
            
            }

            return $produtos;
            
        }
        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $produto = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $produto = new Produto;
                $produto->setId($linha['id']);
                $produto->setModelo($linha['modelo_produto']);
                $produto->setDescricao($linha['descricao']);
                $produto->setQntde($linha['qntde_estoque']);
                $produto->setAtivo($linha['ativo']);

            }

            return $produto;
        }

        function findByName(string $modelo) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto WHERE modelo_produto = :modelo;");
            $con->bindValue ("modelo", $modelo, PDO::PARAM_STR);
            $con->execute();

            $produto = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $produto = new Produto;
                $produto->setId($linha['id'])."</td>";
                $produto->setModelo($linha['modelo_produto'])."</td>";
                $produto->setDescricao($linha['descricao'])."</td>";
                $produto->setQntde($linha['qntde_estoque'])."</td>";
                $produto->setAtivo($linha['ativo'])."</td>";
                
            }

            return $produto;
        }
    }
