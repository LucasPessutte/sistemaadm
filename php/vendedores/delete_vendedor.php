<?php
session_start();
include_once('../../conn/index.php');

$id_vendedor = $_POST['id_vendedor_delete'];

$sql_delete = "SELECT * FROM vendas WHERE id_vendedor = $id_vendedor";
$num_linhas = mysqli_num_rows(mysqli_query($conn, $sql_delete));


if ($num_linhas == 0) {
  $sql = "DELETE FROM vendedor WHERE cod = $id_vendedor";

  $res = mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Vendedor excluido com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  } else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao excluir Vendedor.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
} else {
  $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  O vendedor esta vinculado a uma venda ou mais!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
exit(header("Location: ../../index.html#vendedores"));
