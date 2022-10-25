<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <link rel="stylesheet" href="./css/index.css">

    <script type="text/javascript">
            $.ajax({
                url: './controller/select.php',
                type: "POST"
            }).done(function(resposta) {
                $('#registros').html(resposta);

            }).fail(function(jqXHR, textStatus ) {
                console.log("Request failed: " + textStatus);

            });
    </script>
    
</head>
<body>
<?php
 include_once ("./model/orgao_model.php");
 include_once ("./entity/orgao.php");

 $org = new Orgao;
 /*$org->setNome("RH");
 $org->setAtivo(1);
 $org->setDataCriacao("2022-05-10");
 $org->setDataDesativo(null);
 
 $org->setId(2);

 $model = new OrgaoModel(); 
 $model->delete($org->getId());*/

 return;
?>
    <main class="container mt-5">
        <form action="./controller/insert.php" method="post" id="formInsert">
            <div class="form-group">
                <label for="modeloProduto">Nome do Produto</label> 
                <input type="text" id="modeloProduto" maxlength="45" class="form-control" name="modelo" placeholder="Insira o nome do produto" required>
            </div>

            <div class="form-group mt-5">
                <label for="descricao">Descrição do Produto</label>
                <textarea id="descricao" maxlength="300" cols="30" rows="5" class="form-control" name="descricao" placeholder="Insira a descrição do produto"> </textarea>
            </div>

            <div class="form-group col-3 mt-5">
                <label for="qntde">Quantidade em Estoque</label> 
                <input type="number" id="qntde" class="form-control" name="qntde" required>
            </div>

            <div class="form-group mt-5">
                <label for="ativo">Ativo?</label> 
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input">
            </div>

            <button type="submit" class="btn btn-primary mt-5">Cadastrar</button>

        </form>

        <h2 class="mt-5">Produtos cadastrados</h2>

        <div class="mb-5" id="registros">
            

        </div>

        <div class="row">
            <div class="col mt-5">
                <?php
                    include("./controller/config.php");
                    switch(@$_REQUEST["page"]){
                        case "editar":
                            include("editar_produto.php");
                            break;
                        case "excluir":
                            include("./controller/delete.php");
                            break;
                    }
                ?>
            </div>
        </div>

    </main>
    
</body>
</html>