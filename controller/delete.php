<?php
    $host = "db";
    $username = "root";
    $password = "root";
    $db = "db_estoque-dti";
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("DELETE FROM produto WHERE id = ".$_REQUEST["id"]);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }