<?php
    $ativook = 0;

    if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
        $ativook = 1;
    }
    
    $modelo = $_POST['modelo'];
    
    $descricao = $_POST['descricao'];
    
    $qntde = $_POST['qntde'];

    $host = "db";
    $username = "root";
    $password = "root";
    $db = "db_estoque-dti";
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO produto (modelo_produto, descricao, qntde_estoque, ativo) VALUES (:modelo, :descricao, :qntde, :ativo)");
            $stmt->execute(array(
                ':modelo'   => $modelo,
                ':descricao' => $descricao,
                ':qntde' => $qntde,
                ':ativo' => $ativook
            ));
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        header ('Location: ../../index.php');
    
