<?php
    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include ($entityPath . "diretoria.php");

    include ($modelPath . "diretoria_model.php");

    class DiretoriaController
    {

        /* ========================================================= Cadastro ========================================================= */
        


        function cadastraDiretoria() {
            $model = new DiretoriaModel;

            $newDiretoria = new Diretoria;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $newNome = $_POST['nome'];
            $newAtivo = $ativoOk;
            $newDataCriacao = $_POST['dataCriacao'];
            $newDataDesativo = $_POST['dataDesativado'];
            $newDataDesativoOk = strlen($newDataDesativo) > 0 ? $newDataDesativo : null;
            $newOrgaoId = $_POST['orgao'];

            $newDiretoria->setNome($newNome);
            $newDiretoria->setAtivo($newAtivo);
            $newDiretoria->setDataCriacao($newDataCriacao);
            $newDiretoria->setDataDesativo($newDataDesativoOk);
            $newDiretoria->setOrgaoId($newOrgaoId);

            try {
                $model->insert($newDiretoria);
                echo "<div class='container alert alert-success mt-5'>Registro criado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a diretoria, pois uma de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a diretoria! Erro de banco de dados.</div>";
                }
            }
        }

        function atualizaDiretoria() {
            $model = new DiretoriaModel;

            $diretoria = new Diretoria;

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
            $orgaoId = $_POST['orgao'];

            $diretoria->setNome($nome);
            $diretoria->setAtivo($ativo);
            $diretoria->setDataCriacao($dataCriacao);
            $diretoria->setDataDesativo($dataDesativoOk);
            $diretoria->setOrgaoId($orgaoId);
            $diretoria->setId($id);          

            try {
                $model->update($diretoria);
                echo "<div class='container alert alert-success mt-5'>Registro atualizado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Nome")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a diretoria, pois uma de mesmo nome já existe!</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a diretoria! Erro de banco de dados.</div>";
                }
            }   
        }

        function buscaDiretoria() {
            $model = new DiretoriaModel;

            $diretoria = new Diretoria;
            $id = $_GET['id'];

            $diretoria = $model->findById($id);

            return $diretoria;
        }

        function exibeOrgaos() {
            $model = new DiretoriaModel;

            $orgaos = $model->getOrgaos();

            if (isset($_GET['id'])){
                $diretoria = $this->buscaDiretoria();

                print "<option value=".$diretoria->getOrgaoId()." selected>".$diretoria->getOrgaoNome()."</option>";

                foreach ($orgaos as $orgao) {
                    if ($orgao['id'] !== $diretoria->getOrgaoId()){
                        print "<option value=\"".$orgao['id']."\">".$orgao['nome']."</option>";
                    }
                }
            } else {
                print "<option hidden selected></option>";

                foreach ($orgaos as $orgao) {
                    print "<option value=\"".$orgao['id']."\">".$orgao['nome']."</option>";
                }
            }
        }

        /* ========================================================= Pesquisa ========================================================= */



        function excluiDiretoria () {
            try{
                $model = new DiretoriaModel;
                $model ->delete($_GET["delete"]);
                echo "<div class='container alert alert-success mt-5'>Registro excluído com sucesso</div>";
            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível excluir o registro! Erro de banco de dados</div>";
            }
        }

        function exibePesquisa() {
            $model = new DiretoriaModel;
                    
            $pesquisa = $_GET['pesquisa'];

            $diretoria = $model->findByName($pesquisa);

            print "<h1>Diretorias cadastradas com nome: \"".$pesquisa."\"</h1>";

            if ($diretoria == null ) {
            ?>            
                <h3>Nenhuma diretoria encontrada!</h3>
                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            } else {
                $dataCriacao = new DateTime($diretoria->getDataCriacao());
                if ($diretoria->getDataDesativo() == null){
                    $dataDesativo = null;
                } else {
                    $dataDesativo = new DateTime($diretoria->getDataDesativo());
                }
            ?>            
                <table class='container table table-hover table-striped table-bordered text-center'>

                <tr>
                <th style='display:none;'>id</th>
                <th>Nome</th>
                <th>Ativo</th>
                <th>Data de Criação</th>
                <th>Data de Desativação</th>
                <th>Órgão</th> 
                <th>Ações</th>
                </tr>
            
                <tr>
                <td style='display:none;'><?=$diretoria->getId()?></td>
                <td><?=$diretoria->getNome()?></td>
                <td><?=($diretoria->getAtivo() ? 'Sim' : 'Não')?></td>
                <td><?=date_format($dataCriacao, "d/m/Y")?></td>
                <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Diretoria Ativa")?></td>
                <td><?=$diretoria->getOrgaoNome()?></td>
                <td>
                    <a href="cadastro.php?id=<?=$diretoria->getId()?>" class='btn btn-success'>Editar</a>
                    <a href="pesquisar.php?delete=<?=$diretoria->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                </td>
                </tr>
            
                </table>

                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            }
        }

        function exibeDiretoria() {
            ?>        
                    <h1>Diretorias cadastradas</h1>

                    <table class=' container table table-hover table-striped table-bordered text-center'>

                    <tr>
                    <th style='display:none;'>#</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Data de Criação</th>
                    <th>Data de Desativação</th>
                    <th>Órgão</th>
                    <th>Ações</th>
                    </tr>
            <?php        

                    $model = new DiretoriaModel;

                    $diretoria = $model->select();
                    
                    foreach ($diretoria as $obj) {
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
                        <td><?=($dataDesativo != null ? date_format($dataDesativo, "d/m/Y") : "Diretoria Ativa")?></td>
                        <td><?=$obj->getOrgaoNome()?></td>
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