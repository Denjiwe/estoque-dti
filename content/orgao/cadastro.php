<?php
    session_start();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include($path . "verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        include ($path . "menu.php");

        include($path . "verificaDti.php");

        include ($entityPath . "orgao.php");

        include ($modelPath . "orgao_model.php");

        if(@$_REQUEST['id']) {
            try {
                $model = new OrgaoModel;
                $orgao = new Orgao;

                $orgao = $model->findById($_REQUEST['id']);
                $id = $orgao->getId();
                $nome = $orgao->getNome();
                $ativo = $orgao->getAtivo();
                $dataCricacao = $orgao->getDataCriacao();
                $dataDesativo = $orgao->getDataDesativo();

            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
        }

        
        if (isset($_POST['nome'])){
            if(@$_REQUEST['id'] != null) {
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
            } else {
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
        }
    ?>
    <main class="container mt-5">
        <form action="cadastro.php" method="post" id="formCadastro">
            
            <input type="hidden" name="id" 
                <?php 
                    if(@$_REQUEST['id']) {
                        echo "value=\"".$_REQUEST['id']."\"";
                    } else {
                        echo "value=\"".null."\"";
                    }
                ?>
            >

            <div class="form-group">
                <label for="nome">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nome" id="nome" 
                    <?php if(isset($orgao)) {
                        echo "value=\"".$nome."\"";
                        }
                    ?>
                placeholder="insira o nome do órgão" required>
            </div>

            <div class="form-group mt-5">
                <label for="ativo">Ativo?</label> 
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input" 
                    <?php if (isset($ativo)){
                        if ($ativo ==  1) {
                            echo "checked";
                        }
                    }
                    ?>
                >
            </div>

            <div class="form-group mt-5">
                <label for="dataCricao">Data de Criação <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="dataCricao"
                    <?php if(isset($orgao)) {
                        echo "value=\"".$dataCricacao."\"";
                        }
                    ?>
                id="dataCriacao" required>
            </div>

            <div class="form-group mt-5">
                <label for="dataDesativado">Data de Desativação</label>
                <input type="date" class="form-control" name="dataDesativado"
                    <?php if(isset($orgao)) {
                        echo "value=\"".$dataDesativo."\"";
                        }
                    ?> 
                id="dataDesativado">
            </div>

            <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-light mt-5">Cancelar</a>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>