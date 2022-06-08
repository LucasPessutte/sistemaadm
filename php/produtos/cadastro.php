<?php
    session_start();
    include_once('../../conn/index.php');

    $id_categoria = $_POST['id_categoria'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $qtd_estoque = $_POST['qtd_estoque'];
    $unidade_medida = $_POST['unidade_medida'];

    $sql = "INSERT INTO produtos(id_categoria,nome,preco,qtd_estoque,unidade_medida) VALUES($id_categoria,'$nome', '$preco', $qtd_estoque, '$unidade_medida');";
    $res = mysqli_query($conn, $sql);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Produto cadastrado com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }else{
      $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
      Erro ao cadastrar produto!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    exit(header("Location: ../../index.html#produtos"));
