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

        include ($entityPath . "produto.php");

        include ($modelPath . "produto_model.php");

        include_once ($path . "menu.php");


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

                $suprimentos = $model->getSuprimentos($_REQUEST['id']);

            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
        }

        //atualizar produto
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
                $itens = $_POST['produtosVinculados'];

                $new_produto->setModelo($new_modelo);
                $new_produto->setAtivo($new_ativo);
                $new_produto->setDescricao($new_descricao);
                $new_produto->setQntde($new_qntde);
                $new_produto->setId($new_id);  

                if (strlen(trim($itens)) != 0 ){
                    $new_produto?->setItens(explode(",",trim($itens)));        
                } else {
                    $new_produto->setItens([]);
                }

                try {
                    $new_model->update($new_produto);
                    echo "<div class='container alert alert-success mt-5'>Registro atualizado com sucesso!</div>";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "UC_Modelo")) {
                        echo "<div class=' container alert alert-danger'>Não foi possível atualizar o registro, pois o modelo do produto já foi cadastrado</div>";
                    } else {
                        echo "Não foi possível atualizar o registro! Erro de banco de dados";
                    }
                }    
            } else {
                //cadastrar produto
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
                $itens = $_POST['produtosVinculados'];


                $new_produto->setModelo($new_modelo);
                $new_produto->setAtivo($new_ativo);
                $new_produto->setDescricao($new_descricao);
                $new_produto->setQntde($new_qntde);
                if (strlen(trim($itens)) != 0 ){
                    $new_produto?->setItens(explode(",",trim($itens)));        
                } else {
                    $new_produto->setItens([]);
                }

                try {
                    $new_model->insert($new_produto);
                    echo "<div class=' container alert alert-success'>Registro criado com sucesso!</div>";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "UC_Suprimentos")) {
                        echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro, pois os suprimentos estão em duplicidade!</div>";
                    } elseif (str_contains($e->getMessage(), "UC_Modelo")) {
                        echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro, pois o modelo do produto já foi cadastrado</div>";
                    } else {
                        echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro! Erro de banco de dados.</div>";
                    }
                }  
            }
        }
    ?>
    <main class="container mt-5">
        <form action="cadastro.php" method="post" id="formCadastro">

            <h2>Cadastro de Produto</h2>
            
            <input type="hidden" name="id" 
                <?php 
                    if(@$_REQUEST['id']) {
                        echo "value=\"".$_REQUEST['id']."\"";
                    } else {
                        echo "value=\"".null."\"";
                    }
                ?>
            >

            <div class="form-group mt-5">
                <label for="modelo">Modelo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="modelo" id="modelo" 
                    <?php if(isset($produto)) {
                        echo "value=\"".$modelo."\"";
                        }
                    ?>
                placeholder="insira o modelo do produto">
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
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" name="descricao"
                    <?php if(isset($produto)) {
                        echo "value=\"".$descricao."\"";
                        }
                    ?>
                id="descricao">
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

            <hr class="mt-5">

            <h2 class="mt-5" >Vinculação de Produtos</h2>

            <div class="row mt-5">
                <div class="col-10">
                    <select class="form-select" name="selectProduto" id="selectProduto" aria-label="Default select example">
                        <option selected>Selecione o produto a ser vinculado</option>
                        <?php 
                            $model = new ProdutoModel;

                            $select_produto = $model->select();
                            
                            foreach ($select_produto as $obj) {
                                print "<option value=\"".$obj->getId()."\">".$obj->getModelo()."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col-2">
                    <button type="button" id="addProduto" class="btn btn-primary">Vincular</button>
                </div>
            </div>
            
            <script>
                            
            </script>

            <table class="table table-hover table-striped table-bordered mt-5 row" id="content">
                <tr>
                    <th class="col-6">Código</th>
                    <th class="col-6">Produto</th>
                    <th class="col-2">Ações</th>
                </tr>

                    <?php
                        if(@$_REQUEST['id']) {
                            foreach ($suprimentos as $suprimento) {
                    ?>
                                <tr>
                                    <td><?=$suprimento['id']?></td>
                                    <td><?=$suprimento['modelo_produto']?></td>
                                    <td><button type="button" class="btn btn-danger">Excluir</button></td>
                                </tr>
                    <?php            
                            } 
                        }
                    ?>
            </table>

            <input type="hidden" class="form-control" id="produtosVinculados" name="produtosVinculados" value="">
            
            <button type="submit" id="submit" class="btn btn-primary mt-5 mb-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-danger mt-5 mb-5">Cancelar</a>
        </form>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
            $(document).ready(function(){
                $("#addProduto").click(function () {
                    var selectProduto = document.getElementById('selectProduto');
                    var valor = selectProduto.options[selectProduto.selectedIndex].value; 
                    valor = parseInt(valor);  
                    var texto = selectProduto.options[selectProduto.selectedIndex].text;
                    if(Number.isInteger(valor)) {
                        $("#content").append(
                        '<tr>\
                            <td>'+valor+'</td>\
                            <td>'+texto+'</td>\
                            <td><button type="button" class="btn btn-danger">Excluir</button></td>\
                        </tr>'
                        ); 
                    }
                });
                
                $("table").on("click", "button", function () {
                        $(this).parent().parent().remove();
                });
                    
                $("#submit").click(function () {
                    var itens = "";
                    $("tr td:first-child").each(function (t){
                    if (t == 0){ 
                        var valor = $(this).text();
                        itens += valor;
                    } else {
                        var valor = $(this).text();
                        itens += "," + valor;
                    }
                    });
                    $("#produtosVinculados").val(itens);
                    
                });
            });
        </script>                        

</body>
</html>