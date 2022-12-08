<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "diretoria.php");
    
    class DiretoriaModel {
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM diretoria WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        //insert
        function insert (Diretoria $diretoria) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("INSERT INTO diretoria (nome, ativo, data_criacao, data_desativado, orgao_id) VALUES (:nome, :ativo, :data_criacao, :data_desativado, :orgao)");
            $con->bindValue ("nome", $diretoria->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $diretoria->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $diretoria->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $diretoria?->getDataDesativo(), PDO::PARAM_STR);
            $con->bindValue ("orgao", $diretoria->getOrgaoId(), PDO::PARAM_INT);
            $con->execute();
        }

        //update
        function update (Diretoria $diretoria){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("UPDATE diretoria SET nome = :nome, ativo = :ativo, data_criacao = :data_criacao, data_desativado = :data_desativado, orgao_id = :orgao WHERE id = :id");
            $con->bindValue ("nome", $diretoria->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $diretoria->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $diretoria->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $diretoria?->getDataDesativo(), PDO::PARAM_STR);
            $con->bindValue ("orgao", $diretoria->getOrgaoId(), PDO::PARAM_INT);
            $con->bindValue ("id", $diretoria->getId(), PDO::PARAM_INT);
            $con->execute();
        }


        //select all
        function select(){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM diretoria");
            $con->execute();

            $diretorias = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){

                $diretoria = new Diretoria;
                $diretoria->setId($linha['id']);
                $diretoria->setNome($linha['nome']);
                $diretoria->setAtivo($linha['ativo']);
                $diretoria->setDataCriacao($linha['data_criacao']);
                $diretoria?->setDataDesativo($linha['data_desativado']);
                $diretoria->setOrgaoId($linha['orgao_id']);
                $diretoria->setOrgaoNome($this->findOrgaoNome($linha['orgao_id']));

                $diretorias[] = $diretoria;
            }

            return $diretorias;
        }

        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM diretoria WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $diretoria = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $diretoria = new Diretoria;
                $diretoria->setId($linha['id']);
                $diretoria->setNome($linha['nome']);
                $diretoria->setAtivo($linha['ativo']);
                $diretoria->setDataCriacao($linha['data_criacao']);
                $diretoria?->setDataDesativo($linha['data_desativado']);
                $diretoria->setOrgaoId($linha['orgao_id']);
                $diretoria->setOrgaoNome($this->findOrgaoNome($linha['orgao_id']));

            }

            return $diretoria;
        }

        //findByName
        function findByName(string $nome) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM diretoria WHERE nome = :nome;");
            $con->bindValue ("nome", $nome, PDO::PARAM_STR);
            $con->execute();

            $diretoria = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $diretoria = new Diretoria;
                $diretoria->setId($linha['id']);
                $diretoria->setNome($linha['nome']);
                $diretoria->setAtivo($linha['ativo']);
                $diretoria->setDataCriacao($linha['data_criacao']);
                $diretoria?->setDataDesativo($linha['data_desativado']);
                $diretoria->setOrgaoId($linha['orgao_id']);
                $diretoria->setOrgaoNome($this->findOrgaoNome($linha['orgao_id']));
                
            }

            return $diretoria;
        }

        //findOrgaoNome
        function findOrgaoNome(int $orgaoId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM orgao WHERE id = :id;");
            $con->bindValue ("id", $orgaoId, PDO::PARAM_STR);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $orgaoNome = $linha['nome'];
            }

            return $orgaoNome;
        }

        //getOrgaos
        function getOrgaos() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT id, nome FROM orgao");
            $con->execute();

            $orgaos = $con->fetchAll();

            return $orgaos;
        }
    }    