<?php

    $host = "db";
    $username = "root";
    $password = "root";
    $db = "db_estoque-dti";

    $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);