<?php
session_start();
include_once('../../conn/index.php');

$id_vendedor = $_POST['id_vendedor_delete'];

echo $id_vendedor;

$sql = "DELETE FROM vendedor WHERE cod = $id_vendedor";

echo $sql;
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
exit(header("Location: ../../index.html#vendedores"));
