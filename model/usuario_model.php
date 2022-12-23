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
            $con = $conexao->prepare("INSERT INTO usuario (nome, cpf, email, senha, ativo, divisao_id, diretoria_id, usuario_dti) VALUES (:nome, :cpf, :email, :senha, :ativo, :divisao, :diretoria, :usuarioDti)");
            $con->bindValue ("nome", $usuario->getNome(), PDO::PARAM_STR);
            $con->bindValue ("cpf", $usuario->getCpf(), PDO::PARAM_INT);
            $con->bindValue ("email", $usuario->getEmail(), PDO::PARAM_STR);
            $con->bindValue ("senha", $usuario->getSenha(), PDO::PARAM_STR);
            $con->bindValue ("ativo", $usuario->getAtivo(), PDO::PARAM_INT);
            $con->bindValue ("usuarioDti", $usuario->getUsuarioDti(), PDO::PARAM_INT);
            
            if ($usuario->getDiretoriaId() !== 0){
                $con->bindValue ("diretoria", $usuario->getDiretoriaId(), PDO::PARAM_INT);
                $con->bindValue ("divisao", null, PDO::PARAM_NULL);
            } elseif ($usuario->getDivisaoId() !== 0) {
                $con->bindValue ("divisao", $usuario->getDivisaoId(), PDO::PARAM_INT);
                $con->bindValue ("diretoria", null, PDO::PARAM_NULL);
            }
            
            $con->execute();

            } catch (PDOException $e) {
                throw $e;
            } 
        }

        //updateComSenha
        function updateComSenha (Usuario $usuario){
            $conexao = Conexao::getConexao();

            try {
                $con = $conexao->prepare("UPDATE usuario SET nome = :nome, email = :email, senha = :senha, ativo = :ativo, diretoria_id = :diretoria, divisao_id = :divisao, usuario_dti = :usuarioDti WHERE id = :id");
                $con->bindValue ("nome", $usuario->getNome(), PDO::PARAM_STR);
                $con->bindValue ("email", $usuario?->getEmail(), PDO::PARAM_STR);
                $con->bindValue ("senha", $usuario->getSenha(), PDO::PARAM_INT);
                $con->bindValue ("ativo", $usuario->getAtivo(), PDO::PARAM_INT);
                $con->bindValue ("usuarioDti", $usuario->getUsuarioDti(), PDO::PARAM_INT);
                $con->bindValue ("id", $usuario->getId(), PDO::PARAM_INT);

                if ($usuario->getDiretoriaId() !== 0){
                    $con->bindValue ("diretoria", $usuario->getDiretoriaId(), PDO::PARAM_INT);
                    $con->bindValue ("divisao", null, PDO::PARAM_NULL);
                } elseif ($usuario->getDivisaoId() !== 0) {
                    $con->bindValue ("divisao", $usuario->getDivisaoId(), PDO::PARAM_INT);
                    $con->bindValue ("diretoria", null, PDO::PARAM_NULL);
                }

                $con->execute();

            } catch (PDOException $e) {
                throw $e;
            }

        }

        //updateSemSenha
        function updateSemSenha (Usuario $usuario){
            $conexao = Conexao::getConexao();

            try {
                $con = $conexao->prepare("UPDATE usuario SET nome = :nome, email = :email, ativo = :ativo, diretoria_id = :diretoria, divisao_id = :divisao, usuario_dti = :usuarioDti WHERE id = :id");
                $con->bindValue ("nome", $usuario->getNome(), PDO::PARAM_STR);
                $con->bindValue ("email", $usuario?->getEmail(), PDO::PARAM_STR);
                $con->bindValue ("ativo", $usuario->getAtivo(), PDO::PARAM_INT);
                $con->bindValue ("usuarioDti", $usuario->getUsuarioDti(), PDO::PARAM_INT);
                $con->bindValue ("id", $usuario->getId(), PDO::PARAM_INT);

                if ($usuario->getDiretoriaId() !== 0){
                    $con->bindValue ("diretoria", $usuario->getDiretoriaId(), PDO::PARAM_INT);
                    $con->bindValue ("divisao", null, PDO::PARAM_NULL);
                } elseif ($usuario->getDivisaoId() !== 0) {
                    $con->bindValue ("divisao", $usuario->getDivisaoId(), PDO::PARAM_INT);
                    $con->bindValue ("diretoria", null, PDO::PARAM_NULL);
                }

                $con->execute();

            } catch (PDOException $e) {
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
            $usuario->setUsuarioDti($linha['usuario_dti']);

            if (@$linha['divisao_id'] !== null){
                $usuario->setDivisaoId($linha['divisao_id']);
                $usuario->setDiretoriaId(0);
                $divisao = $this->findDivisaoNome($linha['divisao_id']);

                $usuario->setDivisaoNome($divisao);
            }

            if (@$linha['diretoria_id'] !== null){ 
                $usuario->setDiretoriaId($linha['diretoria_id']);
                $usuario->setDivisaoId(0);
                $diretoria = $this->findDiretoriaNome($linha['diretoria_id']);

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
                $usuario->setUsuarioDti($linha['usuario_dti']);
                
                if (@$linha['divisao_id'] !== null){
                    $usuario->setDivisaoId($linha['divisao_id']);
                    $usuario->setDiretoriaId(0);
                    $divisao = $this->findDivisaoNome($linha['divisao_id']);
    
                    $usuario->setDivisaoNome($divisao);
                }

                if (@$linha['diretoria_id'] !== null){ 
                    $usuario->setDiretoriaId($linha['diretoria_id']);
                    $usuario->setDivisaoId(0);
                    $diretoria = $this->findDiretoriaNome($linha['diretoria_id']);
    
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
                $usuario->setUsuarioDti($linha['usuario_dti']);

                
                if (@$linha['divisao_id'] !== null){
                    $usuario->setDivisaoId($linha['divisao_id']);
                    $usuario->setDiretoriaId(0);
                    $divisao = $this->findDivisaoNome($linha['divisao_id']);
    
                    $usuario->setDivisaoNome($divisao);
                }
                
                if (@$linha['diretoria_id'] !== null){ 
                    $usuario->setDiretoriaId($linha['diretoria_id']);
                    $usuario->setDivisaoId(0);
                    $diretoria = $this->findDiretoriaNome($linha['diretoria_id']);

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

        //findDivisaoNome
        function findDivisaoNome(int $id){
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM divisao WHERE id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();
            
            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $divisao = $linha['nome'];
            }

            return $divisao;
        } 

        //findDiretoriaNome
        function findDiretoriaNome(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $diretoria = $linha['nome'];
            }

            return $diretoria;
        }

        //findNomeId
        function findNomeId(string $cpf) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome, id FROM usuario WHERE cpf = :cpf");
            $con->bindValue("cpf", $cpf, PDO::PARAM_STR);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $nome = $linha['nome'];
                $id = $linha['id'];
                $nomeId = [$nome, $id];
            }

            return $nomeId;
        }

        //verificaDti
        function verificaDti(string $cpf) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT usuario_dti FROM usuario WHERE cpf = :cpf");
            $con->bindValue("cpf", $cpf, PDO::PARAM_STR);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)){
                $usuarioDti = $linha['usuario_dti'];
            }

            return $usuarioDti;
        }

        //verificaLogin
        function verificaLogin(string $login, string $senha) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT * FROM usuario WHERE cpf = :cpf and senha = :senha");
            $con->bindValue("cpf", $login, PDO::PARAM_STR);
            $con->bindValue("senha", $senha, PDO::PARAM_STR);
            $con->execute();

            $count = $con->rowCount();

            if ($count > 0){
                $nomeId = $this->findNomeId($login);
                if ($this->verificaDti($login) == 1) {
                    $_SESSION['dti'] = true;
                } else {
                    $_SESSION['dti'] = false;
                }
                $_SESSION['cpf'] = $login;
                $_SESSION['usuario'] = $nomeId[0];
                $_SESSION['usuarioId'] = $nomeId[1];
                
                if ($_SESSION['dti']) {
                    header ('Location: home.php');
                } else {
                    header ('Location: content\solicitacao\minhasSolicitacoes.php');
                }
                exit();
            } else {
                $_SESSION['nao_autenticado'] = true;
                header('Location: index.php');
                exit();
            }
        }

    }