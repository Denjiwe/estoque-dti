<?php

    include_once ("./database/config.php");

    include_once ("./entity/produto.php");
    
    class ProdutoModel {
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM produto WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        function insert (Produto $produto) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("INSERT INTO produto (modelo_produto, descricao, qntde_estoque, ativo) VALUES (:modelo, :descricao, :qntde, :ativo)");
            $con->bindValue ("modelo", $produto->getModelo(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $produto->getDescricao(), PDO::PARAM_STR);
            $con->bindValue ("qntde", $produto->getQntde(), PDO::PARAM_INT);
            $con->bindValue ("ativo", $produto->getAtivo(), PDO::PARAM_INT);
            $con->execute();
        }

        //update
        function update (Produto $produto){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("UPDATE produto SET modelo_produto = :modelo, descricao = :descricao, qntde_estoque = :qntde, ativo = :ativo WHERE id = :id");
            $con->bindValue ("modelo", $produto->getModelo(), PDO::PARAM_STR);
            $con->bindValue ("descricao", $produto->getDescricao(), PDO::PARAM_STR);
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
            print "<table class=' container table table-hover table-striped table-bordered'>";
            
            //criar função que realiza a formatação dos prints 
            foreach ($produtos as $obj) {
                print "<tr>";
                print "<td>".$obj->getId()."</td>";
                print "<td>".$obj->getModelo()."</td>";
                print "<td>".$obj->getDescricao()."</td>";
                print "<td>".$obj->getQntde()."</td>";
                print "<td>".$obj->getAtivo()."</td>";
                print "</tr>";

            }
            print "</table>";
            
        }
        //findById
        function findById (Produto $produto) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto WHERE id = :id;");
            $con->bindValue ("id", $produto->getId(), PDO::PARAM_INT);
            $con->execute();
        }
    }
