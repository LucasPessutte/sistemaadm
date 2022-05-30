<?php
session_start();
include_once('../../conn/index.php');

$id_venda = $_POST['id_venda_edit'];

$id_vendedor = $_POST['id_vendedor_edit'];
$id_cliente = $_POST['id_cliente_edit'];
$data = $_POST['data_edit'];
$prazo_pagto = $_POST['prazo_pagto_edit'];
$cond_pagto = $_POST['cond_pagto_edit'];

$sql = "UPDATE vendas SET id_vendedor = '$id_vendedor', id_cliente = '$id_cliente', data = '$data', prazo_pagto = '$prazo_pagto', cond_pagto = '$cond_pagto' WHERE numero = $id_venda";
$res = mysqli_query($conn, $sql);


if (mysqli_affected_rows($conn)) {
  $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Venda editado com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
  $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao editar venda.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}
exit(header("Location: ../../index.html#vendas"));
