<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "orgao.php");
    
    class OrgaoModel {
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM orgao WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        function insert (Orgao $orgao) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("INSERT INTO orgao (nome, ativo, data_criacao, data_desativado) VALUES (:nome, :ativo, :data_criacao, :data_desativado)");
            $con->bindValue ("nome", $orgao->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $orgao->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $orgao->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $orgao?->getDataDesativo(), PDO::PARAM_STR);
            $con->execute();
        }

        //update
        function update (Orgao $orgao){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("UPDATE orgao SET nome = :nome, ativo = :ativo, data_criacao = :data_criacao, data_desativado = :data_desativado WHERE id = :id");
            $con->bindValue ("nome", $orgao->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $orgao->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $orgao->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $orgao?->getDataDesativo(), PDO::PARAM_STR);
            $con->bindValue ("id", $orgao->getId(), PDO::PARAM_INT);
            $con->execute();
        }

        //select all
        function select () {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM orgao;");
            $con->execute();
            $con->rowCount();
            
            $orgaos = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $orgao = new Orgao;
            $orgao->setId($linha['id'])."</td>";
            $orgao->setNome($linha['nome'])."</td>";
            $orgao->setAtivo($linha['ativo'])."</td>";
            $orgao->setDataCriacao($linha['data_criacao'])."</td>";
            $orgao->setDataDesativo($linha['data_desativado'])."</td>";
            $orgaos[] = $orgao; 
            
            }
            
            return $orgaos;
        }
        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM orgao WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $orgao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $orgao = new Orgao;
                $orgao->setId($linha['id']);
                $orgao->setNome($linha['nome']);
                $orgao->setAtivo($linha['ativo']);
                $orgao->setDataCriacao($linha['data_criacao']);
                $orgao->setDataDesativo($linha['data_desativado']);
                
            }

            return $orgao;


            /*if ($resultado == 1) {
                $orgao = new Orgao;
                $orgao->setId('id');
                $orgao->setNome('nome');
                $orgao->setDataCriacao('data_criacao');
                $orgao->setDataDesativo('data_desativado');
                $orgao->setAtivo('ativo');

                return $orgao;
            } else echo "Nenhm valor encontrado para esse id!";*/
            
        }

        //findByname
        function findByName(string $nome) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM orgao WHERE nome = :nome;");
            $con->bindValue ("nome", $nome, PDO::PARAM_STR);
            $con->execute();

            $orgao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $orgao = new Orgao;
                $orgao->setId($linha['id'])."</td>";
                $orgao->setNome($linha['nome'])."</td>";
                $orgao->setAtivo($linha['ativo'])."</td>";
                $orgao->setDataCriacao($linha['data_criacao'])."</td>";
                $orgao->setDataDesativo($linha['data_desativado'])."</td>";
                
            }

            return $orgao;
        }

    }
