<?php

    $databasePath = $_SERVER['DOCUMENT_ROOT'] . "/database//";

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    include_once ($databasePath . "config.php");

    include_once ($entityPath . "solicitacao.php");
    
    class SolicitacaoModel {

        //delete
        function delete(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("DELETE FROM solicitacao WHERE id = :id");
            $con->bindParam("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        //insert
        function insert (Solicitacao $solicitacao) {

            $conexao = Conexao::getConexao();

            try {
            $local = $this->findLocalUsuario($_SESSION['usuarioId']);

            if ($local['divisao_id'] == null) {

                $conexao->beginTransaction();
                $con = $conexao->prepare("INSERT INTO solicitacao (estado_solicitacao, descricao, data_solicitacao, usuario_id, diretoria_id) 
                VALUES (:estado, :descricao, now(), :usuario_id, :diretoria)");
                $con->bindValue ("estado", $solicitacao->getEstadoSolicitacao(), PDO::PARAM_STR);
                $con->bindValue ("descricao", $solicitacao?->getDescricao(), PDO::PARAM_STR);
                $con->bindValue ("usuario_id", $_SESSION['usuarioId'], PDO::PARAM_INT);
                $con->bindValue ("diretoria", $local['diretoria_id'], PDO::PARAM_INT);
                $con->execute();

            } else {

                $conexao->beginTransaction();
                $con = $conexao->prepare("INSERT INTO solicitacao (estado_solicitacao, descricao, data_solicitacao, usuario_id, divisao_id) 
                VALUES (:estado, :descricao, now(), :usuario_id, :divisao)");
                $con->bindValue ("estado", $solicitacao->getEstadoSolicitacao(), PDO::PARAM_STR);
                $con->bindValue ("descricao", $solicitacao?->getDescricao(), PDO::PARAM_STR);
                $con->bindValue ("usuario_id", $_SESSION['usuarioId'], PDO::PARAM_INT);
                $con->bindValue ("divisao", $local['divisao_id'], PDO::PARAM_INT);
                $con->execute();

            }
            
            
            $lastId = $conexao->lastInsertId();
            $itens = $solicitacao->getItemSolicitacao();
            $qntde = $solicitacao->getQntdeItem();
            
            $cont = 0;
            foreach ($itens as $item) {
                $solicitados = $conexao->prepare("INSERT INTO itens_solicitacao (solicitacao_id, produto_id, qntde_item) VALUES (:solicitacao, :produto, :qntde)");
                $solicitados->bindValue("solicitacao", $lastId, PDO::PARAM_INT);
                $solicitados->bindValue("produto", $item, PDO::PARAM_INT);
                $solicitados->bindValue("qntde", $qntde[$cont], PDO::PARAM_INT);
                $solicitados->execute();

                $cont++;
            }

            $conexao->commit();

            } catch (PDOException $e) {
                $conexao->rollBack();
                throw $e;

            }           
        }

        //select all
        function select (bool $atendidos) {
            $conexao = Conexao::getConexao();

            if ($atendidos) {
                $con = $conexao->prepare("SELECT solicitacao.* ,usuario.nome from solicitacao inner join usuario on usuario_id = usuario.id where estado_solicitacao = 'Atendido' order by id asc");
            } else {
                $con = $conexao->prepare("SELECT solicitacao.* ,usuario.nome from solicitacao inner join usuario on usuario_id = usuario.id where estado_solicitacao != 'Atendido' order by id asc");
            }
            $con->execute();
            
            $solicitacoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {


            $solicitacao = new Solicitacao;
            $solicitacao->setId($linha['id']);
            $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
            $solicitacao->setDescricao($linha['descricao']);
            $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
            $solicitacao->setUsuarioId($linha['usuario_id']);
            $solicitacao->setUsuarioNome($linha['nome']);

            if ($linha['divisao_id'] == null) {
                $solicitacao->setUsuarioDiretoria($linha['diretoria_id']);
                $solicitacao->setUsuarioDivisao(0);
            } else {
                $solicitacao->setUsuarioDivisao($linha['divisao_id']);
                $solicitacao->setUsuarioDiretoria(0);
            }

            $solicitacoes[] = $solicitacao; 
            
            }

            return $solicitacoes;
            
        }

        //selectUsuario
        function selectUsuario () {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select solicitacao.* ,usuario.nome from solicitacao inner join usuario on usuario_id = usuario.id where usuario_id = :usuario order by id desc");
            $con->bindValue("usuario", $_SESSION['usuarioId'], PDO::PARAM_INT);
            $con->execute();
            
            $solicitacoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

            $solicitacao = new Solicitacao;
            $solicitacao->setId($linha['id']);
            $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
            $solicitacao->setDescricao($linha['descricao']);
            $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
            $solicitacao->setUsuarioId($linha['usuario_id']);
            $solicitacao->setUsuarioNome($linha['nome']);

            if ($linha['divisao_id'] == null) {
                $solicitacao->setUsuarioDiretoria($linha['diretoria_id']);
                $solicitacao->setUsuarioDivisao(0);
            } else {
                $solicitacao->setUsuarioDivisao($linha['divisao_id']);
                $solicitacao->setUsuarioDiretoria(0);
            }

            $solicitacoes[] = $solicitacao; 
            
            }

            return $solicitacoes;
            
        }

        //findLocalUsuario 
        function findLocalUsuario(int $usuarioId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT divisao_id ,diretoria_id FROM usuario WHERE id = :id");
            $con->bindValue("id", $usuarioId, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $local = $linha;
            }

            return $local;
        }
        
        //findById
        function findById (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT solicitacao.*, usuario.nome FROM solicitacao inner join usuario on usuario_id = usuario.id WHERE solicitacao.id = :id");
            $con->bindValue ("id", $id, PDO::PARAM_INT);
            $con->execute();

            $solicitacoes = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {

                $solicitacao = new Solicitacao;
                $solicitacao->setId($linha['id']);
                $solicitacao->setEstadoSolicitacao($linha['estado_solicitacao']);
                $solicitacao->setDescricao($linha['descricao']);
                $solicitacao->setDataSolicitacao($linha['data_solicitacao']);
                $solicitacao->setUsuarioId($linha['usuario_id']);
                $solicitacao->setUsuarioNome($linha['nome']);

                if ($linha['divisao_id'] == null) {
                    $solicitacao->setUsuarioDiretoria($linha['diretoria_id']);
                    $solicitacao->setUsuarioDivisao(0);
                } else {
                    $solicitacao->setUsuarioDivisao($linha['divisao_id']);
                    $solicitacao->setUsuarioDiretoria(0);
                }

                $solicitacoes[] = $solicitacao; 

            }

            return $solicitacoes;
        }

        function selectItemSolicitacao(int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select produto.id, produto.modelo_produto, itens_solicitacao.id as is_id, itens_solicitacao.qntde_item from produto inner join itens_solicitacao
            on itens_solicitacao.produto_id = produto.id where itens_solicitacao.solicitacao_id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            $itens = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $item['id'] = $linha['id']; 
                $item['is_id'] = $linha['is_id']; 
                $item['qntde_item'] = $linha['qntde_item']; 
                $item['modelo_produto'] = $linha['modelo_produto']; 
                
                $itens[] = $item;
            }
            return $itens;
        }

        function updateEstado(string $estado, int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("update solicitacao set estado_solicitacao = :estado where id = :id");
            $con->bindValue("estado", $estado, PDO::PARAM_STR);
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();
        }

        //getDivisaoNome
        function getDivisaoNome($divisaoId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM divisao WHERE id = :id");
            $con->bindValue("id", $divisaoId, PDO::PARAM_INT);
            $con->execute();

            $divisao = $con->fetch(PDO::FETCH_ASSOC);

            return $divisao;
        }

        //getDiretoriaNome
        function getDiretoriaNome($diretoriaId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT nome FROM diretoria WHERE id = :id");
            $con->bindValue("id", $diretoriaId, PDO::PARAM_INT);
            $con->execute();

            $diretoria = $con->fetch(PDO::FETCH_ASSOC);

            return $diretoria;
        }

        //comparaEntrega
        function comparaEntrega($solicitacaoId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT entrega.qntde, entrega.data_entrega, entrega.id, itens_solicitacao.id as is_id, itens_solicitacao.solicitacao_id, itens_solicitacao.produto_id FROM entrega 
            INNER JOIN itens_solicitacao ON entrega.itens_solicitacao_id = itens_solicitacao.id WHERE itens_solicitacao.solicitacao_id = :id");
            $con->bindValue("id", $solicitacaoId, PDO::PARAM_INT);
            $con->execute();

            $entregues = [];

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $entregue['id'] = $linha['id'];
                $entregue['qntdeEntregue'] = $linha['qntde'];
                $entregue['dataEntregue'] = $linha['data_entrega'];
                $entregue['solicitacaoId'] = $linha['solicitacao_id'];
                $entregue['is_id'] = $linha['is_id'];
                $entregue['produtoId'] = $linha['produto_id'];

                $entregues[] = $entregue;
            }

            return $entregues;
        }

        //getEstoque
        function getEstoque (int $id) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("select qntde_estoque from produto where id = :id");
            $con->bindValue("id", $id, PDO::PARAM_INT);
            $con->execute();

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $qntde = $linha['qntde_estoque'];
            }

            return $qntde;
        }

        //verificaQntdeSolicitado 
        function verificaQntdeSolicitado(int $produtoId) {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT qntde_item FROM itens_solicitacao WHERE produto_id = :id");
            $con->bindValue("id", $produtoId, PDO::PARAM_INT);
            $con->execute();

            $qntde = 0;

            while ($linha = $con->fetch(PDO::FETCH_ASSOC)) {
                $qntde += $linha['qntde_item'];
            }   

            return $qntde;
        }

        //LastId 
        function LastId() {
            $conexao = Conexao::getConexao();
            $con = $conexao->prepare("SELECT id from solicitacao order by id desc");
            $con->execute();

            $id = $con->fetch(PDO::FETCH_ASSOC); 
            return $id;
        }
    }   