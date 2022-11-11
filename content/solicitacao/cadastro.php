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
        include ("../../entity/solicitacao.php");

        include ("../../model/solicitacao_model.php");

        include ("../../entity/produto.php");

        include ("../../model/produto_model.php");

        include_once ("../../menu.php");

        $model = new ProdutoModel;

        if($_REQUEST['adicionar']) {

            switch ($_POST['selectImpressora']) {
                case "toner":
                    $toner = new Produto;
                    $toner->getToner();
                    break;
                case "cilindro":
                    $cilindro = new Produto;
                    $cilindro->getCilindro();
                    break;
                case "conjunto":
                    $toner = new Produto;
                    $toner->getToner();
                    $cilindro = new Produto;
                    $cilindro->getCilindro();
                    break;
            }

        }

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
                echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro!".$e->getMessage()."</div>";
            }
        }

?>
    <main class="container mt-5">
        <form action="cadastro.php?adicionar" method="post" id="formCadastro">

            <h2>Solicitar Toner/Cilíndro</h2>


            <div class="row mt-5">
                <div class="col-lg-4 col-10">
                    <label for="selectImpressora">Selecione a sua impressora</label>
                    <select class="form-select" name="selectImpressora" id="selectImpressora">
                        <option selected hidden></option>
                        <?php 
                            $model = new ProdutoModel;

                            $select_impressora = $model->selectImpressora();
                            
                            foreach ($select_impressora as $impressora) {
                                print "<option value=\"".$impressora['id']."\">".$impressora['modelo_produto']."</option>";
                            };
                        ?>
                    </select>
                </div>
            </div>

            <div class="mt-5 row">
                <div class="form-group col-lg-2 col-5">
                    <label for="selectTC">Toner ou Cilíndro?</label>
                    <select class="form-select" name="selectTC" id="selectTC"> <!-- select Toner Cilindro -->
                        <option value="" selected hidden></option>                             
                        <option value="toner">Toner</option>            
                        <option value="cilindro">Cilíndro</option>            
                        <option value="conjunto">Conjunto</option>            
                    </select>
                </div>

                <div class="col-lg-1 col-3">
                    <label for="qntde">Quantidade</label>
                    <input type="number" class="form-control" name="qntde" id="qntde" min="1" max="2">
                </div>
            </div>

            <input type="hidden" class="form-control" id="produtosVinculados" name="produtosVinculados" value="">
            
            <button type="submit" id="adicionar" class="btn btn-primary mt-5">Adicionar</button>

        </form>

        <form>
            <script>
                $(document).ready(function(){
                    $("#adicionar").click(function () {
                        var selectImpressora = document.getElementById('selectImpressora');
                        var valor = selectImpressora.options[selectImpressora.selectedIndex].value; 
                        valor = parseInt(valor);  
                        var texto = selectImpressora.options[selectImpressora.selectedIndex].text;
                        var qntde = document.getElementById('qntde').value;
                        qntde = parseInt(qntde);

                            $("#content").append(
                            '<tr>\
                                <td hidden>'+valor+'</td>\
                                <td>'+texto+'</td>\
                                <td>'+qntde+'</td>\
                                <td><?php
                                    ?></td>\
                                <td><button type="button" class="btn btn-danger">Excluir</button></td>\
                                </tr>'
                            );
                    });
                    
                    $("table").on("click", "button", function () {
                            $(this).parent().parent().remove();
                    });
                });               
            </script>

            <table class="table table-hover table-striped table-bordered mt-5 row" id="content">
                <tr>
                    <th class="col-4">Modelo da Impressora</th>
                    <th class="col-1">Quantidade</th>
                    <th class="col-5">Produto(s)</th>  
                    <th class="col-2">Ações</th>
                </tr>

            </table>

            <div class="form-group mt-5">
                <label for="observacao">Observação</label>
                <input type="text" class="form-control" name="descricao" id="observacao">
            </div>

            <input type="hidden" class="form-control" name="Estado" id="Estado" value="Aberto" placeholder="insira o Estado do produto">

            <button type="button" id="finalizar" class="btn btn-primary mt-5 mb-5">Finalizar</button>
            <a href="pesquisar.php" type="button" class="btn btn-danger mt-5 mb-5">Cancelar</a>
            
            <script>
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
            </script>
        </form>
    </main>

</body>
</html>