<?php

    $entityPath = $_SERVER['DOCUMENT_ROOT'] . '/entity//';

    $modelPath = $_SERVER['DOCUMENT_ROOT'] . '/model//';
            
    include_once ($entityPath . "produto.php");

    include_once ($modelPath . "produto_model.php");

    class ProdutoController 
    {

        /* ========================================================= Cadastro ========================================================= */

        

        function cadastraProduto() {
            $newModel = new ProdutoModel;

            $newProduto = new Produto;

            $ativoOk = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativoOk = 1;
            }
            $newModelo = $_POST['modelo'];
            $newAtivo = $ativoOk;
            $newDescricao = $_POST['descricao'];
            $newQntde = $_POST['qntde'];
            $itens = $_POST['produtosVinculados'];


            $newProduto->setModelo($newModelo);
            $newProduto->setAtivo($newAtivo);
            $newProduto->setDescricao($newDescricao);
            $newProduto->setQntde($newQntde);
            if (strlen(trim($itens)) != 0 ){
                $newProduto?->setItens(explode(",",trim($itens)));        
            } else {
                $newProduto->setItens([]);
            }

            try {
                $newModel->insert($newProduto);
                echo "<div class=' container alert alert-success'>Registro criado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Suprimentos")) {
                    echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro, pois os suprimentos estão em duplicidade!</div>";
                } elseif (str_contains($e->getMessage(), "UC_Modelo")) {
                    echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro, pois o modelo do produto já foi cadastrado</div>";
                } else {
                    echo "<div class=' container alert alert-danger'>Não foi possível salvar o registro! Erro de banco de dados.</div>";
                }
            }
        }

        function atualizaProduto() {
            $model = new ProdutoModel;

            $produto = new Produto;

            $ativook = 0;
            if (isset($_POST['ativo']) && strtolower($_POST['ativo']) == 'on'){
                $ativook = 1;
            }
            $modelo = $_POST['modelo'];
            $ativo = $ativook;
            $descricao = $_POST['descricao'];
            $qntde = $_POST['qntde'];
            $id = $_REQUEST['id'];
            $itens = $_POST['produtosVinculados'];

            $produto->setModelo($modelo);
            $produto->setAtivo($ativo);
            $produto->setDescricao($descricao);
            $produto->setQntde($qntde);
            $produto->setId($id);  

            if (strlen(trim($itens)) != 0 ){
                $produto?->setItens(explode(",",trim($itens)));        
            } else {
                $produto->setItens([]);
            }

            try {
                $model->update($produto);
                echo "<div class='container alert alert-success mt-5'>Registro atualizado com sucesso!</div>";
            } catch (PDOException $e) {
                if (str_contains($e->getMessage(), "UC_Modelo")) {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar o registro, pois o modelo do produto já foi cadastrado</div>";
                } else {
                    echo "<div class='container alert alert-danger mt-5'>Não foi possível atualizar o registro! Erro de banco de dados</div>";
                }
            }
        }

        /* ========================================================= Pesquisa ========================================================= */



        function exibePesquisa() {
            $model = new ProdutoModel;
                    
                    $pesquisa = $_GET['pesquisa'];

                    $produto = $model->findByName($pesquisa);

                    print "<h1>Órgãos cadastrados com nome: \"".$pesquisa."\"</h1>";

                    if ($produto == null ) {
            ?>            
                        <h3>Nenhum órgão encontrado!</h3>
                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    } else {
            ?>            
                        <table class='container table table-hover table-striped table-bordered text-center'>

                        <tr>
                            <th style='display:none;'>id</th>
                            <th>Modelo</th>
                            <th>Ativo</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    
                        <tr>
                        <td style='display:none;'><?=$produto->getId()?> </td>
                        <td><?=$produto->getModelo()?> </td>
                        <td><?=($produto->getAtivo() ? 'Sim' : 'Não')?> </td>
                        <td><?=$produto->getDescricao()?> </td>
                        <td><?=$produto->getQntde()?> </td>
                        <td>
                            <a href="cadastro.php?id="<?=$produto->getId()?> class='btn btn-success'>Editar</a>
                            <a href="pesquisar.php?delete="<?=$produto->getId()?> class='btn btn-danger excluir'>Excluir</a>
                                </td>
                        </tr>
                    
                        </table>

                        <a class='btn btn-light' href='pesquisar.php'>Voltar para Home</a>
            <?php            
                    }
        }

        function exibeProduto() {
            ?>        
                    <h1>Produtos cadastrados</h1>

                    <table class='container table table-hover table-striped table-bordered text-center'>

                    
                        <tr>
                            <th style='display:none;'>#</th>
                            <th>Modelo</th>
                            <th>Ativo</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
            <?php        

                    $model = new ProdutoModel;

                    $produto = $model->select();
                    
                    foreach ($produto as $obj) {
            ?>            
                        <tr>
                        <td style='display:none;'><?=$obj->getId()?></td>
                        <td><?=$obj->getModelo()?></td>
                        <td><?=($obj->getAtivo() ? 'Sim' : 'Não')?></td>
                        <td><?=$obj->getDescricao()?></td>
                        <td><?=$obj->getQntde()?></td>

                        <td>
                            <a href="cadastro.php?id=<?=$obj->getId()?>" class='btn btn-success'>Editar</a>
                            <a href="pesquisar.php?delete=<?=$obj->getId()?>" class='btn btn-danger excluir'>Excluir</a>
                                </td>
                        </tr>
            <?php            
                    }
                    print "</table>";
        }

        function excluiProduto() {
            try{
                $model = new ProdutoModel;
                $model ->delete($_REQUEST["delete"]);
                echo "<div class='alert alert-success'>Registro excluído com sucesso</div>";
            } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), "fk_propritario")) {
                        echo "<div class='alert alert-danger'>Não foi possível excluir o registro pois o produto possui outros vinculados!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Não foi possível excluir o registro! Erro de banco de dados</div>";
                    }
            }
        }
    }
?>