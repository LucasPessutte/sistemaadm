<?php
session_start();
include_once('../../conn/index.php');

$data1 = $_GET['data1'];
$data2 = $_GET['data2'];

$opcao = $_GET['op'];

$where = "";

if (!empty($data1)) {
    $where .= "WHERE v.data >= '$data1'";
    if (!empty($data2)) {
        $where .= "AND v.data <= '$data2'";
    }
} else if (!empty($data2)) {
    $where .= "WHERE v.data <= '$data2'";
}
$sql = "SELECT 
                v.*, 
                c.nome AS cliente, 
                vd.nome AS vendedor 
            FROM vendas v 
            INNER JOIN cliente AS c ON v.id_cliente = c.codigo 
            INNER JOIN vendedor AS vd ON v.id_vendedor = vd.cod ";
$sql .= $opcao == "remove" ? "" : $where;
$res_vendas = mysqli_query($conn, $sql);
?>


<div class="table-responsive">
    <table class="table" id="dataTableVenda" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Vendedor</th>
                <th scope="col">Cliente</th>
                <th scope="col">Data</th>
                <th scope="col">Prazo de Pagamento</th>
                <th scope="col">Condição de Pagamento</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($res_vendas)) { ?>
                <tr>
                    <td><?= $row['vendedor'] ?></td>
                    <td><?= $row['cliente'] ?></td>
                    <td><?= date('d/m/y', strtotime($row['data'])) ?></td>
                    <td><?= date('d/m/y', strtotime($row['prazo_pagto'])) ?></td>
                    <td><?= $row['cond_pagto'] ?></td>
                    <td class="text-center">
                        <a href="#" onclick="visualizarVenda(<?= $row['numero'] ?>)" class="pl-2"><i class="fas fa-eye"></i></a>
                        <a href="#" onclick="deleteVenda(<?= $row['numero'] ?>)" class="pl-2"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#dataTableVenda').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
    })
</script>