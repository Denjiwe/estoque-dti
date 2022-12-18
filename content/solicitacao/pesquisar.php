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
    <title>CRUD 2.0 - Solicitação</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/menu.css">
</head>

<body>
    <?php 

        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include($path . "menu.php");
        
        include($path . "verificaDti.php");
        
        include ($controllerPath . 'solicitacao_controller.php');

        $solicitacaoController = new SolicitacaoController;
    
        if(@$_REQUEST['entregue']){
            print "<div class='container alert alert-success mt-5'>Solicitação #".$_REQUEST['entregue']." alterada com sucesso!</div>";
        }
    ?>
    <main class="container mt-5">
        <div class="row">

            <div class="col-10">
                <form action="pesquisar.php" method="get" id="formPesquisa">
                    <div class="input-group">
                        <input type="text" class="form-control" name="pesquisa" id="pesquisa"
                            placeholder="Pesquise a solicitação" required>
                        <button type="submit" class="btn btn-secondary">Pesquisar</button>
                    </div>
                </form>
            </div>

            <div class="col-2">
                <a href="cadastro.php" class="btn btn-primary">Novo</a>
            </div>

        </div>

        <div class="mt-5">

            <h1 class="mb-4">Solicitações Cadastradas</h1>

            <div class='accordion mb-5' id='content'>
                <?php
                
                $solicitacaoController->exibeSolicitacao();

            ?>
        </div><!-- accordion -->
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script language='javascript'>
        let check = document.querySelectorAll(".form-check-input");
        let qntde = document.querySelectorAll(".form-input");
        let modal = document.querySelectorAll(".modal-body ul");
        let confirmar = document.querySelectorAll(".modal-footer button[type=submit]");
        
        function verifica() {
            for (let x = 0; x < modal.length; x++) {
                confirmar[x].setAttribute('disabled', '');
                if (modal[x].querySelectorAll("input[type=checkbox]:checked").length > 0){
                    confirmar[x].removeAttribute('disabled');
                } else {
                    confirmar[x].setAttribute('disabled', '');
                } 
            }
        }
        
        for (let i = 0; i < check.length; i++) {
            check[i].addEventListener("change", () => {
                qntde[i].toggleAttribute('required');
                qntde[i].toggleAttribute('disabled');
                qntde[i].toggleAttribute('value');
                verifica();
            });
        }
    </script>

</body>

</html>