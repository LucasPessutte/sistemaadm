<?php
    session_start();
    include_once('../../conn/index.php');

    $id_vendedor = $_POST['id_vendedor'];
    $id_cliente = $_POST['id_cliente'];
    $data = $_POST['data'];
    $prazo_pagto = $_POST['prazo_pagto'];
    $cond_pagto = $_POST['cond_pagto'];

    $sql = "INSERT INTO vendas(id_vendedor,id_cliente,data,prazo_pagto,cond_pagto) VALUES('$id_vendedor', '$id_cliente', '$data', '$prazo_pagto', '$cond_pagto');";
    $res = mysqli_query($conn, $sql);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Venda cadastrada com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }else{
      $_SESSION['msg'] = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
      Erro ao cadastrar venda!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    exit(header("Location: ../../index.html#vendas"));
