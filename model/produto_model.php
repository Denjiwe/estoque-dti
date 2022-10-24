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
        function select (Produto $produto) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto;");
            $con->execute();
        }

        //findById
        function findById (Produto $produto) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM produto WHERE id = :id;");
            $con->bindValue ("id", $produto->getId(), PDO::PARAM_INT);
            $con->execute();
        }
    }

