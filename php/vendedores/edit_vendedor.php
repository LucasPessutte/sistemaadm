<?php
session_start();
include_once('../../conn/index.php');

$id_vendedor = $_POST['id_vendedor_edit'];

$nome = $_POST['nome_edit'];
$endereco = $_POST['endereco_edit'];
$cidade = $_POST['cidade_edit'];
$estado = $_POST['estado_edit'];
$telefone = $_POST['celular_edit'];
$porcentagemVenda = $_POST['porcentagemVenda_edit'];

$sql = "UPDATE vendedor SET nome = '$nome', telefone = '$telefone', porc_comissao = '$porcentagemVenda', endereco = '$endereco', cidade = '$cidade', estado = '$estado' WHERE cod = $id_vendedor";
$res = mysqli_query($conn, $sql);


if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Vendedor editado com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao editar vendedor.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}
exit(header("Location: ../../index.html#vendedores"));
