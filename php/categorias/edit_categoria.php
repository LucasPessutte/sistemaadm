<?php
session_start();
include_once('../../conn/index.php');

$id_categoria = $_POST['id_categoria_edit'];
$nome = $_POST['nome_edit'];

$sql = "UPDATE categoria SET descricao = '$nome' WHERE id = $id_categoria";
$res = mysqli_query($conn, $sql);

echo $sql;

if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Categoria editada com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao editar categoria.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}
exit(header("Location: ../../index.html#categorias"));
