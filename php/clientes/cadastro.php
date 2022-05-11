<?php
    session_start();
    include_once('../../conn/index.php');

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['celular'];
    $limiteCredito = $_POST['limiteCredito'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO cliente(nome,endereco,telefone,limite_credito,cidade,estado,email,cpf) VALUES('$nome', '$endereco','$telefone', '$limiteCredito', '$cidade', '$estado', '$email', '$cpf');";
    $res = mysqli_query($conn, $sql);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Oloco, meu!</strong> Olha esse alerta animado, como é chique!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      exit(header("Location: ../../index.html#clientes"));
    }

?>