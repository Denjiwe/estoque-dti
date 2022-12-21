<?php
    session_start();

    $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include ($controllerPath . 'solicitacao_controller.php');

    include ($path . "verificaLogin.php");

    $solicitacaoController = new SolicitacaoController;

    //remover elementos da sessão quando o usuário clicar no botão de excluir
    if(isset($_GET['excluir'])) {
        $solicitacaoController->excluiProduto();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        include_once ($path . "menu.php"); 

        if(isset($_GET['finalizar'])) {
            $solicitacaoController->cadastraSolicitacao();
        }

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
                            $solicitacaoController->exibeImpressora();
                        ?>
                    </select>
                </div>
            </div>

            <div class="mt-5 row">
                <div class="form-group col-lg-2 col-5">
                    <label for="selectTC">Toner ou Cilíndro?</label>
                    <select class="form-select" name="selectTC" id="selectTC" required>
                        <!-- select Toner Cilindro -->
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

        <form action="cadastro.php?finalizar" method="post" id="formCadastro">

            <?php
                    if(isset($_GET['adicionar'])) {
                        $solicitacaoController->adicionaProduto();
                    }

                    if ((isset($_SESSION['nomeImpressora']) && $_SESSION['nomeImpressora'] != null) && ((isset($_SESSION['toner']) || isset($_SESSION['cilindro'])) && (@$_SESSION['toner'] != null || @$_SESSION['cilindro'] != null))){
                        $solicitacaoController->exibeListaProduto();
                    }
                ?>



            <div class="form-group mt-5">
                <label for="observacao">Observação</label>
                <input type="text" class="form-control" name="observacao" id="observacao">
            </div>

            <input type="hidden" class="form-control" name="estado" id="estado" value="Aberto">

            <button type="submit" id="finalizar" class="btn btn-primary mt-5 mb-5">Finalizar</button>
            <a href="<?= $_SESSION['dti'] ? 'pesquisar.php' : 'home.php'?>" type="button"
                class="btn btn-danger mt-5 mb-5">Cancelar</a>

        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    
    <script>
    $(document).ready(function() {
        $('#selectImpressora').on('change', function() {
            var selectImpressora = document.getElementById('selectImpressora');
            var texto = selectImpressora.options[selectImpressora.selectedIndex].text;
            document.getElementById('nomeImpressora').value = texto;
        });

        $("table").on("click", "button", function() {
            $(this).parent().parent().remove();
        });

        let modal = document.querySelector(".modal");
        let body = document.querySelector("body");

        if (modal.classList.contains("show")) {
            body.classList.add("modal-open");
            body.style.overflow = "hidden";
            let div = document.createElement("div");
            div.classList.add("modal-backdrop");
            div.classList.add("fade");
            div.classList.add("show");

            body.appendChild(div);
        }
    });
    </script>
</body>

</html>