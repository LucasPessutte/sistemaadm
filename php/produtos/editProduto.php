<?php
session_start();
include_once('../../conn/index.php');

$id_produto = $_POST['id_produto_edit'];

$id_categoria = $_POST['categoria_edit'];
$nome = $_POST['nome_edit'];
$preco = $_POST['preco_edit'];
$qtd_estoque = $_POST['qtd_estoque_edit'];
$unidade_medida = $_POST['unidade_medida_edit'];

$sql = "UPDATE 
          produtos 
        SET 
          id_categoria = $id_categoria,
          nome = '$nome',
          preco = '$preco',
          qtd_estoque = $qtd_estoque,
          unidade_medida = '$unidade_medida'
        WHERE cod = $id_produto";
$res = mysqli_query($conn, $sql);


if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Produto editado com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao editar produto.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}
exit(header("Location: ../../index.html#produtos"));
