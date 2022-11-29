<?php 
    if( empty(session_id()) && !headers_sent()){
        session_start();
    }
?>    
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
                    <th class="col-4 text-center">Modelo da Impressora</th>
                    <th class="col-1 text-center">Quantidade</th>
                    <th class="col-5 text-center" colspan="2">Produto(s)</th>  
                    <th class="col-2 text-center">Ações</th>
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
                                $cilindro = null;
                                if (!isset($_SESSION['qntde'])){
                                    $_SESSION['qntde'] = [];
                                }
                                array_push($_SESSION['qntde'], $qntde);
                                break;
                            case "cilindro":
                                $model = new ProdutoModel;
                                $cilindro = new Produto;
                                @$cilindro = $model?->getCilindro($idImpressora);
                                if ($cilindro == null) {
                            ?>        
                                    <div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>
                            <?php        
                                }
                                if (!isset($_SESSION['qntde'])){
                                    $_SESSION['qntde'] = [];
                                }
                                array_push($_SESSION['qntde'], $qntde);
                                $toner = null;
                                break;
                            case "conjunto":
                                $model = new ProdutoModel;
                                $toner = new Produto;
                                $toner= $model->getToner($idImpressora);
                                $cilindro = new Produto;
                                @$cilindro = $model?->getCilindro($idImpressora);
                                for ($i = 0; $i <= 1; $i++){
                                    if (!isset($_SESSION['qntde'])){
                                        $_SESSION['qntde'] = [];
                                    }
                                    array_push($_SESSION['qntde'], $qntde);
                                }

                                if ($cilindro == null) {
                            ?>        
                                    <div class='container alert alert-danger mt-5'>A impressora selecionada não possui cilíndro! Somente toner.</div>
                            <?php        
                                }
                                break;
                        }
                        if (!isset($_SESSION['produtos'])) {
                            $_SESSION['produtos'] = [];
                        }

                        if (!isset($_SESSION['nomeImpressora'])){
                            $_SESSION['nomeImpressora'] = [];
                        }
                        array_push($_SESSION['nomeImpressora'], $nomeImpressora);
                        
                        if (!isset($_SESSION['idImpressora'])){
                            $_SESSION['idImpressora'] = [];
                        }
                        array_push($_SESSION['idImpressora'], $idImpressora);
                       
                        if (!isset($_SESSION['qntdeExibicao'])){
                            $_SESSION['qntdeExibicao'] = [];
                        }
                        array_push($_SESSION['qntdeExibicao'], $qntde);
                        
                        if ($toner != null) {
                            if (!isset($_SESSION['toner'])){
                                $_SESSION['toner'] = [];
                            }
                            array_push($_SESSION['toner'],$toner?->getModelo());
                            
                        }
                        if ($cilindro != null) {
                            if (!isset($_SESSION['cilindro'])){
                                $_SESSION['cilindro'] = [];
                            }
                            array_push($_SESSION['cilindro'],$cilindro?->getModelo());
                        }
                        if ($cilindro != null) {
                            array_push($_SESSION['produtos'], $cilindro?->getId());
                        }
                        if ($toner != null) {
                            array_push($_SESSION['produtos'], $toner?->getId());
                        }
                        
                    }

                    if (isset($_SESSION['nomeImpressora'])){
                        for ($i=0; $i<count($_SESSION['nomeImpressora']);$i++) {
                            ?>
                                    <tr>
                                        <td hidden><?=$_SESSION['idImpressora'][$i]?></td>
                                        <td class="text-center"><?=$_SESSION['nomeImpressora'][$i]?></td>
                                        <td class="text-center"><?=$_SESSION['qntdeExibicao'][$i]?></td>
                            <?php
                                    if (isset($_SESSION['toner'][$i]) && !isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['toner'][$i]."</td>";
                                        print '<td style="padding: 0px; margin: 0px;"></td>';
                                        $_SESSION['cilindro'][$i] = null;

                                    } elseif (!isset($_SESSION['toner'][$i]) && isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['cilindro'][$i]."</td>";
                                        print '<td style="padding: 0px; margin: 0px;"></td>';
                                        $_SESSION['toner'][$i] = null;
                                        

                                    } elseif (isset($_SESSION['toner'][$i]) && isset($_SESSION['cilindro'][$i])){

                                        print "<td class='text-center'>".$_SESSION['toner'][$i]."</td>";
                                        print "<td class='text-center'>".$_SESSION['cilindro'][$i]."</td>";

                                    }             
                            ?>            
                                        <td class='text-center'><a href="cadastro.php?excluir=<?=$i?>" type="button" class="btn btn-danger">Excluir</a></td>
                                    </tr>
                            <?php        
                        }
                    }
                ?>

            </table>

            <div class="form-group mt-5">
                <label for="observacao">Observação</label>
                <input type="text" class="form-control" name="observacao" id="observacao">
            </div>

            <input type="hidden" class="form-control" name="estado" id="estado" value="Aberto">

            <button type="submit" id="finalizar" class="btn btn-primary mt-5 mb-5">Finalizar</button>
            <a href="pesquisar.php" type="button" class="btn btn-danger mt-5 mb-5">Cancelar</a>
           
        </form>
               <?php 
                    //remover elementos da sessão quando o usuário clicar no botão de excluir
                    if(isset($_GET['excluir'])) {
                        $model = new ProdutoModel;
                        $toner = new Produto;
                        $cilindro = new Produto;

                        $indexImpressora = $_GET['excluir'];

                        array_splice($_SESSION['nomeImpressora'], $indexImpressora, 1);

                        array_splice($_SESSION['qntdeExibicao'], $indexImpressora, 1);

                        $idImpressora = $_SESSION['idImpressora'][$indexImpressora];

                        $toner = $model?->getToner($idImpressora);

                        $cilindro = $model?->getCilindro($idImpressora);

                        $chaveToner = array_search($toner?->getModelo(), $_SESSION['toner']);     

                        $chaveIdToner = array_search($toner?->getId(), $_SESSION['produtos']);

                        $chaveCilindro = array_search($cilindro?->getModelo(), $_SESSION['cilindro']);

                        $chaveIdCilindro = array_search($cilindro?->getId(), $_SESSION['produtos']);

                        if ($chaveToner !==false || $chaveCilindro !==false){
                            array_splice($_SESSION['toner'], $chaveToner, 1);
                            array_splice($_SESSION['cilindro'], $chaveToner, 1);
                        }

                        if ($chaveIdToner !==false){
                            array_splice($_SESSION['produtos'], $chaveIdToner, 1);
                            array_splice($_SESSION['qntde'], $chaveIdToner, 1);
                        }
                        
                        if ($chaveIdCilindro !==false){
                            array_splice($_SESSION['produtos'], $chaveIdCilindro, 1);
                            array_splice($_SESSION['qntde'], $chaveIdCilindro, 1);
                        }

                        array_splice($_SESSION['idImpressora'], $indexImpressora, 1);
                        

                        header("Location: ./cadastro.php");
                    }


                    if(isset($_GET['finalizar'])) {
                        $model = new SolicitacaoModel;

                        $solicitacao = new Solicitacao;

                        session_destroy();
                        exit();

                        $estado = $_POST['estado'];
                        $solicitacao->setEstadoSolicitacao($estado);

                        $observacao = $_POST['observacao'];
                        $solicitacao?->setDescricao($observacao);

                        $qntdeItem = $_SESSION['qntde'];
                        $solicitacao->setQntdeItem($qntdeItem);

                        $produtos = $_SESSION['produtos'];

                        $solicitacao->setItemSolicitacao($produtos); 

                        try {
                            $model->insert($solicitacao);
                            echo "<div class=' container alert alert-success'>Solicitação criada com sucesso!</div>";
                        } catch (PDOException $e){
                            echo "<div class=' container alert alert-danger'>Não foi possível cirar a solicitação! ".$e->getMessage()."</div>";
                        }

                        session_destroy();
                    }
               ?>
    </main>

</body>
</html>