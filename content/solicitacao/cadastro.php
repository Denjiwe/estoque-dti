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

    ?>
    <main class="container mt-5">
        <form action="cadastro.php?adicionar" method="post" id="formCadastro">

            <h2>Solicitar Toner/Cilíndro</h2>

            <input type="hidden" class="form-control" id="nomeImpressora" name="nomeImpressora" value="">

            <div class="row mt-5">
                <div class="col-lg-4 col-10">
                    <label for="selectImpressora">Selecione a sua impressora</label>
                    <select class="form-select" name="selectImpressora" id="selectImpressora" required>
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
                    <select class="form-select" name="selectTC" id="selectTC" required> <!-- select Toner Cilindro -->
                        <option value="" selected hidden></option>                             
                        <option value="toner">Toner</option>            
                        <option value="cilindro">Cilíndro</option>            
                        <option value="conjunto">Conjunto</option>            
                    </select>
                </div>

                <div class="col-lg-1 col-3">
                    <label for="qntde">Quantidade</label>
                    <input type="number" class="form-control" name="qntde" id="qntde" min="1" max="2" required>
                </div>
            </div>
            
            <button type="submit" id="adicionar" class="btn btn-primary mt-5">Adicionar</button>
            
            <input type="hidden" class="form-control" name="impressoras" id="impressoras" value="">

        </form>
                <script>
                    $(document).ready(function(){
                        $('#selectImpressora').on('change', function(){
                            var selectImpressora = document.getElementById('selectImpressora');
                            var texto = selectImpressora.options[selectImpressora.selectedIndex].text;
                            document.getElementById('nomeImpressora').value = texto;
                        });
                        
                        $("table").on("click", "button", function () {
                                $(this).parent().parent().remove();
                        });

                        $("#finalizar").click(function () {
                            var itens = "";
                            $("tr td:nth-child(3)").each(function (t){
                            var valor = $(this).text();
                            itens += valor;
                            });
                            $("#qntdeItem").val(itens);
                
                        });
                    });               
                </script>
        <form action="cadastro.php?finalizar" method="post" id="formCadastro">
            

            <table class="table table-hover table-striped table-bordered mt-5 row" id="content">
                <tr>
                    <th class="col-4">Modelo da Impressora</th>
                    <th class="col-1">Quantidade</th>
                    <th class="col-5" colspan="2">Produto(s)</th>  
                    <th class="col-2">Ações</th>
                </tr>
                <?php
                    if(isset($_GET['adicionar'])) {

                        $model = new SolicitacaoModel;

                        $solicitacao = new Solicitacao;

                        $nomeImpressora = $_POST['nomeImpressora'];
                        $idImpressora = $_POST['selectImpressora'];
                        $qntde = $_POST['qntde'];    

                        switch ($_POST['selectTC']) {
                            case "toner":
                                $model = new ProdutoModel;
                                $toner = new Produto;
                                $toner = $model->getToner($idImpressora);
                                print 
                                '<tr>
                                    <td hidden>'.$idImpressora.'</td>
                                    <td>'.$nomeImpressora.'</td>
                                    <td>'.$qntde.'</td>
                                    <td>'.$toner->getModelo().'</td>
                                    <td style="padding: 0px; margin: 0px;"></td>
                                    <td><button type="button" class="btn btn-danger">Excluir</button></td>
                                </tr>';

                                print "<input type='hidden' name='tonerId' value=".$toner->getId()."/>";
                                break;
                            case "cilindro":
                                $model = new ProdutoModel;
                                $cilindro = new Produto;
                                @$cilindro = $model?->getCilindro($idImpressora);
                                if ($cilindro != null) {
                                    print 
                                    '<tr>
                                        <td hidden>'.$idImpressora.'</td>
                                        <td>'.$nomeImpressora.'</td>
                                        <td>'.$qntde.'</td>
                                        <td>'.$cilindro?->getModelo().'</td>
                                        <td style="padding: 0px; margin: 0px;"></td>
                                        <td><button type="button" class="btn btn-danger">Excluir</button></td>
                                    </tr>';

                                    print "<input type='hidden' name='cilindroId' value=".$cilindro->getId()."/>";
                                } else {
                                    print "<div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>";
                                }
                                break;
                            case "conjunto":
                                $model = new ProdutoModel;
                                $toner = new Produto;
                                $toner= $model->getToner($idImpressora);
                                $cilindro = new Produto;
                                @$cilindro = $model?->getCilindro($idImpressora);
                                if ($cilindro != null) {
                                    print 
                                    '<tr>
                                        <td hidden>'.$idImpressora.'</td>
                                        <td>'.$nomeImpressora.'</td>
                                        <td>'.$qntde.'</td>
                                        <td>'.$toner?->getModelo().'</td>
                                        <td>'.$cilindro?->getModelo().'</td>
                                        <td><button type="button" class="btn btn-danger">Excluir</button></td>
                                    </tr>';
                                    
                                    print "<input type='hidden' name='tonerId' value=".$toner->getId()."/>";
                                    print "<input type='hidden' name='cilindroId' value=".$cilindro->getId()."/>";
                                } else {
                                    print "<div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>";
                                }
                                break;
                        }
  
                    }

                    if(isset($_GET['finalizar'])) {
                        $model = new SolicitacaoModel;

                        $solicitacao = new Solicitacao;

                        $estado = $_POST['estado'];
                        $solicitacao->setEstadoSolicitacao($estado);

                        $observacao = $_POST['observacao'];
                        $solicitacao?->setDescricao($observacao);

                        $solicitacao->setDataSolicitacao(date("Y-m-d"));

                        $qntdeItem = $_POST['qntdeItem'];
                        $solicitacao->setQntdeItem($qntdeItem);

                        @$tonerId = $_POST['tonerId'];
                        @$cilindroId = $_POST['cilindroId'];

                        if($tonerId != null && $cilindroId == null){
                            $produtos = [$tonerId];
                        } elseif($tonerId == null && $cilindroId != null){
                            $produtos = [$cilindroId];
                        } elseif($tonerId != null && $cilindroId != null){
                            $produtos = [$tonerId, $cilindroId];
                        }

                        $solicitacao->setItemSolicitacao($produtos);

                        try {
                            $model->insert($solicitacao);
                            echo "<div class=' container alert alert-success'>Solicitação criada com sucesso!</div>";
                        } catch (PDOException $e){
                            echo "<div class=' container alert alert-danger'>Não foi possível cirar a solicitação! ".$e->getMessage()."</div>";
                        }
                    }
                ?>

            </table>

            <div class="form-group mt-5">
                <label for="observacao">Observação</label>
                <input type="text" class="form-control" name="observacao" id="observacao">
            </div>

            <input type="hidden" class="form-control" name="estado" id="estado" value="Aberto">

            <input type="hidden" class="form-control" name="qntdeItem" id="qntdeItem" value="">

            <button type="submit" id="finalizar" class="btn btn-primary mt-5 mb-5">Finalizar</button>
            <a href="pesquisar.php" type="button" class="btn btn-danger mt-5 mb-5">Cancelar</a>
           
        </form>
    </main>

</body>
</html>