<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2.0</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <main class="container mt-5">
        <form action="home.php" method="get" id="formPesquisa">
            <div class="input-group">
                <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquise o nome do órgão">
                <button type="submit" class="btn btn-secondary">Pesquisar</button> 
            </div>
        </form>

        <div class="mt-5">
            
            <?php
                include ("./entity/orgao.php");

                include ("./model/orgao_model.php");

                if (isset($_GET['pesquisa'])) {
                    $model = new OrgaoModel;
                    
                    $pesquisa = $_GET['pesquisa'];

                    $orgao = $model->findByName($pesquisa);

                    print "<h1>Produtos cadastrados com nome: \"".$pesquisa."\"</h1>";

                    if ($orgao == null ) {
                        echo "<h3>Nenhum órgão encontrado!</h3>";
                        print "<a class='btn btn-light' href='home.php'>Voltar para Home</a>";

                    } else {
                        print "<table class=' container table table-hover table-striped table-bordered'>";

                        print "<tr>";
                        print "<th style='display:none;'>id</th>";
                        print "<th>Nome</th>";
                        print "<th>Ativo</th>";
                        print "<th>Data de Criação</th>";
                        print "<th>Data de Desativação</th>";
                        print "<th>Ações</th>";
                        print "</tr>";
                    
                        print "<tr>";
                        print "<td style='display:none;'>".$orgao->getId()."</td>";
                        print "<td>".$orgao->getNome()."</td>";
                        print "<td>".$orgao->getAtivo()."</td>";
                        print "<td>".$orgao->getDataCriacao()."</td>";
                        print "<td>".$orgao->getDataDesativo()."</td>";
                        print "<td>
                         <button class='btn btn-success'>Editar</button>
                         <button class='btn btn-danger'>Excluir</button>
                              </td>";
                        print "</tr>";
                    
                        print "</table>";

                        print "<a class='btn btn-light' href='home.php'>Voltar para Home</a>";
                    }
                    
                } else {
                    print "<h1>Produtos cadastrados</h1>";

                    print "<table class=' container table table-hover table-striped table-bordered'>";

                    print "<tr>";
                    print "<th style='display:none;'>#</th>";
                    print "<th>Nome</th>";
                    print "<th>Ativo</th>";
                    print "<th>Data de Criação</th>";
                    print "<th>Data de Desativação</th>";
                    print "<th>Ações</th>";
                    print "</tr>";

                    $model = new OrgaoModel;

                    $orgao = $model->select();
                    
                    foreach ($orgao as $obj) {
                        print "<tr>";
                        print "<td style='display:none;'>".$obj->getId()."</td>";
                        print "<td>".$obj->getNome()."</td>";
                        print "<td>".$obj->getAtivo()."</td>";
                        print "<td>".$obj->getDataCriacao()."</td>";
                        print "<td>".$obj->getDataDesativo()."</td>";
                        print "<td>
                         <button class='btn btn-success'>Editar</button>
                         <button class='btn btn-danger'>Excluir</button>
                              </td>";
                        print "</tr>";
                    }
                    print "</table>";
                }

            ?>
        </div>
    </main>
</body>
</html>