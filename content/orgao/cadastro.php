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
    <title>Cadastro de Órgãos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include ($path . "menu.php");

        include($path . "verificaDti.php");

        include ($controllerPath . "orgao_controller.php");

        $orgaoController = new OrgaoController;

        if(@$_REQUEST['id']) {
            $orgao = $orgaoController->buscaOrgao();
            $id = $orgao->getId();
            $nome = $orgao->getNome();
            $ativo = $orgao->getAtivo();
            $dataCricacao = $orgao->getDataCriacao();
            $dataDesativo = $orgao->getDataDesativo();
        }

        if (isset($_POST['nome'])){
            if(@$_REQUEST['id'] == null) {
                $orgaoController->cadastraOrgao();
            } else {
                $orgaoController->atualizaOrgao();
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