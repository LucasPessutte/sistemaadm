<?php
session_start();
include_once('../../conn/index.php');

$nome_cliente = $_GET['nome_cliente'];
$opcao = $_GET['op'];

$where = "";
if (!empty($nome_cliente)) {
    $where = "WHERE nome LIKE '%$nome_cliente%'";
}

$where;

$sql = $opcao == "remove" ? "SELECT * FROM cliente" : "SELECT * FROM cliente $where";
$res = mysqli_query($conn, $sql);
?>

<div class="table-responsive">
    <table class="table" id="dataTableClient" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">CPF</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Cidade</th>
                <th scope="col">Estado</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?= $row['cpf'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['cidade'] ?></td>
                    <td><?= $row['estado'] ?></td>
                    <td class="text-center">
                        <a href="#" onclick="edit('<?= $row['codigo'] ?>')"><i class="far fa-edit"></i></a>
                        <a href="#" onclick="deleteCliente('<?= $row['codigo'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#dataTableClient').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
    })
</script>