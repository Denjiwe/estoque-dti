<?php

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include ($entityPath . "divisao.php");

    include ($modelPath . "divisao_model.php");

    class DivisaoController 
    {

        /* ========================================================= Cadastro ========================================================= */
        


        function buscaDivisao() {
            $model = new DivisaoModel;
            $divisao = new Divisao;
            $id = $_GET['id'];

            $divisao = $model->findById($id);

            return $divisao;
        }

        function cadastraDivisao() {
            $model = new DivisaoModel;

            $newDivisao = new Divisao;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $newNome = $_POST['nome'];
            $newAtivo = $ativoOk;
            $newDataCriacao = $_POST['dataCriacao'];
            $newDataDesativo = $_POST['dataDesativado'];
            $newDataDesativoOk = strlen($newDataDesativo) > 0 ? $newDataDesativo : null;
            $newDiretoriaId = $_POST['diretoria'];

            $newDivisao->setNome($newNome);
            $newDivisao->setAtivo($newAtivo);
            $newDivisao->setDataCriacao($newDataCriacao);
            $newDivisao->setDataDesativo($newDataDesativoOk);
            $newDivisao->setDiretoriaId($newDiretoriaId);

            try {
                $model->insert($newDivisao);
                echo "<div class='container alert alert-success mt-5'>Registro criado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a divisão, pois uma de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a divisão! Erro de banco de dados.</div>";
                }
            }
        }

        function atualizaDivisao() {
            $model = new DivisaoModel;

            $divisao = new Divisao;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $nome = $_POST['nome'];
            $ativo = $ativoOk;
            $dataCriacao = $_POST['dataCriacao'];
            $dataDesativo = $_POST['dataDesativado'];
            $dataDesativoOk = strlen($dataDesativo) > 0 ? $dataDesativo : null;
            $id = $_REQUEST['id'];
            $diretoriaId = $_POST['diretoria'];

            $divisao->setNome($nome);
            $divisao->setAtivo($ativo);
            $divisao->setDataCriacao($dataCriacao);
            $divisao->setDataDesativo($dataDesativoOk);
            $divisao->setDiretoriaId($diretoriaId);
            $divisao->setId($id);          

            try {
                $model->update($divisao);
                echo "<div class='container alert alert-success mt-5'>Registro atualizado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a divisão, pois uma de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a divisão! Erro de banco de dados.</div>";
                }
            }
        }

        function exibeDiretorias(){
            $model = new DivisaoModel;

            $diretorias = $model->getDiretorias();

            if (isset($_GET['id'])){
                $divisao = $this->buscaDivisao();

                print "<option value=".$divisao->getDiretoriaId()." selected>".$divisao->getDiretoriaNome()."</option>";

                foreach ($diretorias as $diretoria) {
                    if ($diretoria['id'] !== $divisao->getDiretoriaId()){
                        print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                    }
                }
            } else {
                print "<option hidden selected></option>";

                foreach ($diretorias as $diretoria) {
                    print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                }
            }
        }

        /* ========================================================= Pesquisa ========================================================= */



        function excluiDivisao() {
            try{
                $model = new DivisaoModel;
                $model ->delete($_GET["delete"]);
                echo "<div class='alert alert-success'>Registro excluído com sucesso</div>";
            } catch (PDOException $e) {
                echo "Não foi possível excluir o registro: ". $e->getMessage();
            }
        }

        function exibePesquisa() {
            $model = new DivisaoModel;
                    
                    $pesquisa = $_GET['pesquisa'];

                    $divisao = $model->findByName($pesquisa);

                    print "<h1>Divisões cadastradas com nome: \"".$pesquisa."\"</h1>";

                    if ($divisao == null ) {
            ?>            
                        <h3>Nenhuma divisao encontrada!</h3>
                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    } else {
                        $dataCriacao = new DateTime($divisao->getDataCriacao());
                        @$dataDesativo = new DateTime($divisao->getDataDesativo());
            ?>            
                        <table class=' container table table-hover table-striped table-bordered text-center'>

                        <tr>
                        <th style='display:none;'>id</th>
                        <th>Nome</th>
                        <th>Ativo</th>
                        <th>Data de Criação</th>
                        <th>Data de Desativação</th>
                        <th>Diretoria</th> 
                        <th>Ações</th>
                        </tr>
                    
                        <tr>
                        <td style='display:none;'><?=$divisao->getId()?></td>
                        <td><?=$divisao->getNome()?></td>
                        <td><?=($divisao->getAtivo() ? 'Sim' : 'Não')?></td>
                        <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                        <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Divisão Ativa")?></td>
                        <td><?=$divisao->getDiretoriaNome()?></td>
                        <td>
                            <a href="cadastro.php?id=<?=$divisao->getId()?>" class='btn btn-success'>Editar</a>
                            <a href="pesquisar.php?delete=<?=$divisao->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                        </td>
                        </tr>
                    
                        </table>

                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    }
        }

        function exibeDivisao() {
            
            ?>        
                    <h1>Divisões cadastradas</h1>

                    <table class=' container table table-hover table-striped table-bordered text-center'>

                    <tr>
                    <th style='display:none;'>#</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Data de Criação</th>
                    <th>Data de Desativação</th>
                    <th>Diretoria</th>
                    <th>Ações</th>
                    </tr>
            <?php        

                    $model = new DivisaoModel;

                    $divisao = $model->select();
                    
                    foreach ($divisao as $obj) {
                        $dataCriacao = new DateTime($obj->getDataCriacao());
                        if ($obj->getDataDesativo() == null){
                            $dataDesativo = null;
                        } else {
                            $dataDesativo = new DateTime($obj->getDataDesativo());
                        }
            ?>            
                        <tr>
                        <td style='display:none;'><?=$obj->getId()?></td>
                        <td><?=$obj->getNome()?></td>
                        <td><?=($obj->getAtivo() ? 'Sim' : 'Não')?></td>
                        <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                        <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Divisão Ativa")?></td>
                        <td><?=$obj->getDiretoriaNome()?></td>
                        <td>
                            <a href="cadastro.php?id=<?=$obj->getId()?>" class='btn btn-success'>Editar</a>
                            <a href="pesquisar.php?delete=<?=$obj->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                        </td>
                        </tr>
            <?php            
                    }
                    print "</table>";
        }
    }
?>