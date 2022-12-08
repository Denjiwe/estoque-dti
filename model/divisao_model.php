<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "divisao.php");
    
    class DivisaoModel {

        //select all
        function select(){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM divisao");
            $con->execute();

            $divisoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){

                $divisao = new Divisao;
                $divisao->setId($linha['id']);
                $divisao->setNome($linha['nome']);
                $divisao->setAtivo($linha['ativo']);
                $divisao->setDataCriacao($linha['data_criacao']);
                $divisao?->setDataDesativo($linha['data_destaivo']);
                $divisao->setDiretoriaId($linha['diretoria_id']);

                $divisoes[] = $divisao;
            }

            return $divisoes;
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
                $divisao?->setDataDesativo($linha['data_destaivo']);
                $divisao->setDiretoriaId($linha['diretoria_id']);

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
                $divisao?->setDataDesativo($linha['data_destaivo']);
                $divisao->setDiretoriaId($linha['diretoria_id']);
                
            }

            return $divisao;
        }
    }    