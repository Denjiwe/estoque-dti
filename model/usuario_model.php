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

            //abrir transação, fazer prepare do insert, depois armazenar o lastinserid, depois criar foreach do array de itens o insert do itens produto, 
            //usando o lastinsertid para o produto proprietario e o item do array para o produto vinculado
            $conexao = Conexao::getConexao();

            try {
            $con = $conexao->prepare("INSERT INTO usuario (nome, cpf, email, senha, ativo, divisao_id, diretoria_id) VALUES (:nome, :cpf, :senha, :ativo, divisao, diretoria)");
            $con->bindValue ("nome", $usuario->getNome(), PDO::PARAM_STR);
            $con->bindValue ("cpf", $usuario?->getCpf(), PDO::PARAM_STR);
            $con->bindValue ("email", $usuario->getEmail(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $usuario->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("divisao", $usuario->getDivisao(), PDO::PARAM_INT);
            $con->bindValue ("diretoria", $usuario->getDiretoria(), PDO::PARAM_INT);
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
                $usuario?->setDivisao($linha['divisao_id']);
                $usuario->setDiretoria($linha['diretoria_id']);

            }

            return $usuario;
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
    

        //selectDiretoria
        function selectDiretoria() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select diretoria.id as dir_id, diretoria.nome as dir_nome from diretoria");
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

    }
