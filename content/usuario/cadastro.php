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
    <title>CRUD 2.0 - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        include ($path . "menu.php");

        include ($entityPath . "usuario.php");

        include ($modelPath . "usuario_model.php");

        if (isset($_GET['id'])){
            $model = new UsuarioModel;

            $newUsuario = new Usuario;

            $id = $_GET['id'];
            try {
                $usuario = $model->findById($id);
            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
            
        }

        if(isset($_POST['nome'])) {
            if (@$_REQUEST['id'] != null){
                $model = new UsuarioModel;

                $usuario = new Usuario;

                $id = $_POST['id'];
                $ativoOk = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativoOk = 1;
                }
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $email = $_POST['email'];
                $senha = MD5($_POST['senha']);
                $ativo = $ativoOk;

                if ($_POST['selectDivisao'] >= 1 && $_POST['selectDiretoria'] >= 1){
                    $divisao = $_POST['selectDivisao'];
                    $usuario->setDivisaoId($divisao);
                    $usuario->setDiretoriaId(0);
                } elseif ($_POST['selectDiretoria'] >= 1) {
                    $diretoria = $_POST['selectDiretoria'];
                    $usuario->setDiretoriaId($diretoria);
                    $usuario->setDivisaoId(0);
                } elseif ($_POST['selectDivisao'] >= 1) {
                    $divisao = $_POST['selectDivisao'];
                    $usuario->setDivisaoId($divisao);
                    $usuario->setDiretoriaId(0);
                }

                $usuario->setNome($nome);
                $usuario->setCpf($cpf);
                $usuario->setEmail($email);
                $usuario->setSenha($senha);
                $usuario->setAtivo($ativo);
                $usuario->setId($id);

                try {
                    $model->update($usuario);

                    print "<div class='container alert alert-success mt-5'>Usuário alterado com sucesso!</div>";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "UC_Cpf")) {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a usuário, pois um usuário de mesmo CPF já existe!</div>";
                    } elseif (str_contains($e->getMessage(), "UC_Email")) {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a usuário, pois um usuário de mesmo e-mail já existe!</div>";
                    } else {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar a usuário, erro de banco de dados</div>";
                    }
                }
            } else {
                $model = new UsuarioModel;

                $newUsuario = new Usuario;

                $ativoOk = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativoOk = 1;
                }
                $newNome = $_POST['nome'];
                $newCpf = $_POST['cpf'];
                $newEmail = $_POST['email'];
                $newSenha = MD5($_POST['senha']);
                $newAtivo = $ativoOk;

                if ($_POST['selectDivisao'] >= 1 && $_POST['selectDiretoria'] >= 1){
                    $newDivisao = $_POST['selectDivisao'];
                    $newUsuario->setDivisaoId($newDivisao);
                    $newUsuario->setDiretoriaId(0);
                } elseif ($_POST['selectDiretoria'] >= 1) {
                    $newDiretoria = $_POST['selectDiretoria'];
                    $newUsuario->setDiretoriaId($newDiretoria);
                    $newUsuario->setDivisaoId(0);
                } elseif ($_POST['selectDivisao'] >= 1) {
                    $newDivisao = $_POST['selectDivisao'];
                    $newUsuario->setDivisaoId($newDivisao);
                    $newUsuario->setDiretoriaId(0);
                }

                $newUsuario->setNome($newNome);
                $newUsuario->setCpf($newCpf);
                $newUsuario->setEmail($newEmail);
                $newUsuario->setSenha($newSenha);
                $newUsuario->setAtivo($newAtivo);

                try {
                    $model->insert($newUsuario);

                    print "<div class='container alert alert-success mt-5'>Usuário criado com sucesso!</div>";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "UC_Cpf")) {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a usuário, pois um usuário de mesmo CPF já existe!</div>";
                    } elseif (str_contains($e->getMessage(), "UC_Email")) {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a usuário, pois um usuário de mesmo e-mail já existe!</div>";
                    } else {
                        echo "<div class='container alert alert-danger mt-5'>Não foi possível criar a usuário, erro de banco de dados ".$e->getMessage()."</div>";
                    }
                }
            }
        }
    ?>
    <main class="container mt-5">

        <p>nota: após conversa com Henrique, também cadastrar a diretoria do usuário mesmo em caso em que o mesmo esteja locado em uma divisão, pois facilita o processo de busca e evita confusão
        do funcionário ao editar</p>
        <form action="cadastro.php" method="post" id="formCadastro">
            
            <input type="hidden" name="id" 
                <?php 
                    if(@$_GET['id']) {
                        echo "value=\"".$_GET['id']."\"";
                    } else {
                        echo "value=\"".null."\"";
                    }
                ?>
            >
            
            <div class="row">
                <div class="form-group col-5">
                    <label for="nome">Nome do Usuário<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nome" 
                        <?php if(isset($usuario)) {
                                echo "value=\"".$usuario->getNome()."\"";
                                }
                        ?>
                    id="nome" placeholder="insira o nome" required>
                </div>

                <div class="form-group col-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email"
                        <?php if(isset($usuario)) {
                            echo "value=\"".$usuario->getEmail()."\"";
                            }
                        ?>
                    id="email" placeholder="insira o email" required>
                </div>
            </div>

            <div class="row mt-5">
                <div class="form-group col-5">
                    <label for="cpf">CPF <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="cpf" 
                        <?php if(isset($usuario)) {
                            echo "value=\"".$usuario->getCpf()."\"";
                            }
                        ?>
                    id="cpf" placeholder="insira o CPF" minlenght="11" maxlength="11" required>
                </div>

                <div class="col-3">
                    <label for="selectDiretoria">Selecione a diretoria</label>
                    <select class="form-select" name="selectDiretoria" id="selectDiretoria" required>
                        <?php 
                            $model = new UsuarioModel;

                            $diretorias  = $model->selectDiretoria();

                            if (isset($usuario)){
                                if ($usuario->getDiretoriaId() > 0){
                                    $id = $usuario->getDiretoriaId();
                                    $diretoria= $model->findDiretoriaNome($id);
                                    $usuario->setDiretoriaNome($diretoria);
                                    print "<option value='0'></option>";
                                } else {
                                    print "<option value='0' selected></option>";
                                }
                            } else {
                               print "<option value='0' selected></option>";
                            }

                            foreach ($diretorias as $diretoria) {
                                if (isset($usuario)){
                                    if ($usuario->getDiretoriaId() >= 1){
                                        if ($diretoria['id'] !== $usuario->getDiretoriaId()){
                                            print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                                        } else {
                                            print "<option value=\"".$usuario->getDiretoriaId()."\" selected>".$usuario->getDiretoriaNome()."</option>";
                                        }
                                    } else {
                                        print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                                    }
                                } else {
                                    print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="col-3">
                    <label for="selectDivisao">Selecione a divisão</label>
                    <select class="form-select" name="selectDivisao" id="selectDivisao">
                        <?php 
                            $model = new UsuarioModel;
                                
                            $divisoes  = $model->selectDivisao();

                            if (isset($usuario)){
                                if ($usuario->getDivisaoId() > 0){
                                    $id = $usuario->getDivisaoId();
                                    $divisao = $model->findDivisaoNome($id);
                                    $usuario->setDivisaoNome($divisao);
                                    print "<option value='0'>Nenhuma divisão</option>";
                                } else {
                                    print "<option value='0' selected>Nenhuma divisão</option>";
                                }
                            } else {
                               print "<option value='0' selected>Nenhuma divisão</option>";
                            }

                            foreach ($divisoes as $divisao) {
                                if (isset($usuario)){
                                    

                                    if ($usuario->getDivisaoId() > 0){
                                        if ($divisao['id'] !== $usuario->getDivisaoId()){
                                            print "<option value=\"".$divisao['id']."\">".$divisao['nome']."</option>";
                                        } else {
                                            print "<option value=\"".$usuario->getDivisaoId()."\" selected>".$usuario->getDivisaoNome()."</option>";
                                        }
                                    } else {
                                        print "<option value=\"".$divisao['id']."\">".$divisao['nome']."</option>";
                                    }
                                } else {
                                    print "<option value=\"".$divisao['id']."\">".$divisao['nome']."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

            </div>
            
            <div class="form-group mt-5 col-3">
                <label for="senha">Senha <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="senha" min="6" max="16"
                    <?php if(isset($usuario)) {
                            echo "value=\"".$usuario->getSenha()."\"";
                            }
                    ?>
                id="senha" placeholder="insira a senha" required>
            </div>
            

            <div class="form-group mt-5">
                <label for="ativo">Ativo?</label> 
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input" 
                    <?php if (isset($usuario)){
                        if ($usuario->getAtivo() ==  1) {
                            echo "checked";
                        }
                    }
                    ?>
                >
            </div>

            <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-light mt-5">Cancelar</a>
        </form>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>