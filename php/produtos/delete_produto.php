<?php
session_start();
include_once('../../conn/index.php');

$id_produto = $_POST['id_produto_delete'];

$sql = "SELECT * FROM intens_vendas WHERE id_produto = $id_produto";
$produtos = mysqli_num_rows(mysqli_query($conn, $sql));

if ($produtos == 0) {

    $sql = "DELETE FROM produtos WHERE cod = $id_produto";
    $res = mysqli_query($conn, $sql);


    if (mysqli_affected_rows($conn)) {
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Produto excluido com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Erro ao excluir produto.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Produto vinculado a uma venda ou mais!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
exit(header("Location: ../../index.html#produtos"));
