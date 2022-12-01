<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        include ($path . "menu.php");

        include ("../../entity/orgao.php");

        include ("../../model/orgao_model.php");

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
                echo "Não foi possível excluir o registro: ". $e->getMessage();
            }
        }

        
        if (isset($_POST['nome'])){
            if(@$_REQUEST['id'] != null) {
                $new_model = new OrgaoModel;

                $new_orgao = new Orgao;

                $ativoOk = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativoOk = 1;
                }
                $new_nome = $_POST['nome'];
                $new_ativo = $ativoOk;
                $new_dataCriacao = $_POST['dataCricao'];
                $new_dataDesativo = $_POST['dataDesativado'];
                $new_dataDesativoOk = strlen($new_dataDesativo) > 0 ? $new_dataDesativo : null;
                $new_id = $_REQUEST['id'];

                $new_orgao->setNome($new_nome);
                $new_orgao->setAtivo($new_ativo);
                $new_orgao->setDataCriacao($new_dataCriacao);
                $new_orgao->setDataDesativo($new_dataDesativoOk);
                $new_orgao->setId($new_id);          

                try {
                    $new_model->update($new_orgao);
                    echo "<div class='alert alert-success'>Registro atualizado com sucesso!</div>";
                } catch (PDOException $e) {
                    echo "Não foi possível atualizar o registro: ". $e->getMessage();
                }    
            } else {
                $new_model = new OrgaoModel;

                $new_orgao = new Orgao;

                $ativoOk = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativoOk = 1;
                }
                $new_nome = $_POST['nome'];
                $new_ativo = $ativoOk;
                $new_dataCriacao = $_POST['dataCricao'];
                $new_dataDesativo = $_POST['dataDesativado'];
                $new_dataDesativoOk = strlen($new_dataDesativo) > 0 ? $new_dataDesativo : null;

                $new_orgao->setNome($new_nome);
                $new_orgao->setAtivo($new_ativo);
                $new_orgao->setDataCriacao($new_dataCriacao);
                $new_orgao->setDataDesativo($new_dataDesativoOk);

                try {
                    $new_model->insert($new_orgao);
                    echo "<div class='alert alert-success'>Registro criado com sucesso!</div>";
                } catch (PDOException $e) {
                    echo "Não foi possível cadastrar o registro: ". $e->getMessage();
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

</body>
</html>