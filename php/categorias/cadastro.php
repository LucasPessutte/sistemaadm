<?php
    session_start();
    include_once('../../conn/index.php');

    $nome = $_POST['nome'];

    $sql = "INSERT INTO categoria(descricao) VALUES('$nome');";
    $res = mysqli_query($conn, $sql);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Categoria cadastrada com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }else{
      $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
      Erro ao cadastrar categoria!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    exit(header("Location: ../../index.html#categorias"));
