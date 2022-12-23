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

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include ($controllerPath . 'solicitacao_controller.php');

        include($path . "menu.php");

        $solicitacaoController = new SolicitacaoController;
    ?>
<main class='container mt-5'>
    <div class='accordion' id='content'>
    <?php
        $solicitacaoController->exibeSolicitacao(false);
    ?>  
                </div>
            </div>
        </div>
        <?php
?>
    </div>
</main>

</table>
</div>
</main>
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
        if (modal[x].querySelectorAll("input[type=checkbox]:checked").length > 0) {
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
        verifica();
    });
}
</script>
</body>

</html>