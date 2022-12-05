<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0 - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/';

        $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

        $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

        include ($path . "menu.php");

        include ($entityPath . "usuario.php");

        include ($modelPath . "usuario_model.php");

        if(isset($_POST['nome'])) {
            $model = new UsuarioModel;

            $newUsuario = new Usuario;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $newNome = $_POST['nome'];
            $newCpf = $_POST['cpf'];
            $newEmail = $_POST['email'];
            $newSenha = $_POST['senha'];
            $newAtivo = $ativoOk;

            if ($_POST['selectDivisao'] >= 1 && $_POST['selectDiretoria'] >= 1){
                $newDivisao = $_POST['selectDivisao'];
                $newUsuario->setDivisaoId($newDivisao);
            } elseif ($_POST['selectDiretoria'] >= 1) {
                $newDiretoria = $_POST['selectDiretoria'];
                $newUsuario->setDiretoriaId($newDiretoria);
            } elseif ($_POST['selectDivisao'] >= 1) {
                $newDivisao = $_POST['selectDivisao'];
                $newUsuario->setDivisaoId($newDivisao);
            }

            $newUsuario->setNome($newNome);
            $newUsuario->setCpf($newCpf);
            $newUsuario->setEmail($newEmail);
            $newUsuario->setSenha($newSenha);
            $newUsuario->setAtivo($newAtivo);

            try {
                $model->insert($newUsuario);

                print "<div class=' container alert alert-success'>Usuário criado com sucesso!</div>";
            } catch (PDOException $e) {
                print "<div class=' container alert alert-danger'>Não foi possível cirar o usuário! ".$e->getMessage()."</div>";
            }
        }    

        if (isset($_GET['id'])){
            $model = new UsuarioModel;

            $usuario = new Usuario;
        }
    ?>
    <main class="container mt-5">
        <form action="cadastro.php" method="post" id="formCadastro">
            
            <input type="hidden" name="id" 
                <?php 
                    if(@$_REQUEST['id']) {
                        echo "value=\"".$_REQUEST['id']."\"";
                    } else {
                        echo "value=\"".null."\"";
                    }
                ?>
            >

            <input type="hidden" class="form-control" id="nomeLocal" name="nomeLocal" value="">
            
            <div class="row">
                <div class="form-group col-5">
                    <label for="nome">Nome do Usuário<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="insira o nome" required>
                </div>

                <div class="form-group col-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email"
                        <?php if(isset($orgao)) {
                            echo "value=\"".$dataCricacao."\"";
                            }
                        ?>
                    id="email" placeholder="insira o email" required>
                </div>
            </div>

            <div class="row mt-5">
                <div class="form-group col-5">
                    <label for="cpf">CPF <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="cpf" id="cpf" placeholder="insira o CPF" required>
                </div>

                <div class="col-3">
                    <label for="selectDiretoria">Selecione a diretoria</label>
                    <select class="form-select" name="selectDiretoria" id="selectDiretoria" required>
                        <option selected></option>
                        <?php 
                            $model = new UsuarioModel;

                            $diretorias  = $model->selectDiretoria();

                            foreach ($diretorias as $diretoria) {
                                print "<option value=\"".$diretoria['id']."\">".$diretoria['nome']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col-3">
                    <label for="selectDivisao">Selecione a divisão</label>
                    <select class="form-select" name="selectDivisao" id="selectDivisao">
                        <option selected></option>
                        <?php 
                            /*$model = new UsuarioModel;
                                
                            $divisoes  = $model->selectDivisao();

                            foreach ($divisoes as $divisao) {
                                print "<option value=\"".$divisao['id']."\">".$divisao['nome']."</option>";
                            }*/
                        ?>
                    </select>
                </div>

            </div>
            
            <div class="form-group mt-5 col-3">
                <label for="senha">Senha <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="senha" id="senha" placeholder="insira a senha" required>
            </div>
            

            <div class="form-group mt-5">
                <label for="ativo">Ativo?</label> 
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input" 
                    <?php if (isset($ativo)){
                        if ($ativo ==  1) {
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

    <script>
        $(document).ready(function(){
            $('#selectLocal').on('change', function(){
                var selectLocal = document.getElementById('selectLocal');
                var texto = selectLocal.options[selectLocal.selectedIndex].text;
                document.getElementById('nomeLocal').value = texto;
            });
            
            $("table").on("click", "button", function () {
                    $(this).parent().parent().remove();
            });
        });               
    </script>
</body>
</html>