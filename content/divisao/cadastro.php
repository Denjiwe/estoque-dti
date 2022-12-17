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

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include ($controllerPath . "divisao_controller.php");

        include ($path . "menu.php");

        include ($path . "verificaDti.php");

        $divisaoController = new DivisaoController;

        if (isset($_GET['id'])) {
            try {
                //retorna $divisao
                $divisao = $divisaoController->buscaDivisao();

                $ativo = $divisao->getAtivo();

            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
        }

        if (isset($_POST['nome'])){
            if(@$_REQUEST['id'] != null) {
                $divisaoController->atualizaDivisao();    
            } else {
                $divisaoController->cadastraDivisao();
            }
        }
    ?>
    <main class="container mt-5">

        <p>nota: como cadastro de órgãos, divisaos e divisões é pequeno, criar modal na tela de cadastro para criação
        dos mesmos, claro isso depois da crição da controller, para o código não ficar muito grande</p>

        <form action="cadastro.php" method="post" id="formCadastro">
            
            <input type="hidden" name="id" 
                <?php 
                    if(isset($_GET['id'])) {
                        echo "value=\"".$_GET['id']."\"";
                    } else {
                        echo "value=\"".null."\"";
                    }
                ?>
            >

            <div class="row">
                <div class="form-group col-5">
                    <label for="nome">Nome <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nome" id="nome" 
                        <?php if(isset($divisao)) {
                            echo "value=\"".$divisao->getNome()."\"";
                            }
                        ?>
                    placeholder="insira o nome da divisao" required>
                </div>

                <div class="form-group col-5">
                    <label for="diretoria">Selecione a diretoria da divisão <span class="text-danger">*</span></label>
                    <select class="form-select" name="diretoria" id="diretoria" required>
                        <?php
                            $divisaoController->exibeDiretorias();
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-5 mt-5">
                    <label for="dataCriacao">Data de Criação <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="dataCriacao"
                        <?php if(isset($divisao)) {
                            echo "value=\"".$divisao->getDataCriacao()."\"";
                            }
                        ?>
                    id="dataCriacao" required>
                </div>

                <div class="form-group col-5 mt-5">
                    <label for="dataDesativado">Data de Desativação</label>
                    <input type="date" class="form-control" name="dataDesativado"
                        <?php if(isset($divisao)) {
                            echo "value=\"".$divisao->getDataDesativo()."\"";
                            }
                        ?> 
                    id="dataDesativado">
                </div>
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

            <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-light mt-5">Cancelar</a>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>