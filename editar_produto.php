<h2>Editar Produto</h2>
<?php
    $sql = "SELECT * FROM produto WHERE id=".$_REQUEST["id"];
    $res = $conn->query($sql);
    $linha = $res->fetch(PDO::FETCH_ASSOC);
?>
<form action="./controller/update.php" method="post" id="formUpdate">
    <input type="hidden" name="id" value="<?= $linha['id']?>">
    <div class="form-group col-5">
        <label for="modeloProduto">Nome do Produto</label> 
        <input type="text" id="modeloProduto" maxlength="45" class="form-control" name="modelo" value="<?= $linha['modelo_produto']?>" required>
    </div>

    <div class="form-group mt-5">
        <label for="descricao">Descrição do Produto</label>
        <input id="descricao" maxlength="300" class="form-control" name="descricao" value="<?= $linha['descricao']?>"> </input>
    </div>

    <div class="form-group col-3 mt-5">
        <label for="qntde">Quantidade em Estoque</label> 
        <input type="number" id="qntde" class="form-control" value="<?= $linha['qntde_estoque']?>" name="qntde" required>
    </div>

    <div class="form-group mt-5">
        <label for="ativo">Ativo?</label> 
        <input type="checkbox" id="ativo" name="ativo" value="<?= $linha['ativo']?>" class="form-check-input">
    </div>

    <button type="submit" class="btn btn-primary mt-5">Editar</button>

</form>