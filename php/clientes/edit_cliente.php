<?php
session_start();
include_once('../../conn/index.php');

$id_cliente = $_POST['id_cliente_edit'];

$nome = $_POST['nome_edit'];
$cpf = $_POST['cpf_edit'];
$email = $_POST['email_edit'];
$telefone = $_POST['celular_edit'];
$limiteCredito = $_POST['limiteCredito_edit'];
$endereco = $_POST['endereco_edit'];
$cidade = $_POST['cidade_edit'];
$estado = $_POST['estado_edit'];

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
