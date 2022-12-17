<?php

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include ($entityPath . "orgao.php");

    include ($modelPath . "orgao_model.php");
    
    class OrgaoController
    {

        /* ========================================================= Cadastro ========================================================= */


        
        // cadastraOrgao
        function cadastraOrgao() { 
            
            $newModel = new OrgaoModel;

            $newOrgao = new Orgao;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $newNome = $_POST['nome'];
            $newAtivo = $ativoOk;
            $newDataCriacao = $_POST['dataCricao'];
            $newDataDesativo = $_POST['dataDesativado'];
            $newDataDesativoOk = strlen($newDataDesativo) > 0 ? $newDataDesativo : null;

            $newOrgao->setNome($newNome);
            $newOrgao->setAtivo($newAtivo);
            $newOrgao->setDataCriacao($newDataCriacao);
            $newOrgao->setDataDesativo($newDataDesativoOk);

            try {
                $newModel->insert($newOrgao);
                echo "<div class='container alert alert-success mt-5'>Registro criado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar o ógão, pois um de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar o ógão! Erro de banco de dados.</div>";
                }
            }  
        }

        // atualizaOrgao
        function atualizaOrgao() {
            $model = new OrgaoModel;

            $orgao = new Orgao;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $nome = $_POST['nome'];
            $ativo = $ativoOk;
            $dataCriacao = $_POST['dataCricao'];
            $dataDesativo = $_POST['dataDesativado'];
            $dataDesativoOk = strlen($dataDesativo) > 0 ? $dataDesativo : null;
            $id = $_REQUEST['id'];

            $orgao->setNome($nome);
            $orgao->setAtivo($ativo);
            $orgao->setDataCriacao($dataCriacao);
            $orgao->setDataDesativo($dataDesativoOk);
            $orgao->setId($id);          

            try {
                $model->update($orgao);
                echo "<div class='container alert alert-success mt-5'>Registro atualizado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar o órgão, pois um de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar o órgão! Erro de banco de dados.</div>";
                }
            }
        }

        //buscaOrgao
        function buscaOrgao() {
            try {
                $model = new OrgaoModel;
                $orgao = new Orgao;

                $orgao = $model->findById($_REQUEST['id']);

                return $orgao;

            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
        }



        /* ========================================================= Pesquisa ========================================================= */



        //exibePesquisa
        function exibePesquisa() {
            $model = new OrgaoModel;
                    
            $pesquisa = $_GET['pesquisa'];

            $orgao = $model->findByName($pesquisa);

            print "<h1>Órgãos cadastrados com nome: \"".$pesquisa."\"</h1>";

            if ($orgao == null ) {
            ?>            
                <h3>Nenhum órgão encontrado!</h3>
                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            } else {
                $dataCriacao = new DateTime($orgao->getDataCriacao());
            ?>            
                <table class='container table table-hover table-striped table-bordered text-center'>

                <tr>
                <th style='display:none;'>id</th>
                <th>Nome</th>
                <th>Ativo</th>
                <th>Data de Criação</th>
                <th>Data de Desativação</th>
                <th>Ações</th>
                </tr>
            
                <tr>
                    <td style='display:none;'><?=$orgao->getId()?></td>
                    <td><?=$orgao->getNome()?></td>
                    <td><?=($orgao->getAtivo() ? 'Sim' : 'Não')?></td>
                    <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                    <td><?=$orgao->getDataDesativo()?></td>
                    <td>
                        <a href="cadastro.php?id=<?=$orgao->getId()?>" class='btn btn-success'>Editar</a>
                        <a href="pesquisar.php?delete=<?=$orgao->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                    </td>
                </tr>
            
                </table>

                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            }
        }

        // exibeOrgaos
        function exibeOrgaos() {
            ?>        
                <h1>Órgãos cadastrados</h1>

                <table class='container table table-hover table-striped table-bordered text-center'>

                <tr>
                <th style='display:none;'>#</th>
                <th>Nome</th>
                <th>Ativo</th>
                <th>Data de Criação</th>
                <th>Data de Desativação</th>
                <th>Ações</th>
                </tr>
            <?php        

                $model = new OrgaoModel;

                $orgao = $model->select();
                
                foreach ($orgao as $obj) {
                    $dataCriacao = new DateTime($obj->getDataCriacao());
            ?>            
                    <tr>
                    <td style='display:none;'><?=$obj->getId()?></td>
                    <td><?=$obj->getNome()?></td>
                    <td><?=($obj->getAtivo() ? 'Sim' : 'Não')?></td>
                    
                    <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                    <td><?=$obj->getDataDesativo()?></td>

                    <td>
                        <a href="cadastro.php?id=<?=$obj->getId()?>" class='btn btn-success'>Editar</a>
                        <a href="pesquisar.php?delete=<?=$obj->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                    </td>
                    </tr>
            <?php            
                }
                print "</table>";
        }

        // excluiOrgao
        function excluiOrgao() {
            try{
                $model = new OrgaoModel;
                $model ->delete($_REQUEST["delete"]);
                echo "<div class='alert alert-success'>Registro excluído com sucesso</div>";
            } catch (PDOException $e) {
                echo "Não foi possível excluir o registro: ". $e->getMessage();
            }
        }
    }

?>
    