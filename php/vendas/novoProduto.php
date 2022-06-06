<?php
include_once('../../conn/index.php');   

$sql = "SELECT * FROM produtos";
$res_produtos = mysqli_query($conn, $sql);
$prox_id = $_GET['prox_produto'];
?>


<div class="row produtos pb-3" id="produtos-<?= $prox_id ?>">
    <div class="col-4">
        <select name="id_produto_<?= $prox_id ?>" id="id_produto_<?= $prox_id ?>" onchange="selecionaProduto(this)" class="form-control" required>
            <option value="">Selecione um produto</option>
            <?php while ($row = mysqli_fetch_array($res_produtos)) { ?>
                <option value="<?= $row['cod'] ?>"><?= $row['nome'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-2">
        <input id="preco_produto_<?= $prox_id ?>" type="text" disabled class="form-control">
    </div>
    <div class="col-4">
        <input type="number" id="qtd_produto_<?= $prox_id ?>" onchange="altera_valor_final()" name="qtd_produto_<?= $prox_id ?>" min="1" step="1" class="form-control">
    </div>
    <div class="col-2">
        <div class="btn btn-primary" id="button_plus" onclick="removeProduto(this, <?= $prox_id ?>)"><i class="fas fa-minus"></i></div>
    </div>
</div>