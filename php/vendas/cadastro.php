<?php
    session_start();
    include_once('../../conn/index.php');

    // var_dump($_POST);

    $id_vendedor = $_POST['id_vendedor'];
    $id_cliente = $_POST['id_cliente'];
    $data = $_POST['data'];
    $prazo_pagto = $_POST['prazo_pagto'];
    $cond_pagto = $_POST['cond_pagto'];

    $qtd_produtos = $_POST['qtd_produtos'];

    $sql = "INSERT INTO vendas(id_vendedor,id_cliente,data,prazo_pagto,cond_pagto) VALUES('$id_vendedor', '$id_cliente', '$data', '$prazo_pagto', '$cond_pagto');";
    $res = mysqli_query($conn, $sql);
    $ultimo_id_venda = mysqli_insert_id($conn);

    if($ultimo_id_venda !== 0 && $ultimo_id_venda !== null){
      for($i = 1; $i <= $qtd_produtos; $i++){
        if(array_key_exists('id_produto_' . $i,$_POST)){
          $sql_intens_venda = "INSERT INTO intens_vendas(id_produto, id_venda, quant_vendida) VALUES (" . $_POST['id_produto_' . $i] . "," . $ultimo_id_venda . "," . $_POST['qtd_produto_' . $i] . ")";
          $res = mysqli_query($conn, $sql_intens_venda);

          echo $sql_update_produtos = "UPDATE produtos SET qtd_estoque = qtd_estoque - " . $_POST['qtd_produto_' . $i] . " WHERE cod = " . $_POST['id_produto_' . $i];
          mysqli_query($conn, $sql_update_produtos);
        }else{
          $qtd_produtos++;
        }
      } 
    }

    
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
