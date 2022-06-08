<?php
session_start();
include_once('../../conn/index.php');

$id_cliente = $_POST['id_produto_edit'];

$id_categoria = $_POST['categoria_edit'];
$nome = $_POST['nome_edit'];
$preco = $_POST['preco_edit'];
$qtd_estoque = $_POST['qtd_estoque'];
$unidade_medida = $_POST['unidade_medida'];

$sql = "UPDATE cliente SET nome = '$nome', cpf = '$cpf', email = '$email', telefone = '$telefone', limite_credito = '$limiteCredito', endereco = '$endereco', cidade = '$cidade', estado = '$estado' WHERE codigo = $id_cliente";
$res = mysqli_query($conn, $sql);


if (mysqli_affected_rows($conn)) {
    $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    Cliente editado com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Erro ao editar cliente.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}
exit(header("Location: ../../index.html#clientes"));
