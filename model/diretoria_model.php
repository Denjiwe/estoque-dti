<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "diretoria.php");
    
    class DiretoriaModel {

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
                $diretoria?->setDataDesativo($linha['data_destaivo']);
                $diretoria->setOrgaoId($linha['orgao_id']);

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
                $diretoria?->setDataDesativo($linha['data_destaivo']);
                $diretoria->setOrgaoId($linha['orgao_id']);

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
                $diretoria?->setDataDesativo($linha['data_destaivo']);
                $diretoria->setOrgaoId($linha['orgao_id']);
                
            }

            return $diretoria;
        }
    }    