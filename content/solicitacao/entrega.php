<?php

    include ("../../entity/solicitacao.php");   

    include ("../../model/solicitacao_model.php");

    include ("../../entity/produto.php");

    include ("../../model/produto_model.php");

    $ids = $_POST['ids'];

    print_r($ids);