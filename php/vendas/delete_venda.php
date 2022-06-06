<?php
session_start();
include_once('../../conn/index.php');

$id_venda = $_POST['id_venda_delete'];

$sql = "DELETE FROM vendas WHERE numero = $id_venda";

$res = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Venda excluida com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao excluir Venda.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}
exit(header("Location: ../../index.html#vendas"));
