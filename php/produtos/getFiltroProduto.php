<?php
session_start();
include_once('../../conn/index.php');

$id_categoria = $_GET['id_categoria'];
$opcao = $_GET['op'];

$where = "";
if (!empty($id_categoria)) {
    $where .= " WHERE p.id_categoria = $id_categoria";
}

$sql = "SELECT p.*, c.descricao AS categoria FROM produtos AS p INNER JOIN categoria AS c ON p.id_categoria = c.id";
$sql .= $opcao == "remove" ? "" : $where;
$res = mysqli_query($conn, $sql);
?>

<div class="table-responsive">
    <table class="table" id="dataTableProduto" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Categoria</th>
                <th scope="col">Preço</th>
                <th scope="col">QTD. Estoque</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?= $row['nome'] ?></td>
                    <td><?= $row['categoria'] ?></td>
                    <td>R$<?= $row['preco'] ?></td>
                    <td><?= $row['qtd_estoque'] . $row['unidade_medida'] ?></td>
                    <td class="text-center">
                        <a href="#" onclick="edit('<?= $row['cod'] ?>')"><i class="far fa-edit"></i></a>
                        <a href="#" onclick="deleteProduto('<?= $row['cod'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#dataTableProduto').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
    })
</script>