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

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/controller//';

        include ($controllerPath . "usuario_controller.php");

        include ($path . "menu.php");

        include ($path . "verificaDti.php");

        $usuarioController = new UsuarioController;

        if (isset($_GET['id'])){
            $usuario = $usuarioController->buscaUsuario();
        }

        if(isset($_POST['nome'])) {
            if (@$_REQUEST['id'] != null){
                $usuarioController->atualizaUsuario();
            } else {
                $usuarioController->cadastraUsuario();
            }
        }
    ?>
    <main class="container mt-5">

        <!-- nota: após conversa com Henrique, também cadastrar a diretoria do usuário mesmo em caso em que o mesmo esteja locado em uma divisão, -->
        <!-- pois facilita o processo de busca e evita confusão do funcionário ao editar -->
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
                            $usuarioController->exibeDiretoria();
                        ?>
                    </select>
                </div>

                <div class="col-3">
                    <label for="selectDivisao">Selecione a divisão</label>
                    <select class="form-select" name="selectDivisao" id="selectDivisao">
                        <?php 
                            $usuarioController->exibeDivisao();
                        ?>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="form-group mt-5 col-3">
                    <label for="senha">Senha <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="senha" min="6" max="16"
                        <?php if(!isset($_GET['id'])) {
                                    echo "required";
                                }
                        ?>
                    id="senha" placeholder="insira a senha">
                </div>
                                
                <div class="form-group col-auto mt-4 pt-5">
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

                <div class="form-group col-auto mt-4 pt-5">
                    <label for="usuarioDti">Tem permissão Dti?</label> 
                    <input type="checkbox" id="usuarioDti" name="usuarioDti" class="form-check-input" 
                        <?php if (isset($usuario)){
                            if ($usuario->getUsuarioDti() ==  1) {
                                echo "checked";
                            }
                        }
                        ?>
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            <a href="pesquisar.php" type="button" class="btn btn-light mt-5">Cancelar</a>
        </form>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>