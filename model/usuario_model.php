<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "usuario.php");
    
    class UsuarioModel {

        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM usuario WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        function insert (Usuario $usuario) {
            $conexao = Conexao::getConexao();

            try {
            $con = $conexao->prepare("INSERT INTO usuario (nome, cpf, email, senha, ativo, divisao_id, diretoria_id) VALUES (:nome, :cpf, :email, :senha, :ativo, :divisao, :diretoria)");
            $con->bindValue ("nome", $usuario->getNome(), PDO::PARAM_STR);
            $con->bindValue ("cpf", $usuario->getCpf(), PDO::PARAM_INT);
            $con->bindValue ("email", $usuario->getEmail(), PDO::PARAM_STR);
            $con->bindValue ("senha", $usuario->getSenha(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $usuario->getAtivo(), PDO::PARAM_INT);
            
            if ($usuario->getDiretoriaId() >= 1){
                $con->bindValue ("diretoria", $usuario->getDiretoriaId(), PDO::PARAM_INT);
                $con->bindValue ("divisao", null, PDO::PARAM_NULL);
            } elseif ($usuario->getDivisaoId() >= 1) {
                $con->bindValue ("divisao", $usuario->getDivisaoId(), PDO::PARAM_INT);
                $con->bindValue ("diretoria", null, PDO::PARAM_NULL);
            }
            
            $con->execute();

            } catch (PDOException $e) {
                throw $e;
            } 
        }

        //update
        function update (Usario $usuario){
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
            $con = $conexao->prepare("SELECT * FROM usuario;");
            $con->execute();
            
            $usuarios = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $usuario = new Usuario;
            $usuario->setId($linha['id']);
            $usuario->setCpf($linha['cpf']);
            $usuario->setNome($linha['nome']);
            $usuario->setEmail($linha['email']);
            $usuario->setAtivo($linha['ativo']);

            if (@$linha['divisao_id'] >= 1){
                $usuario->setDivisaoId($linha['divisao_id']);
                $usuario->setDiretoriaId(0);
                $conn = $conexao->prepare("SELECT nome FROM divisao WHERE id = :id");
                $conn->bindValue("id", $linha['divisao_id'], PDO::PARAM_INT);
                $conn->execute();

                while ($linha = $conn->fetch(PDO::FETCH_ASSOC)){
                    $divisao = $linha['nome'];
                }

                $usuario->setDivisaoNome($divisao);
            }

            if (@$linha['diretoria_id'] >= 1){ 
                $usuario->setDiretoriaId($linha['diretoria_id']);
                $usuario->setDivisaoId(0);
                $conn = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id");
                $conn->bindValue("id", $linha['diretoria_id'], PDO::PARAM_INT);
                $conn->execute();

                while ($linha = $conn->fetch(PDO::FETCH_ASSOC)){
                    $diretoria = $linha['nome'];
                }

                $usuario->setDiretoriaNome($diretoria);
            }

            $usuarios[] = $usuario; 
            }

            return $usuarios;
            
        }

        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM usuario WHERE id = :id;");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $usuario = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $usuario = new Usuario;
                $usuario->setId($linha['id']);
                $usuario->setNome($linha['nome']);
                $usuario->setCpf($linha['cpf']);
                $usuario->setEmail($linha['email']);
                $usuario->setSenha($linha['senha']);
                $usuario->setAtivo($linha['ativo']);
                
                if (@$linha['divisao_id'] >= 1){
                    $usuario->setDivisaoId($linha['divisao_id']);
                    $usuario->setDiretoriaId(0);
                    $conn = $conexao->prepare("SELECT nome FROM divisao WHERE id = :id");
                    $conn->bindValue("id", $linha['divisao_id'], PDO::PARAM_INT);
                    $conn->execute();
    
                    while ($linha = $conn->fetch(PDO::FETCH_ASSOC)){
                        $divisao = $linha['nome'];
                    }
    
                    $usuario->setDivisaoNome($divisao);
                }

                if (@$linha['diretoria_id'] >= 1){ 
                    $usuario->setDiretoriaId($linha['diretoria_id']);
                    $usuario->setDivisaoId(0);
                    $conn = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id");
                    $conn->bindValue("id", $linha['diretoria_id'], PDO::PARAM_INT);
                    $conn->execute();
    
                    while ($linha = $conn->fetch(PDO::FETCH_ASSOC)){
                        $diretoria = $linha['nome'];
                    }
    
                    $usuario->setDiretoriaNome($diretoria);
                }
            }

            return $usuario;
        }

        //findByName
        function findByName(string $nome) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM usuario WHERE nome = :nome;");
            $con->bindValue ("nome", $nome, PDO::PARAM_STR);
            $con->execute();

            $usuario = null;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $usuario = new Usuario;
                $usuario->setId($linha['id']);
                $usuario->setCpf($linha['cpf']);
                $usuario->setNome($linha['nome']);
                $usuario->setEmail($linha['email']);
                $usuario->setAtivo($linha['ativo']);
                
                if ($linha['divisao_id'] != null){
                    $usuario->setDivisaoId($linha['divisao_id']);
                    $con = $conexao->prepare("SELECT nome FROM divisao WHERE id = :id");
                    $con->bindValue("id", $linha['divisao_id'], PDO::PARAM_INT);
                    $con->execute();
    
                    while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                        $divisao = $linha['nome'];
                    }
    
                    $usuario->setDivisaoNome($divisao);
                }
                
                if ($linha['diretoria_id'] != null){ 
                    $usuario->setDiretoriaId($linha['diretoria_id']);
                    $con = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id");
                    $con->bindValue("id", $linha['diretoria_id'], PDO::PARAM_INT);
                    $con->execute();
    
                    while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                        $diretoria = $linha['nome'];
                    }
    
                    $usuario->setDiretoriaNome($diretoria);
                }       
            }

            return $usuario;
        }
    

        //selectDiretoria
        function selectDiretoria() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select diretoria.id, diretoria.nome from diretoria");
            $con->execute();
            $diretorias = $con->fetchAll();

            return $diretorias;
        }

        //selectDivisao
        function selectDivisao() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select divisao.id, divisao.nome from divisao");
            $con->execute();
            $divisoes = $con->fetchAll();

            return $divisoes;
        
        }

    }
