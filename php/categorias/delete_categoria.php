<?php
session_start();
include_once('../../conn/index.php');

$id_categoria = $_POST['id_categoria_delete'];


$sql_consulta = "SELECT cod FROM produtos WHERE id_categoria = $id_categoria";
$res_consulta = mysqli_query($conn, $sql_consulta);

if (mysqli_num_rows($res_consulta) <= 0) {


    $sql = "DELETE FROM categoria WHERE id = $id_categoria";
    $res = mysqli_query($conn, $sql);


    if (true) {
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Categoria excluida com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao excluir Categoria.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    }

} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Categoria está relacionada a um ou mais produtos.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}

exit(header("Location: ../../index.html#categorias"));
