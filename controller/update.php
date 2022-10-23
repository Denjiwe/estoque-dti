<?php
    $id = $_POST['id'];

    $modelo = $_POST['modelo'];
        
    $descricao = $_POST['descricao'];

    $qntde = $_POST['qntde'];

    $ativook = 0;

    if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
        $ativook = 1;
    }

    $host = "db";
    $username = "root";
    $password = "root";
    $db = "db_estoque-dti";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE produto SET modelo_produto = '{$modelo}', descricao = '{$descricao}', qntde_estoque = '{$qntde}', ativo = '{$ativook}' WHERE id = $id");
        $stmt->execute(array());

        header ('Location: ../index.php');
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }