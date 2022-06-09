<?php
include_once('../../conn/index.php');
$id_venda = $_GET['id_venda'];

$sql = "SELECT 
            v.data, 
            v.prazo_pagto, 
            v.cond_pagto, 
            vend.nome as nome_vendedor, 
            c.nome as nome_cliente
        FROM vendas AS v 
        INNER JOIN vendedor AS vend ON v.id_vendedor = vend.cod 
        INNER JOIN cliente AS c ON v.id_cliente = c.codigo
        WHERE numero = $id_venda";
$res = mysqli_query($conn, $sql);

$valor_final = 0;

?>


<?php while ($row = mysqli_fetch_array($res)) {
    $sql_produtos = "SELECT i.quant_vendida, p.nome, p.preco FROM intens_vendas AS i INNER JOIN produtos AS p ON i.id_produto = p.cod WHERE i.id_venda = $id_venda";
    $res_produtos = mysqli_query($conn, $sql_produtos);

    $forma_pagto = $row['cond_pagto'];

?>
    <div class="row row-modal">
        <div class="col-4">
            <label for="">Vendedor</label>
            <input type="text" class="form-control" value="<?= $row['nome_vendedor'] ?>" disabled>
        </div>
        <div class="col-4">
            <label for="">Cliente</label>
            <input type="text" class="form-control" value="<?= $row['nome_cliente'] ?>" disabled>
        </div>
        <div class="col-4">
            <label for="">Data</label>
            <input type="date" class="form-control" value="<?= $row['data'] ?>" disabled>
        </div>
    </div>
    <div class="row row-modal">
        <div class="col-6">
            <label for="">Prazo entrega</label>
            <input type="date" class="form-control" value="<?= $row['prazo_pagto'] ?>" disabled>
        </div>
        <div class="col-6">
            <label for="">Forma pagamento</label>
            <select type="text" name="cond_pagto_view" id="cond_pagto_view" class="form-control" placeholder="Condição de pagamento" disabled>
                <option value="credito">Crédito</option>
                <option value="debito">Débito</option>
                <option value="cheque">Cheque</option>
                <option value="trasferencia">Transferência bancária</option>
                <option value="boleto">Boleto</option>
            </select>
        </div>
    </div>

    <hr>

    <h4>Produtos</h4>

    <div class="row">
        <div class="col-4">
            <label for="">Produto</label>
        </div>
        <div class="col-4">
            <label for="">Preço</label>
        </div>
        <div class="col-4">
            <label for="">Qtd. Produtos</label>
        </div>
    </div>
    <input type="hidden" name="qtd_produtos" id="qtd_produtos" value="1">
    <div id="div-produtos">
        <?php while ($row_p = mysqli_fetch_array($res_produtos)) {
            $valor_final += $row_p['preco'] * $row_p['quant_vendida'];
        ?>
            <div class="row produtos pb-3" id="produtos-1">
                <div class="col-4">
                    <input type="text" class="form-control" value="<?= $row_p['nome'] ?>" disabled>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" value="<?= $row_p['preco'] ?>" disabled>
                </div>
                <div class="col-4">
                    <input type="number" class="form-control" value="<?= $row_p['quant_vendida'] ?>" disabled>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-12">
            <label for="valor-final">Valor total</label>
            <input type="number" class="form-control" step="0.01" value="<?= $valor_final ?>" disabled>
        </div>
    </div>

<?php } ?>

<script>
    $(document).ready(function() {
        var forma_pagto = '<?= $forma_pagto ?>'

        $('#cond_pagto_view').val(forma_pagto)
    })

</script>