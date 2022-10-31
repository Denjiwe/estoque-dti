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
        include ("../../entity/produto.php");

        include ("../../model/produto_model.php");

        if(@$_REQUEST['id']) {
            try {
                $model = new ProdutoModel;
                $produto = new Produto;

                $produto = $model->findById($_REQUEST['id']);
                $id = $produto->getId();
                $modelo = $produto->getModelo();
                $ativo = $produto->getAtivo();
                $descricao = $produto->getDescricao();
                $qntde = $produto->getQntde();

            } catch (PDOException $e) {
                echo "Não foi possível excluir o registro: ". $e->getMessage();
            }
        }

        
        if (isset($_POST['modelo'])){
            if(@$_REQUEST['id'] != null) {
                $new_model = new ProdutoModel;

                $new_produto = new Produto;

                $ativook = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativook = 1;
                }
                $new_modelo = $_POST['modelo'];
                $new_ativo = $ativook;
                $new_descricao = $_POST['descricao'];
                $new_qntde = $_POST['qntde'];
                $new_id = $_REQUEST['id'];

                $new_produto->setModelo($new_modelo);
                $new_produto->setAtivo($new_ativo);
                $new_produto->setDescricao($new_descricao);
                $new_produto->setQntde($new_qntde);
                $new_produto->setId($new_id);          

                try {
                    $new_model->update($new_produto);
                    echo "<div class='alert alert-success'>Registro atualizado com sucesso!</div>";
                } catch (PDOException $e) {
                    echo "Não foi possível atualizar o registro: ". $e->getMessage();
                }    
            } else {
                $new_model = new ProdutoModel;

                $new_produto = new Produto;

                $ativook = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativook = 1;
                }
                $new_modelo = $_POST['modelo'];
                $new_ativo = $ativook;
                $new_descricao = $_POST['descricao'];
                $new_qntde = $_POST['qntde'];

                $new_produto->setModelo($new_modelo);
                $new_produto->setAtivo($new_ativo);
                $new_produto->setDescricao($new_descricao);
                $new_produto->setQntde($new_qntde);

                try {
                    $new_model->insert($new_produto);
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
                <label for="modelo">Modelo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="modelo" id="modelo" 
                    <?php if(isset($produto)) {
                        echo "value=\"".$modelo."\"";
                        }
                    ?>
                placeholder="insira o modelo do produto" required>
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
                <label for="descricao">Descrição <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="descricao"
                    <?php if(isset($produto)) {
                        echo "value=\"".$descricao."\"";
                        }
                    ?>
                id="descricao" required>
            </div>

            <div class="form-group mt-5">
                <label for="qntde">Quantidade</label>
                <input type="number" class="form-control" name="qntde"
                    <?php if(isset($produto)) {
                        echo "value=\"".$qntde."\"";
                        }
                    ?> 
                id="qntde">
            </div>

            <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-light mt-5">Cancelar</a>
        </form>
    </main>

</body>
</html>