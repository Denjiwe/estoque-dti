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

            if (count($itens) > 0) {
                foreach ($itens as $item) {
                    //mudar produto_vinculado_id para sprimento
                    $vinculados = $conexao->prepare("INSERT INTO itens_produto (produto_id, produto_vinculado_id) VALUES (:proprietario, :suprimento)");
                    $vinculados->bindValue("proprietario", $lastId, PDO::PARAM_INT);
                    $vinculados->bindValue("suprimento", $item, PDO::PARAM_INT);
                    $vinculados->execute();
                }
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
            $itensForm = $produto->getItens();
            
            $getItensDb = $conexao->prepare("SELECT produto_vinculado_id FROM itens_produto WHERE produto_id=:id");
            $getItensDb->bindValue("id", $produto->getId(), PDO::PARAM_INT);
            $getItensDb->execute();
            $itensDb= [];
            
            while ($linha = $getItensDb->fetch(PDO::FETCH_ASSOC)) {
                $item = $linha['produto_vinculado_id'];
                $itensDb[] = $item;
            }

            try {
                $conexao->beginTransaction();
                $con = $conexao->prepare("UPDATE produto SET modelo_produto = :modelo, descricao = :descricao, qntde_estoque = :qntde, ativo = :ativo WHERE id = :id");
                $con->bindValue ("modelo", $produto->getModelo(), PDO::PARAM_STR);
                $con->bindValue ("descricao", $produto?->getDescricao(), PDO::PARAM_STR);
                $con->bindValue ("qntde", $produto->getQntde(), PDO::PARAM_INT);
                $con->bindValue ("ativo", $produto->getAtivo(), PDO::PARAM_INT);
                $con->bindValue ("id", $produto->getId(), PDO::PARAM_INT);
                $con->execute();

                
                
                $itensInsert = array_diff($itensForm, $itensDb);
                if ($itensInsert!= null) {
                    foreach ($itensInsert as $item) {
                        $insert = $conexao->prepare("INSERT INTO itens_produto (produto_id, produto_vinculado_id) VALUES (:proprietario , :suprimento)");
                        $insert->bindValue("proprietario", $produto->getId(), PDO::PARAM_INT);
                        $insert->bindValue("suprimento",$item, PDO::PARAM_INT);
                        $insert->execute();
                    }
                }

                $itensDelete = array_diff($itensDb, $itensForm);
                if ($itensDelete!= null) {
                    foreach ($itensDelete as $item) {
                        $delete = $conexao->prepare("delete from itens_produto where produto_id = :proprietario and produto_vinculado_id = :suprimento");
                        $delete->bindValue("proprietario", $produto->getId(), PDO::PARAM_INT);
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
            $con = $conexao->prepare("SELECT * FROM produto;");
            $con->execute();
            
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

        //findByName
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

        //getSuprimentos
        function getSuprimentos(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select produto.id, produto.modelo_produto from produto inner join itens_produto on produto.id = itens_produto.produto_vinculado_id where itens_produto.produto_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();
            $stmt = $con->fetchAll();

            return $stmt;
        }

        //selectImpressora
        function selectImpressora() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select id, modelo_produto from produto where LOCATE('impressora', modelo_produto)");
            $con->execute();
            $impressoras = $con->fetchAll();

            return $impressoras;
        }

        //getToner
        function getToner(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select produto.id, produto.modelo_produto from produto inner join itens_produto on produto_id = produto.id where LOCATE('Toner', modelo_produto) and produto_vinculado_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $toner = new Produto;
                $toner->setId($linha['id']);
                $toner->setModelo($linha['modelo_produto']);
            }

            return $toner;
        }

        //getCilíndro
        function getCilindro(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select produto.id, produto.modelo_produto from produto inner join itens_produto on produto_id = produto.id where LOCATE('Cilíndro', modelo_produto) and produto_vinculado_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $cilindro = new Produto;
                $cilindro->setId($linha['id']);
                $cilindro->setModelo($linha['modelo_produto']);
            }

            return $cilindro;
        }

        //updateEstoque
        function updateEstoque(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select qntde_estoque from produto where id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $qntde = new Produto;
                $qntde ->setQntde($linha['qntde_estoque']);
            }

            return $qntde;
        }

        //setEstoque
        function setEstoque(int $qntde, int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("update produto set qntde_estoque = :qntde where id = :id");
            $con->bindValue("qntde", $qntde, PDO::PARAM_INT);
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

        }
    }
