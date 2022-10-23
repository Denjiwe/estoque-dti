<?php

    $host = "db";
    $username = "root";
    $password = "root";
    $db = "db_estoque-dti";
    
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $consulta = $conn->query("SELECT * FROM produto;");

            
            print "<table class='table table-hover table-striped table-bordered'>";
            print "<tr>";
            print "<th>#</th>";
            print "<th>Modelo</th>";
            print "<th>Descrição</th>";
            print "<th>Quantidade</th>";
            print "<th>Ativo</th>";
            print "<th>Ações</th>";

            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                if ($linha['ativo'] == 1){
                    $linha['ativook'] = 'Sim';
                } else {
                    $linha['ativook'] = 'Não';
                }
                print "<tr>";
                print "<td>".$linha['id']."</td>";
                print "<td>".$linha['modelo_produto']."</td>";
                print "<td>".$linha['descricao']."</td>";
                print "<td>".$linha['qntde_estoque']."</td>";
                print "<td>".$linha['ativo']."</td>";
                print"<td>
                        <button onclick=\"location.href='?page=editar&id=".$linha['id']."#formUpdate'\" class='btn btn-success'>Editar</button>
                        <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=excluir&id=".$linha['id']."';}else{false;}\" class='btn btn-danger'>Excluir</button>
                      </td>";
                print "</tr>";

            }

            print "</table>";

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    
