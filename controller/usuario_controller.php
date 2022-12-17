<?php

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';

    include ($entityPath . "usuario.php");

    include ($modelPath . "usuario_model.php");

    class UsuarioController
    {

        /* ========================================================= Cadastro ========================================================= */
        


        function atualizaUsuario() {
            $model = new UsuarioModel;

                $usuario = new Usuario;

                $id = $_POST['id'];
                $ativo = 0;
                if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                    $ativo = 1;
                }
                $usuarioDti = 0;
                if (isset($_POST['usuarioDti']) && strtolower($_POST['usuarioDti']) == 'on'){
                    $usuarioDti = 1;
                }
                $senha = null;
                if (isset($_POST['senha']) && strlen($_POST['senha']) > 0){
                    $senha = MD5($_POST['senha']);
                }    

                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $email = $_POST['email'];

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
                $usuario->setAtivo($ativo);
                $usuario->setId($id);
                $usuario->setUsuarioDti($usuarioDti);
                if ($senha != null) {
                    $usuario->setSenha($senha);
                }

                try {
                    if ($senha != null) {
                        $model->updateComSenha($usuario);
                    } else {
                        $model->updateSemSenha($usuario);
                    }

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
        }

        function cadastraUsuario() {
            $model = new UsuarioModel;

            $newUsuario = new Usuario;

            $newAtivo = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $newAtivo = 1;
            }
            $newUsuarioDti = 0;
            if (isset($_POST['usuarioDti']) && strtolower($_POST['usuarioDti']) == 'on'){
                $newUsuarioDti = 1;
            }
            $newNome = $_POST['nome'];
            $newCpf = $_POST['cpf'];
            $newEmail = $_POST['email'];
            $newSenha = MD5($_POST['senha']);

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
            $newUsuario->setUsuarioDti($newUsuarioDti);

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

        function buscaUsuario() {
            $model = new UsuarioModel;

            $id = $_GET['id'];
            try {
                $usuario = $model->findById($id);

                return $usuario;

            } catch (PDOException $e) {
                echo "<div class='container alert alert-danger mt-5'>Não foi possível recuperar o registro! Erro de banco de dados.</div>";
            }
        }

        function exibeDiretoria() {
            $model = new UsuarioModel;

            $diretorias  = $model->selectDiretoria();

            if (isset($_GET['id'])){
                $usuario = $this->buscaUsuario();
            }

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
        }

        function exibeDivisao() {
            $model = new UsuarioModel;
            
            $divisoes  = $model->selectDivisao();

            if (isset($_GET['id'])){
                $usuario = $this->buscaUsuario();
            }

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
        }

        /* ========================================================= Pesquisa ========================================================= */



        function excluiUsuario() {
            $model = new UsuarioModel;
            $usuario = new Usuario;
            $usuario = $model->findById($_GET['delete']);
            $cpf = $usuario ->getCpf();

            if ($_SESSION['cpf'] == $cpf){
                echo "<div class='alert alert-danger'>Não pode excluir o usuário em que está logado!</div>";
            } else {
                try{
                    
                    $model ->delete($_REQUEST["delete"]);
                    echo "<div class='alert alert-success'>Usuário excluído com sucesso</div>";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "fk_entrega_usuario")) {
                        echo "<div class='alert alert-danger'>Não foi possível excluir o usuário, pois o usuário possui solicitações cadastradas, deixe o usuário como inativo caso necessário</div>"; 
                    } else {
                        echo "<div class='alert alert-danger'>Não foi possível excluir o usuário, erro de banco de dados</div>";
                    }
                }
            }
        }

        function exibePesquisa() {
            $model = new UsuarioModel;
                    
            $pesquisa = $_GET['pesquisa'];

            $usuario = $model->findByName($pesquisa);

            print "<h1>Usuários cadastrados com nome: \"".$pesquisa."\"</h1>";

            if ($usuario == null ) {
            ?>            
                <h3>Nenhum usuário encontrado!</h3>
                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            } else {
            ?>            
                <table class='container table table-hover table-striped table-bordered text-center'>

                <tr>
                    <th style='display:none;'>id</th>
                    <th class="text-center">Nome</th>
                    <th class="text-center">CPF</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Locação</th>
                    <th class="text-center">Ativo</th>
                    <th class="text-center">Acesso DTI</th>
                    <th class="text-center">Ações</th>
                </tr>
            
                <tr>
                    <td style='display:none;'><?=$usuario->getId()?></td>
                    <td class="text-center"><?=$usuario->getNome()?></td>
                    <td class="text-center"><?=$usuario->getCpf()?></td>
                    <td class="text-center"><?=$usuario->getEmail()?></td>
                    <td class="text-center"><?=($usuario->getDivisaoId() !== 0? $usuario->getDivisaoNome() : $usuario->getDiretoriaNome())?></td>
                    <td class="text-center"><?=($usuario->getAtivo() ? 'Sim' : 'Não')?></td>
                    <td class="text-center"><?=($usuario->getUsuarioDti() ? 'Sim' : 'Não')?></td>
                    <td class="text-center">
                        <a href="cadastro.php?id=<?=$usuario->getId()?>" class='btn btn-success'>Editar</a>
                        <a href="pesquisar.php?delete=<?=$usuario->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                    </td>
                </tr>
            
                </table>

                <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
            }
        }

        function exibeUsuario() {
            ?>        
            <h1>Usuários cadastrados</h1>

            <table class='container table table-hover table-striped table-bordered text-center'>

            <tr>
                <th style='display:none;'>id</th>
                <th class="text-center">Nome</th>
                <th class="text-center">CPF</th>
                <th class="text-center">Email</th>
                <th class="text-center">Locação</th>
                <th class="text-center">Ativo</th>
                <th class="text-center">Acesso DTI</th>
                <th class="text-center">Ações</th>
            </tr>
            <?php        

            $model = new UsuarioModel;

            $usuario = $model->select();
            
            foreach ($usuario as $obj) {
            ?>            
                <tr>
                    <td style='display:none;'><?=$obj->getId()?></td>
                    <td class="text-center"><?=$obj->getNome()?></td>
                    <td class="text-center"><?=$obj->getCpf()?></td>
                    <td class="text-center"><?=$obj->getEmail()?></td>
                    <td class="text-center"><?=($obj->getDiretoriaId() !== 0? $obj->getDiretoriaNome(): $obj->getDivisaoNome())?></td>
                    <td class="text-center"><?=($obj->getAtivo() ? 'Sim' : 'Não')?></td>
                    <td class="text-center"><?=($obj->getUsuarioDti() ? 'Sim' : 'Não')?></td>
                    <td class="text-center">
                        <a href="cadastro.php?id=<?=$obj->getId()?>" class='btn btn-success'>Editar</a>
                        <a href="pesquisar.php?delete=<?=$obj->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                    </td>
                </tr>
            <?php            
            }
            print "</table>";
        }
    }
?>