<?php
session_start();

$modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

include ($modelPath . "usuario_model.php");

$model = new UsuarioModel;

$login = $_POST['cpf'];

$senha = $_POST['senha'];

$verificacao = $model->verificaLogin($login, $senha);