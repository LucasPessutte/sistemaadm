<?php
    include_once('../../conn/index.php');    
    $numero = $_GET['id_venda'];
    
    $sql = "SELECT * FROM vendas WHERE numero = $id_venda";
    $res = mysqli_query($conn, $sql);
    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        $data['id_vendedor'] = $row['id_vendedor'];
        $data['id_cliente'] = $row['id_cliente'];
        $data['data'] = $row['data'];
        $data['prazo_entrega'] = $row['prazo_entrega'];
        $data['cond_pagto'] = $row['cond_pagto'];
    }

    $json = json_encode($data);
    echo $json;
    mysqli_close($conn);