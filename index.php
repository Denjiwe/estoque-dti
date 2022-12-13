<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque DTI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <main class="container">

        <h1 class="text-center">Estoque DTI</h1>
 
            <div class="card border-secondary mb-3">
                <div class="card-header text-center">Login</div>
                    <div class="card-body">
                        <?php
                            if (isset($_SESSION['nao_autenticado'])) {
                        ?>
                                <script language='javascript' type='text/javascript'>
                                    alert('Login e/ou senha incorretos');window.location
                                    .href='index.php';
                                </script>
                        <?php     
                                unset($_SESSION['nao_autenticado']);   
                            }
                        ?>
                        <form action="login.php" method="post" class="">
                            <div class="input-group">
                                <span for="cpf" class="input-group-text">&nbsp CPF &nbsp</span>
                                <input type="text" id="cpf" name="cpf" class="form-control" placeholder="Insira seu CPF" required>
                            </div>

                            <div class="input-group mt-3">
                                <label for="senha" class="input-group-text ">Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control" placeholder="Insira sua senha" required>
                            </div>

                            <button type="submit" class="btn btn-secondary mt-3">Acessar</button>
                        </form>

                        <a id="esqueceu" class="mt-5" href="esqueceu.html">Esqueci minha senha</a>

                    </div>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>