<?php
session_start();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/';

    include_once ($path . "verificaLogin.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Entregues</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/menu.css">
</head>
<body>
    <?php 

        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include ($controllerPath . 'entrega_controller.php');

        include($path . "menu.php");

        $entregaController = new EntregaController;
    ?>
    
    <main class="container mt-5" id="content">
        <?php
            $entregaController->exibeEntregas();
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>
</html>