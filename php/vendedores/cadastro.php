<?php
    session_start();
    include_once('../../conn/index.php');

    $nome = $_POST['nome'];
    $telefone = $_POST['celular'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $porcentagemVenda = $_POST['porcentagemVenda'];

    $sql = "INSERT INTO vendedor(nome,endereco,cidade,estado,telefone,porc_comissao) VALUES('$nome', '$endereco', '$cidade', '$estado', '$telefone', '$porcentagemVenda');";
    $res = mysqli_query($conn, $sql);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Vendedor cadastrado com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }else{
      $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
      Erro ao cadastrar vendedor!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    exit(header("Location: ../../index.html#vendedores"));
