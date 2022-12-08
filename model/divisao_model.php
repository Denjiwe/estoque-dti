<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "divisao.php");
    
    class DivisaoModel {
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM divisao WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        //insert
        function insert (Divisao $divisao) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("INSERT INTO divisao (nome, ativo, data_criacao, data_desativado, diretoria_id) VALUES (:nome, :ativo, :data_criacao, :data_desativado, :diretoria)");
            $con->bindValue ("nome", $divisao->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $divisao->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $divisao->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $divisao?->getDataDesativo(), PDO::PARAM_STR);
            $con->bindValue ("diretoria", $divisao->getDiretoriaId(), PDO::PARAM_INT);
            $con->execute();
        }

        //update
        function update (Divisao $divisao){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("UPDATE divisao SET nome = :nome, ativo = :ativo, data_criacao = :data_criacao, data_desativado = :data_desativado, diretoria_id = :diretoria WHERE id = :id");
            $con->bindValue ("nome", $divisao->getNome(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $divisao->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("data_criacao", $divisao->getDataCriacao(), PDO::PARAM_STR);
            $con->bindValue ("data_desativado", $divisao?->getDataDesativo(), PDO::PARAM_STR);
            $con->bindValue ("diretoria", $divisao->getDiretoriaId(), PDO::PARAM_INT);
            $con->bindValue ("id", $divisao->getId(), PDO::PARAM_INT);
            $con->execute();
        }


        //select all
        function select(){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM divisao");
            $con->execute();

            $divisaos = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){

                $divisao = new Divisao;
                $divisao->setId($linha['id']);
                $divisao->setNome($linha['nome']);
                $divisao->setAtivo($linha['ativo']);
                $divisao->setDataCriacao($linha['data_criacao']);
                $divisao?->setDataDesativo($linha['data_desativado']);
                $divisao->setDiretoriaId($linha['diretoria_id']);
                $divisao->setDiretoriaNome($this->findDiretoriaNome($linha['diretoria_id']));

                $divisaos[] = $divisao;
            }

            return $divisaos;
        }

        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM divisao WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $divisao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $divisao = new Divisao;
                $divisao->setId($linha['id']);
                $divisao->setNome($linha['nome']);
                $divisao->setAtivo($linha['ativo']);
                $divisao->setDataCriacao($linha['data_criacao']);
                $divisao?->setDataDesativo($linha['data_desativado']);
                $divisao->setDiretoriaId($linha['diretoria_id']);
                $divisao->setDiretoriaNome($this->findDiretoriaNome($linha['diretoria_id']));

            }

            return $divisao;
        }

        //findByName
        function findByName(string $nome) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM divisao WHERE nome = :nome;");
            $con->bindValue ("nome", $nome, PDO::PARAM_STR);
            $con->execute();

            $divisao = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $divisao = new Divisao;
                $divisao->setId($linha['id']);
                $divisao->setNome($linha['nome']);
                $divisao->setAtivo($linha['ativo']);
                $divisao->setDataCriacao($linha['data_criacao']);
                $divisao?->setDataDesativo($linha['data_desativado']);
                $divisao->setDiretoriaId($linha['diretoria_id']);
                $divisao->setDiretoriaNome($this->findDiretoriaNome($linha['diretoria_id']));
                
            }

            return $divisao;
        }

        //findDiretoriaNome
        function findDiretoriaNome(int $diretoriaId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id;");
            $con->bindValue ("id", $diretoriaId, PDO::PARAM_STR);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $diretoriaNome = $linha['nome'];
            }

            return $diretoriaNome;
        }

        //getDiretorias
        function getDiretorias() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT id, nome FROM diretoria");
            $con->execute();

            $diretorias = $con->fetchAll();

            return $diretorias;
        }
    }    